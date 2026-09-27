# Template library

Clear map of the starter repos. Business sites are full sample websites. The two WordPress repos and the two Next.js repos are empty structures you copy when a job does not match one of the businesses.

All of them live under [github.com/Nizarsamman7](https://github.com/Nizarsamman7).

## Pick one

| If you are building | Start here |
| --- | --- |
| A Gutenberg site made of full-page blocks | [wp-plugin-template-blocks](https://github.com/Nizarsamman7/wp-plugin-template-blocks) |
| A plugin with a post type, settings, and a shortcode | [wp-plugin-template-classic](https://github.com/Nizarsamman7/wp-plugin-template-classic) |
| A Next.js marketing site, code under `src/` | [js-template-next-src](https://github.com/Nizarsamman7/js-template-next-src) |
| A Next.js business site, routes next to `app/` | [js-template-next-app](https://github.com/Nizarsamman7/js-template-next-app) |
| A barbershop | [ui-barber-atelier](https://github.com/Nizarsamman7/ui-barber-atelier) |
| A supermarket | [ui-supermarket-markt](https://github.com/Nizarsamman7/ui-supermarket-markt) |
| An auto garage | [ui-autogarage-pitlane](https://github.com/Nizarsamman7/ui-autogarage-pitlane) |
| A cafe | [ui-cafe-lumen](https://github.com/Nizarsamman7/ui-cafe-lumen) |
| A dental clinic | [ui-dental-helder](https://github.com/Nizarsamman7/ui-dental-helder) |
| A law firm | [ui-law-veld](https://github.com/Nizarsamman7/ui-law-veld) |
| A gym | [ui-gym-forge](https://github.com/Nizarsamman7/ui-gym-forge) |
| A florist | [ui-florist-stem](https://github.com/Nizarsamman7/ui-florist-stem) |
| A restaurant | [ui-restaurant-hearth](https://github.com/Nizarsamman7/ui-restaurant-hearth) |
| An estate agency | [ui-realty-linen](https://github.com/Nizarsamman7/ui-realty-linen) |

## Run a Next.js template

```bash
npm install
npm run dev
```

Open http://localhost:3000. Each business README lists every route.

## What you still have to add

Forms confirm in the browser only. There is no database, payment, or email. Replace the sample names and prices before a real launch.

## This repo

Classic WordPress plugin. No Node build.

- Custom post type `studio_service`
- Price field on the edit screen
- **Settings → Studio Services** for the business name, phone, and email
- Shortcode `[studio_services]`

### Use it

1. Copy this folder to `wp-content/plugins/studio-services`.
2. Activate **Studio Services**.
3. Add services.
4. Place `[studio_services]` on a page.

Rename the plugin header, text domain, and post type for the client. Styles are in `assets/css/studio-services.css`.
