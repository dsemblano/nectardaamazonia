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
            <a href="%s" class="inline-block bg-melescuro px-4 py-4 rounded-lg text-lg font-bold hover:scale-105 transition-transform duration-300 ease-in-out text-white! hover:no-underline!  border-mel border-2 hover:shadow-lg">%s %s</a>
        </div>',
        esc_url($url),
        esc_html($atts['texto']),
        $atts['valor'] ? 'por ' . esc_html($atts['valor']) : ''
    );
});