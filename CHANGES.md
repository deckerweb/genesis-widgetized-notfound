# Genesis Widgetized Not Found & 404

**General Info**

* [Plugin page on WordPress.org: wordpress.org/plugins/genesis-widgetized-notfound/](https://wordpress.org/plugins/genesis-widgetized-notfound/)
* [Translate the plugin](https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound)
* [**Join plugin's newsletter for insider info, tutorials and more**](https://eepurl.com/gbAUUn)
* [**Become a Patron**](https://www.patreon.com/deckerweb) and support ongoing development, maintenance and support of this plugin
* [**Donate** for the further development & support of the plugin](https://www.paypal.me/deckerweb)
* [Plugin's documentation & FAQ](https://wordpress.org/plugins/genesis-widgetized-notfound/#faq)
* [Facebook Community User Group](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* [Facebook Info Page for Deckerweb Plugins](https://www.facebook.com/deckerweb.wordpress.plugins/)


## Changelog of the Plugin

### ⚡ 1.6.4 - 2019-05-04

* *New: Successfully tested with WordPress 5.2*
* New: Integrated with WordPress 5.2+ new Site Health feature: Genesis Widgetized Not Found & 404 now has an extra section on the Debug Info tab - this is especially helpful for support requests
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.4.0) - feature updates
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* New: [Join my newsletter for DECKERWEB WordPress Plugins](https://eepurl.com/gbAUUn) - insider info, plus tutorials and more useful stuff


### ⚡ 1.6.3 - 2018-11-22

* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.1) - CSS fixes
* Tweak: Overhauled "Installation" part of this Readme.txt file completely
* Tweak: Added new FAQ entry regarding HTTP status in this Readme.txt file here
* Fix: Changed admin style enqueueing on the Widgets Admin - this fixes the issues when adding widgets AND also in the Customizer


### ⚡ 1.6.2 - 2018-11-03

* New: [Video of plugin walkthrough and live demo](https://www.youtube.com/watch?v=0RJldBSH_fA)
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.0) - which brings enhanced CSS styles, including for the "Dark Mode" plugin
* Tweak: Few internal code tweaks and improvements


### ⚡ 1.6.1 - 2018-10-01

* New: Added plugin update message also to Plugins page (overview table)
* New: Created special [Facebook Group for user community support](https://www.facebook.com/groups/deckerweb.wordpress.plugins/) for all plugins from me (David Decker - DECKERWEB), this one here included! ;-) - [please join at facebook!](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.1.0) - which brings smaller additions and enhancements, like CSS styles to the upload areas and plugin cards, plus plugin version number on plugin cards
* Tweak: Internal code improvements and tweaks
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs


### 🎉 1.6.0 - 2018-08-25

* *New: Brought the plugin back to life after more than five years, yeah! :)*
* New: Added submenu item for Genesis Settings in WP-Admin left-hand menu - this redirects directly to the Widgets admin page, which makes it totally easy to setup the stuff
* New: Added handy Customizer Live Preview links for our two Genesis Widget areas to Plugins page
* New: For WP 4.9.7 or higher: Added handy Customizer Live Preview links, plus live testing links to the description of our two Genesis Widget areas on the Widgets page (in WP-Admin)
* New: Added subtle note on our two Widget area titles to make it more clear what belongs to what
* New: Release on GitHub.com as well (for issues, development etc.), see here: [https://github.com/deckerweb/genesis-widgetized-notfound](https://github.com/deckerweb/genesis-widgetized-notfound)
* New: Added `composer.json` file to the plugin's root folder - this is great for developers using Composer
* New: Added `README.md` file for plugin's GitHub.com repository to make it more readable there
* New: Added new plugin icon and banner on WordPress.org
* New: Added plugins recommendations library by deckerweb to add plugin installer tips
* Tweak: Updated all internal plugin links to current state, deleted the ones that were dead or no longer needed
* Tweak: Changed registering of widget areas to newer Genesis functions
* Tweak: Changed some filter hook tags to comply with the new features, and, to have them more logical and better organized
* Tweak: Code improvements and internal documentation updates
* Tweak: Removed "Facetious" plugin support as this is no longer available
* Update: `.pot` file for translators, plus German translations
* Update: Readme.txt file.
* Update: All new screenshots - plus some more ;-)
* *Trivia fact: this plugin is already over 6 (six!) years old. Whoa, that's a lot. ;-)*
* Update: Readme.txt file.


### 🎉 1.5.0 - 2013-05-29

* NEW: Added Widget "Genesis - Search Form" - more customizeable than the built-in WordPress core widget (change Search text, Submit text, display options etc.).
* NEW: Added Shortcode `[gwnf-search]` for displaying a configurable search for anywhere you like :) -- conditionally with full support for HTMTL5 & Genesis 2.0.0+ if in use.
* NEW: Added Shortcode `[gwnf-widget-area]` for displaying any of the plugin's 3 Widget areas (if active) into Shortcode aware content areas.
* NEW: Added support for bbPress 2.3+ forum plugin: Added widgetized content area for the "No results" state of the bbPress Forum search - now you can easily customize this "edge case" with well-known and proved regular WordPress tools (that are Widgets!).
* UPDATE: All markup output by the plugin is now fully compatible with Genesis 2.0+, that means for HTML5 if the child theme supports it (is done all automatically & conditionally under the surface!).
* UPDATE: Additional stylesheet now uses the WordPress convention for file names: `gwnf-styles.min.css` (`gwnf-html5-styles.min.css`) is the minified default version, plus, `gwnf-styles.css` (`gwnf-html5-styles.css`) is now the development version. If `WP_DEBUG` or `SCRIPT_DEBUG` constants are `true`, the dev styles will be loaded. This makes development/ customizing & debugging a lot easier! :)
* UPDATE: Improved versioning of stylesheet, also in light of above update :).
* UPDATE: All frontent relevant code is now moved into the plugin's frontend file and only then loaded!
* CODE: Some code optimizations, plus code/documentation updates & improvements.
* UPDATE: Added a few new screenshots.
* UPDATE: Updated readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators.
* NEW: Added partly Spanish translations, user-submitted.


### 🎉 1.4.0 - 2012-12-15

* *Maintenance release*
* UPDATE: Added the class placeholder to widget registrations to fullfill WordPress standard for Widgets API.
* NEW: Added constant for disabling the widget shortcode support (see FAQ here).
* CODE: Some code/documentation updates & improvements.
* UPDATE: Updated readme.txt file here.
* UPDATE: Initiated new three digits versioning, starting with this version.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Moved screenshots to 'assets' folder in WP.org SVN to reduce plugin package size.


### 🎉 1.3.0 - 2012-08-20

* *Maintenance release*
* NEW: Added help tab also on Genesis settings page.
* NEW: Compressed CSS file for improved performance (the development file has now the file name `gwnf-styles.dev.css` and is still packaged).
* CODE: Minor code/documentation updates & improvements.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Extended GPL License info in readme.txt as well as main plugin file.
* NEW: Easy plugin translation platform with GlotPress tool: [Translate "Genesis Widgetized Not Found & 404"...](https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound)


### 🎉 1.2.0 - 2012-04-27

* NEW: Added little help tab on Widget admin page for better user experience. (Works only with WordPress 3.3 or higher!)
* UPDATE: Moved plugin links from main file to extra admin file which only loads within 'wp-admin', this way it's performance-improved! This also effects the new help tab stuff :).
* UPDAGE: Added action hook `gwnf_load_styles` if you ever need to properly enqueue your own stylesheet for the edge cases... (Also see FAQ here).
* CODE: Minor code/documentation tweaks and improvements.
* UPDATE: Extended and improved readme.txt file documentation here, corrected typos.
* UPDATE: Updated German translations and also the .pot file for all translators.


### 🎉 1.1.0 - 2012-04-23

* NEW: Added two helper functions (via child theme) for applying the Genesis 'Full-Width' layout option for one or both 'not found' cases! This is very handy for lots of use cases... -- [See the FAQ section for more info on that!](https://wordpress.org/plugins/genesis-widgetized-notfound/#faq)
* UPDATE: Placed widget display in conditionals only for the "404" or the "Search not found" case to avoid overlaying of more than one 'no content messages'. This should finally cover more edge cases...
* UPDATE: Improved translations loading, especially for activation (messages).
* UPDATE: Improved registering of widget areas/sidebars: switching back to Genesis register function, but now properly wrapped in a conditional, checking for activated Genesis. This way we also get further improved Multisite support!
* UPDATE: Improved CSS styling, handling the limition of the empty "p" (left over from the original "no content status" of Genesis).
* UPDATE: Updated German translations and also the .pot file for all translators.


### ⚡ 1.0.1 - 2012-04-20

* Bugfix release. Mmh, stuff happens...
* UPDATE: Changed widget registering from Genesis to WordPress function (it doesn't matter in the end!)
* BUGFIX: Fixed function typo that was causing notices on plugin activation.
* UPDATE: Minor code documentation updates. Also, minor updates to readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Added banner image on WordPress.org for better plugin branding :)


### 🎉 1.0.0 - 2012-04-20

* Initial release
