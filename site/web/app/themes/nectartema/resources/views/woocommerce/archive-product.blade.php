{{--
  The Template for displaying product archives, including the main shop page which is a post type archive

  This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

  HOWEVER, on occasion WooCommerce will need to update template files and you
  (the theme developer) will need to copy the new files to your theme to
  maintain compatibility. We try to do this as little as possible, but it does
  happen. When this occurs the version of the template file will be bumped and
  the readme will list any important changes.

  @see https://docs.woocommerce.com/document/template-structure/
  @package WooCommerce/Templates
  @version 3.4.0
  --}}

@extends('layouts.app')

@section('content')
    @php
        do_action('get_header', 'shop');
        do_action('woocommerce_before_main_content');
    @endphp
     
        <section id="shop" class="woocommerce w-full">

            @php
                do_action('woocommerce_archive_description');
            @endphp

            @if (woocommerce_product_loop())
                
                <div id="shop_products" class="products-archive-container container">
                    
                    {{-- @php do_action('woocommerce_before_shop_loop'); @endphp --}}

                    <div class="products grid grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-4 mb-6">
                        @while(have_posts()) 
                            @php 
                                the_post();
                                $product = wc_get_product(get_the_ID()); 
                            @endphp
                            
                            <x-product-card :product="$product" />
                        @endwhile
                    </div>

                    @php do_action('woocommerce_after_shop_loop'); @endphp
                </div>
            @else
                @php do_action('woocommerce_no_products_found'); @endphp
            @endif

            @php
                do_action('woocommerce_after_main_content');
                do_action('get_sidebar', 'shop');
                do_action('get_footer', 'shop');
            @endphp

        </section>


@endsection