# Studio Services

Classic WordPress plugin template. Same family of work as a content plugin: PHP classes under `includes/`, a shortcode, and a settings screen. No build step.

Modeled on the shape of a feature plugin (post type + admin + front output), separate from the Gutenberg block template.

## Use it

1. Copy the folder to `wp-content/plugins/studio-services` (rename the folder and text domain for the real client).
2. Activate it.
3. Add services, fill in **Settings → Studio Services**, and place `[studio_services]` on a page.

## What to rename

- Plugin header in `studio-services.php`
- Text domain `studio-services`
- Post type `studio_service` if the client is not selling services
- CSS custom properties in `assets/css/studio-services.css`
