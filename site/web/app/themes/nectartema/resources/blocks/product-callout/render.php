<?php

$image = get_field('product_callout_image');
$title = get_field('product_callout_title');
$text  = get_field('product_callout_text');
$link  = get_field('product_callout_link');

if (! $image && ! $title && ! $text && empty($link['url'])) {
    return;
}

$link_url = $link['url'] ?? '';

$link_title = ! empty($link['title'])
    ? $link['title']
    : __('Conheça o produto', 'nectar');

$link_target = $link['target'] ?? '_self';

$heading_id = wp_unique_id('product-callout-title-');

?>

<aside
    <?php echo get_block_wrapper_attributes([
        'class' => 'product-callout',
    ]); ?>
    aria-labelledby="<?php echo esc_attr($heading_id); ?>">

    <?php if ($image) : ?>
        <div class="product-callout__media">
            <?php
            echo wp_get_attachment_image(
                (int) $image,
                'medium_large',
                false,
                [
                    'class' => 'product-callout__image',
                ]
            );
            ?>
        </div>
    <?php endif; ?>

    <div class="product-callout__content">

        <?php if ($title) : ?>
            <h3 id="<?php echo esc_attr($heading_id); ?>"
                class="product-callout__title">
                <?php echo esc_html($title); ?>
            </h3>
        <?php endif; ?>

        <?php if ($text) : ?>
            <div class="product-callout__text">
                <?php echo wpautop(esc_html($text)); ?>
            </div>
        <?php endif; ?>

        <?php if ($link_url) : ?>
            <a
                href="<?php echo esc_url($link_url); ?>"
                target="<?php echo esc_attr(! empty($link_target) ? $link_target : '_self'); ?>"
                class="product-callout__link"
                <?php if ($link_target === '_blank') : ?>
                rel="noopener noreferrer"
                <?php endif; ?>><?php echo esc_html($link_title); ?></a>
        <?php endif; ?>

    </div>

</aside>