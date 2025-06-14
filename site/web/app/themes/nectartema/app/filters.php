<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Ver mais', 'sage'));
});

// New navigation menu
add_filter('sage/blade/data', function ($data) {
    $data['primary_navigation'] = \Log1x\Navi\Facades\Navi::build('primary_navigation')->toArray();
    return $data;
  });

/**
* Woocommerce filters
**/

// shop page
add_filter('woocommerce_product_add_to_cart_text', function ($text) {
  return __('Comprar', 'sage');
});

// single product page
add_filter('woocommerce_product_single_add_to_cart_text', function ($text) {
  return __('Comprar', 'sage');
});

add_filter('woocommerce_product_related_products_heading', function ($text) {
  return __('Você pode comprar também:', 'sage');
});

add_filter('woocommerce_default_address_fields', function ($fields) {
    $fields['postcode']['required'] = true;
    $fields['postcode']['placeholder'] = 'Digite seu CEP';
    return $fields;
});

remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);

add_action('woocommerce_proceed_to_checkout', function () {
    echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">' . __('Finalizar Compra', 'sage') . '</a>';
}, 20);



// add_filter('woocommerce_default_address_fields', function ( $address_fields ) {
//     $address_fields['postcode']['placeholder'] = 'Digite seu CEP';
//     return $address_fields;
// }, 20, 1);


// Remove all possible fields
// add_filter( 'woocommerce_checkout_fields', function($fields) {
//     // Billing fields
//     unset( $fields['billing']['billing_state'] );
//     unset( $fields['billing']['billing_address_1'] );
//     unset( $fields['billing']['billing_address_2'] );
//     unset( $fields['billing']['billing_city'] );
//     unset( $fields['billing']['billing_postcode'] );
//     unset( $fields['billing']['billing_country'] );
  
//     // Shipping fields
//     unset( $fields['shipping']['shipping_state'] );
//     unset( $fields['shipping']['shipping_address_1'] );
//     unset( $fields['shipping']['shipping_address_2'] );
//     unset( $fields['shipping']['shipping_city'] );
//     unset( $fields['shipping']['shipping_postcode'] );
//     unset( $fields['shipping']['shipping_country'] );
  
//     return $fields;
//   });
