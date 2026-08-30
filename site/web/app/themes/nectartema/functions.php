<?php

use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
    ->withProviders([
        App\Providers\ThemeServiceProvider::class,
    ])
    ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


add_shortcode('botao_checkout', function ($atts) {
    $atts = shortcode_atts([
        'id' => '',
        'texto' => 'Comprar Agora',
        'valor' => ''
    ], $atts);

    $url = wc_get_checkout_url() . '?add-to-cart=' . esc_attr($atts['id']);

    return sprintf(
        '<div class="my-6 text-center">
            <a href="%s" class="inline-block bg-amber-600 text-white font-bold py-4 px-8 rounded-xl shadow-md hover:bg-amber-700 transition">%s %s</a>
        </div>',
        esc_url($url),
        esc_html($atts['texto']),
        $atts['valor'] ? 'por ' . esc_html($atts['valor']) : ''
    );
});

// 1. Substitui o texto estático de quantidade por um input numérico no checkout
add_filter('woocommerce_checkout_cart_item_quantity', function($product_quantity, $cart_item, $cart_item_key) {
    $_product = $cart_item['data'];

    // Se o produto estiver marcado como "Vender individualmente", mantém estático
    if ($_product->is_sold_individually()) {
        return $product_quantity;
    }

    $input = woocommerce_quantity_input([
        'input_name'  => "cart[{$cart_item_key}][qty]",
        'input_value' => $cart_item['quantity'],
        'max_value'   => $_product->get_max_purchase_quantity(),
        'min_value'   => '0',
        'classes'     => ['cart_item_qty_input', 'w-16', 'p-1', 'text-center', 'border', 'rounded'],
    ], $_product, false);

    return $input;
}, 10, 3);

// 2. Dispara o AJAX do WooCommerce para atualizar os totais ao mudar a quantidade
add_action('wp_footer', function() {
    if (!is_checkout()) return;
    ?>
    <script>
    jQuery(function($) {
        $(document.body).on('change', 'input.cart_item_qty_input', function() {
            var $input = $(this);
            var cart_item_key = $input.attr('name').replace('cart[', '').replace('][qty]', '');
            var new_qty = $input.val();

            $.ajax({
                type: 'POST',
                url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'set_cart_qty'),
                data: {
                    cart_item_key: cart_item_key,
                    qty: new_qty
                },
                success: function() {
                    $(document.body).trigger('update_checkout');
                }
            });
        });
    });
    </script>
    <?php
});

// 3. Endpoint AJAX para processar a alteração do carrinho no checkout
add_action('wc_ajax_set_cart_qty', function() {
    if (isset($_POST['cart_item_key']) && isset($_POST['qty'])) {
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        $qty = wc_stock_amount($_POST['qty']);

        if ($qty == 0) {
            WC()->cart->remove_cart_item($cart_item_key);
        } else {
            WC()->cart->set_quantity($cart_item_key, $qty, true);
        }
        wp_die();
    }
});