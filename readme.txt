=== ForgeHub Product Listings ===
Contributors: wpforgehub
Tags: woocommerce, product listing, catalog, templates, shop
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Pick a ready-made layout for your plugin catalog, shop and category pages and assign a template per page.

== Description ==

ForgeHub Product Listings gives you three catalog layouts (Sidebar + Grid, Top Bar + Grid, Category Cards + List) and lets you choose which one is used on the plugins page, the shop page and category pages. Features customizable card designs (vertical, horizontal, compact), aspect ratio controls (16:9, 21:9 slim, 4:3, 1:1, hidden), granular element toggles, flexible grid columns (2-5), left/right sidebar positioning, container width control, and modular sidebar widgets (Search, Categories, Recent Products, Price Filter). Use the [forgehub_listing] shortcode to render the assigned template.

== Frequently Asked Questions ==

= Does it need WooCommerce? =
Yes, products are read from WooCommerce.

== Changelog ==

= 1.0.3 =
* Fixed price range filtering (`pl_price` filter brackets) for variable and freemium WooCommerce products so queries like `pl_price=under-20` match correctly.
* Added min and max price data attributes to product card templates for accurate multi-tier price matching and price sorting.
* Enhanced card edition logic to support `all` for variable products with both Free and Pro options.

= 1.0.2 =
* Added Product Card Design & Elements customization section in wp-admin settings.
* Added Card Layout Styles: Vertical (standard), Horizontal (sleek low height with left thumbnail), and Compact.
* Added Thumbnail Aspect Ratio controls: 16:9, 21:9 (ultra-wide slim banner), 4:3, 1:1, and Hidden.
* Added granular card element visibility toggles: Thumbnail, Free/Pro Badge, Categories, Title, Excerpt, Price, Action Button.
* Added Short Description / Excerpt word count control (default 12 words) to prevent overly tall vertical cards.
* Added customizable Action Button text setting and shortcode parameters.
* Fixed container width constraint in Full Site Editing page templates so 1400px, 1600px, and Full Width render properly.

= 1.0.1 =
* Added flexible grid columns setting (2, 3, 4, 5 columns or responsive auto-fit).
* Added sidebar position setting: Left or Right.
* Added container max-width setting (1200px, 1400px, 1600px, Full Width).
* Added modular sidebar widgets: Product Search, Category Tree, Recent Products, Price Filter.
* Added live price range filtering in JavaScript.
* Added WordPress dynamic sidebar support (wpfh-pl-sidebar).

= 1.0.0 =
* Initial release.
