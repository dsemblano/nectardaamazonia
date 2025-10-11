<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    register_nav_menus([
        'footer_navigation' => __('Footer Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

// Woocommerce customizations

add_action( 'wp_enqueue_scripts', function() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // Allow assets only on Woo pages
    if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {

        global $wp_styles, $wp_scripts;

        // Dequeue all WooCommerce styles
        foreach ( $wp_styles->queue as $handle ) {
            if ( strpos( $handle, 'woocommerce' ) !== false || strpos( $handle, 'wc-blocks' ) !== false ) {
                wp_dequeue_style( $handle );
            }
        }

        // Dequeue all WooCommerce scripts
        foreach ( $wp_scripts->queue as $handle ) {
            if ( strpos( $handle, 'woocommerce' ) !== false || strpos( $handle, 'wc-blocks' ) !== false || strpos( $handle, 'wc-' ) === 0 ) {
                wp_dequeue_script( $handle );
            }
        }
    }
}, 99 );


// Remove brands.css woocommerce
add_action( 'wp_enqueue_scripts', function() {
wp_deregister_style('brands-styles');
});

// onload trick

/**
 * Make all Vayu Blocks CSS load asynchronously (non-render-blocking)
 * Compatible with Bedrock structure (app/plugins/vayu-blocks)
 */

/**
 * Optimize Vayu Blocks: load CSS & JS asynchronously
 * Works with Bedrock structure (/app/plugins/vayu-blocks)
 */


/**
 * app/mu-plugins/vayu-assets-optimize.php
 * Bedrock-friendly: optimize Vayu Blocks assets with resource hints + async loading
 */

if ( ! is_admin() ) {

    // 1) Convert Vayu CSS links to preload + onload (non-blocking)
    add_filter( 'style_loader_tag', function ( $html, $handle ) {
        if ( strpos( $html, 'vayu-blocks/' ) !== false ) {
            $html = str_replace(
                "rel='stylesheet'",
                "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
                $html
            );
        }
        return $html;
    }, 10, 2 );

    // 2) Defer Vayu JS
    add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
        if ( $src && strpos( $src, 'vayu-blocks/' ) !== false ) {
            // keep attributes simple and consistent
            $tag = '<script src="' . esc_url( $src ) . '" defer></script>' . "\n";
        }
        return $tag;
    }, 10, 3 );


    // 3) Add resource hint (preconnect) for the plugin origin so the browser can start TCP/TLS early
    add_filter( 'wp_resource_hints', function ( $hints, $relation_type ) {
        if ( $relation_type === 'preconnect' ) {
            // base public URL for Vayu Blocks (Bedrock path used earlier)
            $plugin_public = content_url( '/../app/plugins/vayu-blocks/public/' );

            $parsed = parse_url( $plugin_public );
            if ( $parsed && ! empty( $parsed['scheme'] ) && ! empty( $parsed['host'] ) ) {
                $origin = $parsed['scheme'] . '://' . $parsed['host'];

                if ( ! in_array( $origin, $hints, true ) ) {
                    $hints[] = $origin;
                }
            }
        }
        return $hints;
    }, 10, 2 );


    // 4) Preload Vayu JS files (index.js) early and auto-generate <noscript> CSS fallbacks.
    add_action( 'wp_head', function () {
        $plugin_dir  = WP_CONTENT_DIR . '/../app/plugins/vayu-blocks/public/build/block/';
        $plugin_url  = content_url( '/../app/plugins/vayu-blocks/public/build/block/' );

        if ( ! is_dir( $plugin_dir ) ) {
            return;
        }

        // --- Preload JS files (so fetch starts early) ---
        $js_files = glob( $plugin_dir . '*/index.js' );
        if ( ! empty( $js_files ) ) {
            foreach ( $js_files as $file ) {
                $relative = str_replace( $plugin_dir, '', $file );
                $ver      = @filemtime( $file ) ?: time();
                $href     = esc_url( $plugin_url . $relative . '?ver=' . $ver );

                // preload JS (we still defer execution via script_loader_tag)
                printf( "<link rel=\"preload\" href=\"%s\" as=\"script\">\n", $href );
            }
        }

        // --- Noscript CSS fallbacks for all Vayu block CSS files ---
        $css_files = glob( $plugin_dir . '*/style-index.css' );
        if ( ! empty( $css_files ) ) {
            echo "<noscript>\n";
            foreach ( $css_files as $file ) {
                $relative = str_replace( $plugin_dir, '', $file );
                $ver      = @filemtime( $file ) ?: time();
                $href     = esc_url( $plugin_url . $relative . '?ver=' . $ver );
                echo '<link rel="stylesheet" href="' . $href . '">' . "\n";
            }
            echo "</noscript>\n";
        }
    } );
}



add_action('wp_head', function () {
    echo '<noscript><link rel="stylesheet" href="' . plugin_dir_url(WP_PLUGIN_DIR . '/vayu-blocks/public/build/block/image/style-index.css') . '?ver=0.2.0"></noscript>';
});

// Disable jquery

add_action('wp_enqueue_scripts', function () {
    // Remove jQuery on the frontend only
    if (!is_admin() && !is_customize_preview()) {
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-core');
        wp_deregister_script('jquery-migrate');
    }
}, 100);
