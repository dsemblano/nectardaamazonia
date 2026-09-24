<?php
/**
 * Plugin Name: Video Watch Pages for WordPress
 * Description: Creates dedicated /video/ watch pages for self-hosted videos embedded in posts, with VideoObject JSON-LD and optional automatic watch-page links.
 * Version: 1.0.2
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Author: Custom
 * License: GPL-2.0-or-later
 * Text Domain: video-watch-pages
 */

defined('ABSPATH') || exit;

final class VWP_Video_Watch_Pages {
    private const VERSION = '1.0.1';
    private const POST_TYPE = 'vwp_video';
    private const OPTION_ADD_LINKS = 'vwp_add_watch_links';
    private const META_VIDEO_URL = '_vwp_video_url';
    private const META_THUMBNAIL_URL = '_vwp_thumbnail_url';
    private const META_DESCRIPTION = '_vwp_description';
    private const META_DURATION = '_vwp_duration';
    private const META_SOURCE_IDS = '_vwp_source_post_ids';
    private const META_ORIGINAL_VIDEO_URL = '_vwp_original_video_url';

    private static ?self $instance = null;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'register_meta_box']);
        add_action('save_post_' . self::POST_TYPE, [$this, 'save_meta'], 10, 2);
        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_post_vwp_scan_posts', [$this, 'handle_scan']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_filter('the_content', [$this, 'inject_watch_links'], 25);
        add_filter('vwp_watch_video_html', [$this, 'filter_watch_video_html'], 10, 2);
        add_filter('vwp_supported_extensions', [$this, 'filter_supported_extensions']);
        add_filter('manage_' . self::POST_TYPE . '_posts_columns', [$this, 'columns']);
        add_action('manage_' . self::POST_TYPE . '_posts_custom_column', [$this, 'column_content'], 10, 2);
        add_action('wp_head', [$this, 'output_video_schema'], 20);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_action('template_redirect', [$this, 'maybe_handle_timestamp']);
    }

    public static function activate(): void {
        self::instance()->register_post_type();
        flush_rewrite_rules();
        if (get_option(self::OPTION_ADD_LINKS, null) === null) {
            update_option(self::OPTION_ADD_LINKS, '1');
        }
    }

    public static function deactivate(): void {
        flush_rewrite_rules();
    }

    public function register_post_type(): void {
        register_post_type(self::POST_TYPE, [
            'labels' => [
                'name'                  => __('Videos', 'video-watch-pages'),
                'singular_name'         => __('Video', 'video-watch-pages'),
                'menu_name'             => __('Videos', 'video-watch-pages'),
                'add_new'               => __('Add video', 'video-watch-pages'),
                'add_new_item'          => __('Add video', 'video-watch-pages'),
                'edit_item'             => __('Edit video', 'video-watch-pages'),
                'new_item'              => __('New video', 'video-watch-pages'),
                'view_item'             => __('View watch page', 'video-watch-pages'),
                'search_items'          => __('Search videos', 'video-watch-pages'),
                'not_found'             => __('No videos found.', 'video-watch-pages'),
                'all_items'             => __('All videos', 'video-watch-pages'),
            ],
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_rest'          => true,
            'has_archive'           => true,
            'rewrite'               => [
                'slug'       => 'video',
                'with_front' => false,
            ],
            'menu_icon'             => 'dashicons-video-alt3',
            'supports'              => ['title', 'editor', 'thumbnail', 'excerpt'],
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_in_nav_menus'     => true,
        ]);
    }

    public function register_meta_box(): void {
        add_meta_box(
            'vwp_video_details',
            __('Video Watch Page Details', 'video-watch-pages'),
            [$this, 'render_meta_box'],
            self::POST_TYPE,
            'normal',
            'high'
        );
    }

    public function render_meta_box(WP_Post $post): void {
        wp_nonce_field('vwp_save_video_meta', 'vwp_video_meta_nonce');

        $video_url     = (string) get_post_meta($post->ID, self::META_VIDEO_URL, true);
        $thumbnail_url = (string) get_post_meta($post->ID, self::META_THUMBNAIL_URL, true);
        $description   = (string) get_post_meta($post->ID, self::META_DESCRIPTION, true);
        $duration      = (string) get_post_meta($post->ID, self::META_DURATION, true);
        $sources       = get_post_meta($post->ID, self::META_SOURCE_IDS, true);

        if (!is_array($sources)) {
            $sources = [];
        }
        ?>
        <p>
            <label for="vwp_video_url"><strong><?php esc_html_e('Video file URL', 'video-watch-pages'); ?></strong></label><br>
            <input type="url" class="widefat" id="vwp_video_url" name="vwp_video_url" value="<?php echo esc_attr($video_url); ?>" placeholder="https://example.com/wp-content/uploads/video.mp4">
        </p>
        <p>
            <label for="vwp_thumbnail_url"><strong><?php esc_html_e('Unique thumbnail URL', 'video-watch-pages'); ?></strong></label><br>
            <input type="url" class="widefat" id="vwp_thumbnail_url" name="vwp_thumbnail_url" value="<?php echo esc_attr($thumbnail_url); ?>" placeholder="https://example.com/wp-content/uploads/video-thumbnail.jpg">
            <span class="description"><?php esc_html_e('Google requires a thumbnail for VideoObject eligibility. Use a unique image for this video.', 'video-watch-pages'); ?></span>
        </p>
        <p>
            <label for="vwp_duration"><strong><?php esc_html_e('Duration (seconds)', 'video-watch-pages'); ?></strong></label><br>
            <input type="number" min="1" step="1" id="vwp_duration" name="vwp_duration" value="<?php echo esc_attr($duration); ?>" placeholder="224">
            <span class="description"><?php esc_html_e('Optional. Example: 224 for 3:44. The plugin converts this to ISO 8601 in JSON-LD.', 'video-watch-pages'); ?></span>
        </p>
        <p>
            <label for="vwp_description"><strong><?php esc_html_e('Video description', 'video-watch-pages'); ?></strong></label><br>
            <textarea class="widefat" rows="5" id="vwp_description" name="vwp_description" placeholder="<?php esc_attr_e('A unique description of what the viewer will watch.', 'video-watch-pages'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <?php if ($sources) : ?>
            <p>
                <strong><?php esc_html_e('Source posts', 'video-watch-pages'); ?></strong><br>
                <?php foreach ($sources as $source_id) :
                    $source = get_post((int) $source_id);
                    if (!$source) {
                        continue;
                    }
                    ?>
                    <a href="<?php echo esc_url(get_edit_post_link($source->ID)); ?>">
                        <?php echo esc_html(get_the_title($source)); ?>
                    </a><br>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
        <p class="description">
            <?php
            printf(
                /* translators: %s is the watch page URL. */
                esc_html__('Watch page: %s', 'video-watch-pages'),
                esc_url(get_permalink($post))
            );
            ?>
        </p>
        <?php
    }

    public function save_meta(int $post_id, WP_Post $post): void {
        if (!isset($_POST['vwp_video_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vwp_video_meta_nonce'])), 'vwp_save_video_meta')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (wp_is_post_revision($post_id)) {
            return;
        }

        $url = isset($_POST['vwp_video_url']) ? esc_url_raw(wp_unslash($_POST['vwp_video_url'])) : '';
        $thumb = isset($_POST['vwp_thumbnail_url']) ? esc_url_raw(wp_unslash($_POST['vwp_thumbnail_url'])) : '';
        $description = isset($_POST['vwp_description']) ? sanitize_textarea_field(wp_unslash($_POST['vwp_description'])) : '';
        $duration = isset($_POST['vwp_duration']) ? absint($_POST['vwp_duration']) : 0;

        if ($url !== '') {
            update_post_meta($post_id, self::META_VIDEO_URL, $url);
        } else {
            delete_post_meta($post_id, self::META_VIDEO_URL);
        }

        if ($thumb !== '') {
            update_post_meta($post_id, self::META_THUMBNAIL_URL, $thumb);
        } else {
            delete_post_meta($post_id, self::META_THUMBNAIL_URL);
        }

        if ($description !== '') {
            update_post_meta($post_id, self::META_DESCRIPTION, $description);
        } else {
            delete_post_meta($post_id, self::META_DESCRIPTION);
        }

        if ($duration > 0) {
            update_post_meta($post_id, self::META_DURATION, $duration);
        } else {
            delete_post_meta($post_id, self::META_DURATION);
        }
    }

    public function register_admin_page(): void {
        add_management_page(
            __('Video Watch Pages', 'video-watch-pages'),
            __('Video Watch Pages', 'video-watch-pages'),
            'manage_options',
            'video-watch-pages',
            [$this, 'render_admin_page']
        );
    }

    public function admin_assets(string $hook): void {
        if ($hook !== 'tools_page_video-watch-pages') {
            return;
        }
        wp_register_style('vwp-admin', false, [], self::VERSION);
        wp_enqueue_style('vwp-admin');
        wp_add_inline_style('vwp-admin', '.vwp-card{max-width:900px;background:#fff;border:1px solid #ccd0d4;padding:20px;margin:20px 0}.vwp-stat{font-size:24px;font-weight:600}.vwp-note{background:#f6f7f7;border-left:4px solid #2271b1;padding:10px 12px}.vwp-warning{border-left-color:#dba617}');
    }

    public function render_admin_page(): void {
        if (!current_user_can('manage_options')) {
            return;
        }

        $add_links = get_option(self::OPTION_ADD_LINKS, '1') === '1';
        $videos = wp_count_posts(self::POST_TYPE);
        $published = isset($videos->publish) ? (int) $videos->publish : 0;
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Video Watch Pages', 'video-watch-pages'); ?></h1>

            <?php if (isset($_GET['vwp_scanned'])) : ?>
                <div class="notice notice-success is-dismissible">
                    <p>
                        <?php
                        printf(
                            esc_html__('%1$d videos found. %2$d watch pages created and %3$d updated.', 'video-watch-pages'),
                            absint($_GET['vwp_scanned']),
                            absint($_GET['vwp_created'] ?? 0),
                            absint($_GET['vwp_updated'] ?? 0)
                        );
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="vwp-card">
                <h2><?php esc_html_e('Scan existing posts', 'video-watch-pages'); ?></h2>
                <p><?php esc_html_e('The scanner looks through published blog posts for self-hosted HTML5 video files (MP4, M4V, WebM, OGG). It creates one dedicated watch page per unique video URL.', 'video-watch-pages'); ?></p>
                <p class="vwp-note"><?php esc_html_e('The original posts are not modified. Instead, a watch-page link is added dynamically when the post is displayed.', 'video-watch-pages'); ?></p>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('vwp_scan_posts', 'vwp_scan_nonce'); ?>
                    <input type="hidden" name="action" value="vwp_scan_posts">
                    <label>
                        <input type="checkbox" name="add_links" value="1" <?php checked($add_links); ?>>
                        <?php esc_html_e('Show “Watch video” links below embedded videos in source posts', 'video-watch-pages'); ?>
                    </label>
                    <p><button type="submit" class="button button-primary"><?php esc_html_e('Scan posts and create watch pages', 'video-watch-pages'); ?></button></p>
                </form>
            </div>

            <div class="vwp-card">
                <h2><?php esc_html_e('Current status', 'video-watch-pages'); ?></h2>
                <p><span class="vwp-stat"><?php echo esc_html($published); ?></span> <?php esc_html_e('published watch pages', 'video-watch-pages'); ?></p>
                <p><?php esc_html_e('After scanning, open Videos → All Videos and add/verify a unique thumbnail for each video. Google requires name, thumbnailUrl and uploadDate for VideoObject structured data eligibility.', 'video-watch-pages'); ?></p>
                <p class="vwp-note vwp-warning"><?php esc_html_e('A missing thumbnail does not make the page unusable, but its VideoObject markup will not contain the required thumbnailUrl until you add one.', 'video-watch-pages'); ?></p>
            </div>
        </div>
        <?php
    }

    public function handle_scan(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to scan posts.', 'video-watch-pages'));
        }
        if (!isset($_POST['vwp_scan_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vwp_scan_nonce'])), 'vwp_scan_posts')) {
            wp_die(esc_html__('Security check failed.', 'video-watch-pages'));
        }

        $add_links = isset($_POST['add_links']) ? '1' : '0';
        update_option(self::OPTION_ADD_LINKS, $add_links);

        $query = new WP_Query([
            'post_type'              => 'post',
            'post_status'            => 'publish',
            'posts_per_page'         => -1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        $scanned = 0;
        $created = 0;
        $updated = 0;

        foreach ($query->posts as $source_id) {
            $source_id = (int) $source_id;
            $content = (string) get_post_field('post_content', $source_id);
            $videos = $this->extract_videos($content);
            if (!$videos) {
                continue;
            }

            $index = 0;
            foreach ($videos as $video) {
                $index++;
                $scanned++;
                $result = $this->create_or_update_video($source_id, $video, count($videos), $index);
                if ($result['created']) {
                    $created++;
                } elseif ($result['updated']) {
                    $updated++;
                }
            }
        }

        wp_reset_postdata();

        $url = add_query_arg([
            'page'        => 'video-watch-pages',
            'vwp_scanned' => $scanned,
            'vwp_created' => $created,
            'vwp_updated' => $updated,
        ], admin_url('tools.php'));

        wp_safe_redirect($url);
        exit;
    }

    /**
     * Extract self-hosted HTML5 video URLs and poster images from content.
     * @return array<int, array{url:string,poster:string}>
     */
    private function extract_videos(string $content): array {
        if ($content === '') {
            return [];
        }

        $found = [];

        if (class_exists('DOMDocument')) {
            $dom = new DOMDocument();
            $previous = libxml_use_internal_errors(true);
            $html = '<?xml encoding="utf-8" ?><div>' . $content . '</div>';
            @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
            libxml_clear_errors();
            libxml_use_internal_errors($previous);

            foreach ($dom->getElementsByTagName('video') as $video_node) {
                /** @var DOMElement $video_node */
                $poster = $this->normalize_url($video_node->getAttribute('poster'));
                $direct = $this->normalize_url($video_node->getAttribute('src'));

                if ($this->is_supported_video_url($direct)) {
                    $found[$direct] = ['url' => $direct, 'poster' => $poster];
                }

                foreach ($video_node->getElementsByTagName('source') as $source_node) {
                    /** @var DOMElement $source_node */
                    $url = $this->normalize_url($source_node->getAttribute('src'));
                    if (!$this->is_supported_video_url($url)) {
                        continue;
                    }
                    if (!isset($found[$url])) {
                        $found[$url] = ['url' => $url, 'poster' => $poster];
                    } elseif ($found[$url]['poster'] === '' && $poster !== '') {
                        $found[$url]['poster'] = $poster;
                    }
                }
            }
        } else {
            preg_match_all('/<video\b([^>]*)>(.*?)<\/video>/is', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $attributes = $match[1] ?? '';
                $poster = $this->normalize_url($this->extract_attribute($attributes, 'poster'));
                $direct = $this->normalize_url($this->extract_attribute($attributes, 'src'));
                if ($this->is_supported_video_url($direct)) {
                    $found[$direct] = ['url' => $direct, 'poster' => $poster];
                }
                preg_match_all('/<source\b([^>]*)>/is', $match[2] ?? '', $source_matches);
                foreach ($source_matches[1] as $source_attributes) {
                    $url = $this->normalize_url($this->extract_attribute($source_attributes, 'src'));
                    if ($this->is_supported_video_url($url)) {
                        $found[$url] ??= ['url' => $url, 'poster' => $poster];
                    }
                }
            }
        }

        return array_values($found);
    }

    private function extract_attribute(string $attributes, string $name): string {
        if (preg_match('/\b' . preg_quote($name, '/') . '\s*=\s*["\']([^"\']+)["\']/i', $attributes, $match)) {
            return html_entity_decode($match[1], ENT_QUOTES, 'UTF-8');
        }
        return '';
    }

    private function normalize_url(string $url): string {
        $url = trim(html_entity_decode($url, ENT_QUOTES, 'UTF-8'));
        if ($url === '') {
            return '';
        }
        if (str_starts_with($url, '//')) {
            $url = (is_ssl() ? 'https:' : 'http:') . $url;
        } elseif (str_starts_with($url, '/')) {
            $url = home_url($url);
        }
        return esc_url_raw($url);
    }

    public function filter_supported_extensions(array $extensions): array {
        return array_values(array_unique(array_filter(array_map('strtolower', $extensions))));
    }

    private function is_supported_video_url(string $url): bool {
        if ($url === '') {
            return false;
        }
        $path = (string) parse_url($url, PHP_URL_PATH);
        $extension = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
        $extensions = apply_filters('vwp_supported_extensions', ['mp4', 'm4v', 'webm', 'ogv', 'ogg']);
        return in_array($extension, $extensions, true);
    }

    /**
     * @return array{created:bool,updated:bool,post_id:int}
     */
    private function create_or_update_video(int $source_id, array $video, int $video_count, int $index): array {
        $url = (string) $video['url'];
        $existing = $this->find_video_by_url($url);
        $source = get_post($source_id);
        if (!$source) {
            return ['created' => false, 'updated' => false, 'post_id' => 0];
        }

        $post_title = get_the_title($source);
        $base_title = $video_count > 1
            ? sprintf('%s — Vídeo %d', $post_title, $index)
            : $post_title;

        $slug_base = sanitize_title(pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME));
        if ($slug_base === '') {
            $slug_base = sanitize_title($post_title . '-video');
        }
        if ($video_count > 1 && $slug_base !== '') {
            $slug_base .= '-' . $index;
        }

        $description = $this->build_description($source_id);
        $thumbnail = (string) ($video['poster'] ?? '');
        if ($thumbnail === '') {
            $thumbnail = $this->get_featured_image_url($source_id);
        }
        $duration = $this->detect_duration($url);

        $created = false;
        $updated = false;

        if ($existing) {
            $video_id = (int) $existing->ID;
            $updated_post = wp_update_post([
                'ID'          => $video_id,
                'post_status' => 'publish',
            ], true);
            $updated = !is_wp_error($updated_post);
        } else {
            $video_id = wp_insert_post([
                'post_type'     => self::POST_TYPE,
                'post_status'   => 'publish',
                'post_title'    => $base_title,
                'post_name'     => wp_unique_post_slug($slug_base, 0, 'publish', self::POST_TYPE, 0),
                'post_content'  => '[vwp_watch_video]',
                'post_excerpt'  => $description,
                'post_date'     => $source->post_date,
                'post_date_gmt' => $source->post_date_gmt,
            ], true);
            if (is_wp_error($video_id)) {
                return ['created' => false, 'updated' => false, 'post_id' => 0];
            }
            $video_id = (int) $video_id;
            $created = true;
        }

        update_post_meta($video_id, self::META_VIDEO_URL, $url);
        update_post_meta($video_id, self::META_ORIGINAL_VIDEO_URL, $url);

        $source_ids = get_post_meta($video_id, self::META_SOURCE_IDS, true);
        if (!is_array($source_ids)) {
            $source_ids = [];
        }
        $source_ids[] = $source_id;
        $source_ids = array_values(array_unique(array_map('absint', $source_ids)));
        update_post_meta($video_id, self::META_SOURCE_IDS, $source_ids);

        if ($thumbnail !== '' && get_post_meta($video_id, self::META_THUMBNAIL_URL, true) === '') {
            update_post_meta($video_id, self::META_THUMBNAIL_URL, $thumbnail);
        }
        if ($description !== '' && get_post_meta($video_id, self::META_DESCRIPTION, true) === '') {
            update_post_meta($video_id, self::META_DESCRIPTION, $description);
        }
        if ($duration > 0 && !get_post_meta($video_id, self::META_DURATION, true)) {
            update_post_meta($video_id, self::META_DURATION, $duration);
        }

        return ['created' => $created, 'updated' => $updated, 'post_id' => $video_id];
    }

    private function find_video_by_url(string $url): ?WP_Post {
        $posts = get_posts([
            'post_type'      => self::POST_TYPE,
            'post_status'    => 'any',
            'posts_per_page' => 1,
            'meta_key'       => self::META_VIDEO_URL,
            'meta_value'     => $url,
        ]);
        return $posts[0] ?? null;
    }

    private function build_description(int $post_id): string {
        $excerpt = trim((string) get_post_field('post_excerpt', $post_id));
        if ($excerpt !== '') {
            return wp_strip_all_tags($excerpt);
        }

        $content = (string) get_post_field('post_content', $post_id);
        $content = preg_replace('/<video\b[^>]*>.*?<\/video>/is', ' ', $content) ?? $content;
        $content = preg_replace('/<[^>]+>/', ' ', $content) ?? $content;
        $content = preg_replace('/\s+/', ' ', $content) ?? $content;
        return wp_trim_words(trim(wp_strip_all_tags($content)), 35, '…');
    }

    private function get_featured_image_url(int $post_id): string {
        $url = get_the_post_thumbnail_url($post_id, 'full');
        return $url ? (string) $url : '';
    }

    private function detect_duration(string $url): int {
        $attachment_id = attachment_url_to_postid($url);
        if (!$attachment_id) {
            return 0;
        }
        $metadata = wp_get_attachment_metadata($attachment_id);
        if (is_array($metadata) && !empty($metadata['length'])) {
            return absint($metadata['length']);
        }
        return 0;
    }

    public function inject_watch_links(string $content): string {
        if (is_admin() || get_option(self::OPTION_ADD_LINKS, '1') !== '1') {
            return $content;
        }

        if (!is_singular('post')) {
            return $content;
        }

        $videos = $this->extract_videos($content);
        if (!$videos) {
            return $content;
        }

        foreach ($videos as $video) {
            $video_post = $this->find_video_by_url((string) $video['url']);
            if (!$video_post) {
                continue;
            }

            $watch_url = get_permalink($video_post);
            if (!$watch_url) {
                continue;
            }

            $link_html = sprintf(
                '<p class="vwp-watch-link"><a href="%1$s">%2$s</a></p>',
                esc_url($watch_url),
                esc_html__('Se quiser, veja esse vídeo na sua página dedicada→', 'video-watch-pages')
            );

            $pattern = sprintf(
                '/(<video\b[^>]*>.*?<\/video>)(?!\s*<p\s+class=["\']vwp-watch-link["\'])/is'
            );
            $new_content = preg_replace($pattern, '$1' . $link_html, $content, 1);
            if ($new_content !== null && $new_content !== $content) {
                $content = $new_content;
            }
        }

        return $content;
    }

    public function output_video_schema(): void {
        if (!is_singular(self::POST_TYPE)) {
            return;
        }

        $post_id = get_queried_object_id();
        $url = (string) get_post_meta($post_id, self::META_VIDEO_URL, true);
        $thumbnail = (string) get_post_meta($post_id, self::META_THUMBNAIL_URL, true);

        if ($url === '' || $thumbnail === '') {
            return;
        }

        $description = (string) get_post_meta($post_id, self::META_DESCRIPTION, true);
        if ($description === '') {
            $description = wp_trim_words(wp_strip_all_tags((string) get_the_excerpt($post_id)), 35, '…');
        }

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'VideoObject',
            '@id'         => trailingslashit(get_permalink($post_id)) . '#video',
            'name'        => get_the_title($post_id),
            'thumbnailUrl' => [$thumbnail],
            'uploadDate'  => get_post_time('c', true, $post_id),
            'contentUrl'  => $url,
            'description' => $description,
        ];

        $duration = absint(get_post_meta($post_id, self::META_DURATION, true));
        if ($duration > 0) {
            $schema['duration'] = $this->seconds_to_iso8601($duration);
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }

    private function seconds_to_iso8601(int $seconds): string {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $remaining = $seconds % 60;

        return sprintf('PT%dH%dM%dS', $hours, $minutes, $remaining);
    }

    public function frontend_assets(): void {
        if (!is_singular(self::POST_TYPE) && !is_post_type_archive(self::POST_TYPE)) {
            return;
        }

        wp_register_style('vwp-frontend', false, [], self::VERSION);
        wp_enqueue_style('vwp-frontend');
        wp_add_inline_style('vwp-frontend', '.vwp-watch-video{width:100%;aspect-ratio:16/9;position:relative;overflow:hidden;border-radius:12px;background:#000;margin:0 0 1.5rem}.vwp-watch-video video{width:100%;height:100%;object-fit:cover;display:block}.vwp-watch-video video.vwp-playing{object-fit:contain}.vwp-watch-meta{font-size:.95rem;opacity:.8;margin:.75rem 0 1.5rem}.vwp-watch-description{margin:0 0 1.5rem}.vwp-watch-link{margin:.75rem 0;font-size:.95rem}.vwp-watch-link a{font-weight:600}.vwp-video-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem}.vwp-video-card{display:block;text-decoration:none}.vwp-video-card img{display:block;width:100%;height:auto;aspect-ratio:16/9;object-fit:cover}.vwp-video-card h2{font-size:1.15rem;margin:.6rem 0}.vwp-no-thumb{aspect-ratio:16/9;background:#111;color:#fff;display:grid;place-items:center}');
    }

    public function columns(array $columns): array {
        $columns['vwp_video_status'] = __('Video data', 'video-watch-pages');
        return $columns;
    }

    public function column_content(string $column, int $post_id): void {
        if ($column !== 'vwp_video_status') {
            return;
        }
        $url = (string) get_post_meta($post_id, self::META_VIDEO_URL, true);
        $thumb = (string) get_post_meta($post_id, self::META_THUMBNAIL_URL, true);

        echo $thumb !== ''
            ? '<span aria-label="Thumbnail available">✓ Thumbnail</span><br>'
            : '<span aria-label="Thumbnail missing">⚠ Thumbnail needed</span><br>';

        if ($url !== '') {
            echo esc_html(wp_basename((string) parse_url($url, PHP_URL_PATH)));
        }
    }

    public function maybe_handle_timestamp(): void {
        if (!is_singular(self::POST_TYPE)) {
            return;
        }
        if (!isset($_GET['t'])) {
            return;
        }
        $seconds = absint($_GET['t']);
        if ($seconds < 1) {
            return;
        }

        add_action('wp_footer', static function () use ($seconds): void {
            printf(
                '<script>document.addEventListener("DOMContentLoaded",function(){var v=document.querySelector(".vwp-watch-video video");if(!v){return;}var seek=function(){v.currentTime=%d;};if(v.readyState>=1){seek();}else{v.addEventListener("loadedmetadata",seek,{once:true});}});</script>',
                $seconds
            );
        }, 99);
    }

    /**
     * Render helper used by the generated video post content.
     */
    public function render_watch_video(): string {
        $post_id = get_the_ID();
        if (!$post_id || get_post_type($post_id) !== self::POST_TYPE) {
            return '';
        }

        $url = (string) get_post_meta($post_id, self::META_VIDEO_URL, true);
        if ($url === '') {
            return '<p>' . esc_html__('Video file URL is missing.', 'video-watch-pages') . '</p>';
        }

        $thumbnail = (string) get_post_meta($post_id, self::META_THUMBNAIL_URL, true);
        if ($thumbnail === '') {
            $thumbnail = (string) get_the_post_thumbnail_url($post_id, 'full');
        }

        $description = (string) get_post_meta($post_id, self::META_DESCRIPTION, true);
        $duration = absint(get_post_meta($post_id, self::META_DURATION, true));
        $sources = get_post_meta($post_id, self::META_SOURCE_IDS, true);
        if (!is_array($sources)) {
            $sources = [];
        }

        ob_start();
        ?>
        <div class="vwp-watch-video">
        <video controls preload="metadata" playsinline<?php echo $thumbnail !== '' ? ' poster="' . esc_url($thumbnail) . '"' : ''; ?> onplay="this.classList.add('vwp-playing')" onended="this.classList.remove('vwp-playing')">
        <source src="<?php echo esc_url($url); ?>" type="<?php echo esc_attr($this->mime_type_from_url($url)); ?>">
        <?php esc_html_e('Your browser does not support the video element.', 'video-watch-pages'); ?>
        </video>
        </div>

        <div class="vwp-watch-meta">
            <?php
            echo esc_html(get_the_date('', $post_id));
            if ($duration > 0) {
                echo ' · ' . esc_html($this->format_duration($duration));
            }
            ?>
        </div>

        <?php if ($description !== '') : ?>
            <div class="vwp-watch-description">
                <?php echo wpautop(esc_html($description)); ?>
            </div>
        <?php endif; ?>

        <?php if ($sources) : ?>
            <p class="vwp-watch-source">
                <?php esc_html_e('Este vídeo aparece em:', 'video-watch-pages'); ?>
                <?php
                $links = [];
                foreach ($sources as $source_id) {
                    $source_id = absint($source_id);
                    if (!$source_id) {
                        continue;
                    }
                    $source_url = get_permalink($source_id);
                    if ($source_url) {
                        $links[] = sprintf(
                            '<a href="%1$s">%2$s</a>',
                            esc_url($source_url),
                            esc_html(get_the_title($source_id))
                        );
                    }
                }
                echo wp_kses_post(implode(' · ', $links));
                ?>
            </p>
        <?php endif; ?>
        <?php
        $html = (string) ob_get_clean();
        return (string) apply_filters('vwp_watch_video_html', $html, $post_id);
    }

    public function filter_watch_video_html(string $html, int $post_id): string {
        return $html;
    }

    private function mime_type_from_url(string $url): string {
        $ext = strtolower((string) pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        return match ($ext) {
            'mp4', 'm4v' => 'video/mp4',
            'webm'      => 'video/webm',
            'ogv', 'ogg' => 'video/ogg',
            default     => 'video/mp4',
        };
    }

    private function format_duration(int $seconds): string {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $seconds = $seconds % 60;
        return $hours > 0
            ? sprintf('%d:%02d:%02d', $hours, $minutes, $seconds)
            : sprintf('%d:%02d', $minutes, $seconds);
    }

    public function shortcode_watch_video(): string {
        return $this->render_watch_video();
    }


}

VWP_Video_Watch_Pages::instance();

add_shortcode('vwp_watch_video', [VWP_Video_Watch_Pages::instance(), 'shortcode_watch_video']);

register_activation_hook(__FILE__, ['VWP_Video_Watch_Pages', 'activate']);
register_deactivation_hook(__FILE__, ['VWP_Video_Watch_Pages', 'deactivate']);
