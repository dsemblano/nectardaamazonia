# Video Watch Pages for WordPress

**Version 1.0.1**

Small WordPress plugin for creating dedicated `/video/.../` watch pages from self-hosted videos already embedded in published posts.

Designed to be theme/framework independent, so it can be used with Roots/Sage 11 without requiring Blade templates or ACF.

## What it does

- Registers an internal `vwp_video` custom post type with public URLs under `/video/`.
- Scans published WordPress posts for HTML5 self-hosted video files: MP4, M4V, WebM, OGV/OGG.
- Creates one watch page per unique video URL.
- Reuses the same video file; it does not copy or move the MP4.
- Uses the source post's featured image as a thumbnail fallback, or a `<video poster="...">` when present.
- Attempts to read the attachment duration when the video belongs to the WordPress Media Library.
- Outputs Google `VideoObject` JSON-LD when a thumbnail is available.
- Adds a “Watch this video on its dedicated page” link below embedded videos in source posts, without rewriting the saved post content.
- Provides a simple edit screen for video URL, thumbnail, description, and duration.
- Supports `?t=120` timestamp links for future key-moment/clip URLs.
- Leaves the `/video/` archive to the active theme, including Sage 11, so its normal archive template remains in control.

## Installation

1. Upload the ZIP in **Plugins → Add New → Upload Plugin**.
2. Activate it.
3. Go to **Tools → Video Watch Pages**.
4. Click **Scan posts and create watch pages**.
5. Open **Videos → All Videos** and review the generated entries.
6. Add a **unique thumbnail** to each important video. This is important because Google requires `name`, `thumbnailUrl`, and `uploadDate` for eligible `VideoObject` structured data.
7. Visit an individual watch page and confirm the video is immediately visible.
8. Run Google's Rich Results Test and URL Inspection on a few pages after deployment.

## Roots/Sage 11

No special Sage integration is required. The watch page is a normal WordPress custom-post-type page and the generated post content is a shortcode (`[vwp_watch_video]`), so Sage's normal `the_content` flow can render it.

For a custom Sage design, style `.vwp-watch-video`, `.vwp-watch-meta`, and `.vwp-watch-description` in your theme. You can also replace the generated shortcode output through the filter below.

### Useful filters

`vwp_watch_video_html` — filter the generated watch-page video markup.

`vwp_supported_extensions` — customize the file extensions the scanner accepts.

## Notes about Google Video SEO

A `/video/my-video/` page is the watch page. The MP4 remains the actual media file, for example:

`/wp-content/uploads/2026/09/my-video.mp4`

The JSON-LD uses that MP4 as `contentUrl`. It does **not** pretend the HTML watch-page URL is the video file.

The plugin intentionally does not emit `VideoObject` schema until a thumbnail exists, because `thumbnailUrl` is a required property in Google's current VideoObject documentation.

## Limitations

- This version intentionally focuses on self-hosted HTML5 video, not YouTube/Vimeo iframes.
- It does not generate a thumbnail from an MP4. Add a poster/thumbnail manually, or use the source post's featured image as a temporary fallback.
- If the same MP4 URL is embedded in multiple posts, the plugin creates one watch page and records all source posts.
- It does not rewrite or mutate existing post content in the database.
