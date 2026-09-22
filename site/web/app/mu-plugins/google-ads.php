<?php

namespace App;

add_action('wp_head', function (): void {
    if (is_admin()) {
        return;
    }

    ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4RDPL3WYS9"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-4RDPL3WYS9');
    </script>
    <?php
});
