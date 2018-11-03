=== Genesis Widgetized Not Found & 404 - Easy Setup for 404 Page and Search Not Found ===
Contributors: daveshine, deckerweb, wpautobahn
Donate link: https://www.paypal.me/deckerweb
Tags: genesis, genesiswp, genesis framework, 404, not found, error, search, searchform, page, widgets, widget, deckerweb
Requires at least: 3.6
Tested up to: 4.9.8
Requires PHP: 5.6
Stable tag: 1.6.2
License: GPL-2.0-or-later
License URI: https://opensource.org/licenses/GPL-2.0

Finally, use Widgets to maintain and customize your 404 Error and Search Not Found pages in Genesis Framework and Child Themes.

== Description ==

= New Flexibility plus Enhanced User Experience =
We all know that sometimes 404 Errors happen on our sites. And sometimes users search but get no results. I believe it's better to serve users some highly customized and maintained pages/content areas for these cases. What better to do that with Widgets in WordPress? -- In my opinion Genesis Framework could improve here so that's why I just made this little plugin to FINALLY have these two cases maintainable EASILY via your widgets admin. Just place in a search widget, your last blog posts, an image widget, some explanation via text widget, some galleries... You got it. The possibilities are endless. Finally.

Just a great helper tool for Genesis Child Themes!

**Please note:** The plugin requires the *Genesis Framework*, a paid premium product released by StudioPress/ WPEngine, Inc. [(via studiopress.com)](https://deckerweb.de/go/genesis/)

= What the Plugin Does - Advantages & Benefits =
* Helps users stay longer on your site because you can give options like search form, recent posts, introductory text, image(s) etc.
* Hugely improved user experience! (Helps decrease the "Oops, I broke the internet..." experiences...)
* Easily customizeable for any webmaster! -- In Widgets admin or in Customizer > Widgets
* Works across Genesis child themes - so you can switch your "skin" but not loosing this tool :-)
* Provides *extra Search Form Widget* with more options than the default WordPress core widget.
* Handy search form Shortcode!
* Ideal for multilingual websites (for example with "WPML"): Much better handling of 404/Not found content for different languages. -- [See bottom of FAQ section here](https://wordpress.org/plugins/genesis-widgetized-notfound/#faq) for more info on that.

= General Features =
* Small & lightweight plugin tool: Just activate plugin, place your widgets and you're done!
* Adds a new widget area (Sidebar) for the "404 Error Page"
* Adds a new widget area (Sidebar) for the "Search not found" page (if there are no results for a search term)
* Adds a new Search Form Widget - which gives you more options than the default WordPress "Search" widget! (Search text, Submit text etc.)
* Adds 2 Shortcodes: a customizeable Search form to place anywhere Shortcodes are supported, plus Shortcode for this plugin's widget areas.
* Special Bonus for bbPress 2.3+: make the forum search not found content/status widgetized - take full control!
* Adds a few CSS styles for the content area to properly divide widgets with some more space (all other styling is recommended via your child theme)
* Included are two handy helper functions (via child theme) for applying the Genesis 'Full-Width' layout option for one or both 'not found' cases! -- [See the FAQ section for more info on that!](https://wordpress.org/plugins/genesis-widgetized-notfound/#faq)
* For developers & advanced users: plugin provides lots of filter and acton hooks throughout for easy customization if ever needed.
* All markup is fully compatible with Genesis 2.0+, that means for HTML5 if the child theme supports it (is done all automatically & conditionally under the surface!).
* Integrated default Genesis filters `genesis_search_text` and `genesis_search_button_text` for default strings :-).
* Fully internationalized! Real-life tested and developed with international users in mind!
* Fully WPML compatible!
* Fully Multisite compatible, you can also network-enable it if ever needed (per Site use is recommended).

= Translations =
* English (default, `en_US`) - always included
* German (`de_DE`) - always included
* German formal (`de_DE_formal`) - always included
* Spanish (`es_ES`) - user-submitted - currently 37% complete for v1.5.0
* `.pot` file (`genesis-widgetized-notfound.pot`) for translators is also always included :)
* Easy plugin translation platform with GlotPress tool: [Translate "Genesis Widgetized Not Found & 404"...](https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound)

= Feedback =
* I am open for your suggestions and feedback - Thank you for using or trying out one of my plugins!
* Join our [**Facebook User Community Support Group**](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)

= My Other Plugins =
* [**Toolbar Extras for Genesis & Elementor - WordPress Admin Bar Enhanced**](https://wordpress.org/plugins/toolbar-extras/)
* [**Builder Template Categories - for WordPress Page Builders**](https://wordpress.org/plugins/builder-template-categories/)
* [Genesis What's New Info](https://wordpress.org/plugins/genesis-whats-new-info/)
* [Genesis Layout Extras](https://wordpress.org/plugins/genesis-layout-extras/)
* [Genesis Widgetized Footer](https://wordpress.org/plugins/genesis-widgetized-footer/)
* [Genesis Widgetized Archive](https://wordpress.org/plugins/genesis-widgetized-archive/)
* [Multisite Toolbar Additions](https://wordpress.org/plugins/multisite-toolbar-additions/)
* [Cleaner Plugin Installer](https://wordpress.org/plugins/cleaner-plugin-installer/)

== Installation ==

**NOTE:** Only works with *Genesis Framework* as the parent theme. This is a paid premium product by StudioPress/ WPEngine, Inc., [available via studiopress.com](https://deckerweb.de/go/genesis/)

1. Upload `genesis-widgetized-notfound` folder to the `/wp-content/plugins/` directory -- or just upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Got the "Widgets" admin page and configure your widgets for the "404 Error Page" and the "Search Not Found" page.
4. Hope the new widgets will never be needed, but in case, you're prepared now! :-)

**Note:** The "Genesis Framework" is required for this plugin in order to work. If you don't own a copy it yet, this premium parent theme has to be bought. More info about that you'll find here: [https://deckerweb.de/go/genesis/](https://deckerweb.de/go/genesis/)

**Own translation/wording:** For custom and update-secure language files please upload them to `/wp-content/languages/genesis-widgetized-notfound/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `genesis-widgetized-notfound-en_US.mo/.po` to achieve that (for creating one see the tools on "Other Notes").

== Frequently Asked Questions ==

= How can I change the layout of the '404 Error Page' (i.e. go full-width)? =
You can use my ["Genesis Layout Extras" plugin](https://wordpress.org/plugins/genesis-layout-extras/) for that, which has an option for the 404 case built in. Or you can also use my built in helper function and add this little line to your `functions.php` of your child theme (backup file before!) or to the "Custom Function" section of Prose Child Theme 1.5+:
`
/** Genesis Widgetized NotFound: 404 Error Page - Full-Width Layout */
add_action( 'genesis_meta', '__gwnf_layout_404_full_width' );
`

= How can I change the layout of the 'Search not found' Page (i.e. go full-width)? =
You can use my ["Genesis Layout Extras" plugin](https://wordpress.org/plugins/genesis-layout-extras/) for that, which has an option for the search case built in. -- Or you can also use my built in helper function and add this little line to your `functions.php` of your child theme (backup file before!) or to the "Custom Functions" section of Prose Child Theme 1.5+:
`
/** Genesis Widgetized NotFound: Search not found Page - Full-Width Layout */
add_action( 'genesis_meta', '__gwnf_layout_searchnotfound_full_width' );
`
*Note:* The above code is restricted to the case when NO search results are found! It doesn't effect your search results display IF THERE ARE any results!

= How can I style the content/widget areas? =
It's all done via your child theme. Maybe you need to add an "!important" to some CSS rules here and there... For more even better styling I included some IDs and classes:

* "404 Error Page" section:
 * the whole content area, before and after all widgets is wrapped in a div with the ID: `#gwnf-404-area`
 * each widget in this area has its own ID depending on the widget (regular WordPress behavior!)
 * each widget gets an additional class: `.gwnf-404` -- which allows to set some common styles for all widgets in this area
* "Search not found" section:
 * the whole content area, before and after all widgets is wrapped in a div with the ID: `#gwnf-notfound-area`
 * each widget in this area has its own ID depending on the widget (regular WordPress behavior!)
 * each widget gets an additional class: `.gwnf-notfound` -- which allows to set some common styles for all widgets in this area

Note, WordPress itself additionally adds body classes in the 404 case and the search not found case. So you can also use these classes: `.error404` and `.search-no-results`

If that's still not enough, you can even enqueue your own style, an action hook is included for that: `gwnf_load_styles` -- This hook fires within the WordPress action hook `wp_enqueue_scripts` just after properly enqueueing the plugin's styles and only if at least one of both widgets is active, so it's fully conditional!


= Could I disable the Shortcode support for widgets? =
Of course, it's possible! Just add the following constant to your child theme's `functions.php` file or to a functionality plugin:
`
/** Genesis Widgetized Not Found & 404: Remove Widgets Shortcode Support */
define( 'GWNF_NO_WIDGETS_SHORTCODE', TRUE );
`
Some webmasters could need this for security reasons regarding their stuff members or for whatever other reasons... :).


= What are parameters of the plugin's own Shortcodes? =

**(1) Parameters for `[gwnf-widget-area]` Shortcode:**

* `area` -- ID of the Widget area (Sidebar) (default: none, empty)
* The following values are accepted: `404` OR `notfound` OR `bbpress-notfound`

**(2) Parameters for `[gwnf-search]` Shortcode:**

* `search_text` -- Search placeholder text (default: `Search this website`)
* `button_text` -- HTML wrapper tag (default: `Search`)
* `form_label` -- Additional label before the search form (default: none, empty)
* `wrapper` -- HTML wrapper tag (default: `Latest update date:`)
* `class` -- Additional custom CSS class for the wrapper (default: none, empty)
* `post_type` -- Optional setup post type(s) for search (default: none, empty - i.e., WordPress default search behavior!)

= Could I completely remove the plugin's Shortcode features? =
Of course, that's possible! Just add the following constant to your child theme's `functions.php` file or to a functionality plugin:
`
/** Genesis Widgetized Not Found & 404: Remove Shortcode Features */
define( 'GWNF_SHORTCODE_FEATURES', TRUE );
`

= Can I remove the widgetized content area for bbPress forum search "not found"? =
Of course, that's possible - very easily :). Just add the following line of code to your child theme's `functions.php` file or a functionality plugin:

`
/**
 * Genesis Widgetized Not Found & 404:
 *  Remove bbPress Widgetized Content Area on "not found"
 */
add_filter( 'gwnf_filter_bbpress_noresults_widgetized', '__return_false' );
`


= How can I customize the widget titles/strings in the admin? =
I've just included some filters for that - if ever needed (i.e. for clients, branding purposes etc.), you can use these filters:

**gwnf/filter/widget_areas/404/title** - default value: "404 Error Page"

**gwnf/filter/widget_areas/404/description** - default value: "This is the widget area of the 404 Not Found Error Page."

**gwnf/filter/widget_areas/notfound/title** - default value: "Search Not Found"

**gwnf/filter/widget_areas/notfound/description** - default value: "This is the widget area of the search not found content section."

**gwnf_filter_notfound_default** - default value: "Sorry, no content matched your criteria. Try a different search?"

Example code for changing one of these filters:
`
add_filter( 'gwnf/filter/widget_areas/404/title', 'custom_404_widget_title' );
/**
 * Genesis Widgetized NotFound: Custom 404 Widget Title
 */
function custom_404_widget_title() {
	return __( 'Custom Error Page', 'your-child-theme-textdomain' );
}
`


**Final note:** I DON'T recommend to add customization code snippets to your child theme's `functions.php` file! **Please use a functionality plugin instead!** In general you should not abusing the functions.php for plugin-specific stuff. And you are then also more independent from child theme changes etc. If you don't know how to create such a plugin yourself just use one of my recommended 'Code Snippets' plugins. Read & bookmark these Sites:

* [**Code Snippets** plugin by Shea Bunge](https://wordpress.org/plugins/code-snippets/)
* [**PHP Code Snippets (Insert PHP)** plugin by webcraftic](https://wordpress.org/plugins/insert-php/)
* [**"What is a functionality plugin and how to create one?"**](http://wpcandy.com/teaches/how-to-create-a-functionality-plugin) - *blog post by WPCandy*
* [**"Creating a custom functions plugin for end users"**](http://justintadlock.com/archives/2011/02/02/creating-a-custom-functions-plugin-for-end-users) - *blog post by Justin Tadlock*

All the custom & branding stuff code above can also be found as a [Gist on GitHub: https://gist.github.com/deckerweb/2473125](https://gist.github.com/deckerweb/2473125) (you can also add your questions/ feedback there :)

= How can I use the advantages of this plugin for multlingual sites? =
(1) In general: You may use it for "global" widgets.

(2) Usage with the "WPML" plugin:
Widgets can be translated with their "String Translation" component - this is much easier than adding complex information/instructions to the 404 error or search not found pages for a lot of languages...

You can use the awesome ["Widget Options"](https://wordpress.org/plugins/widget-options/) or ["Widget Logic"](https://wordpress.org/plugins/widget-logic/) plugins (or similar ones) and add additional paramaters, mostly conditional stuff like `is_home()` in conjunction with `is_language( 'de' )` etc. This way widget usage on a per-language basis is possible. Or you place in the WPML language codes like `ICL_LANGUAGE_CODE == 'de'` for German language. Fore more info on that see their blog post: http://wpml.org/2011/03/howto-display-different-widgets-per-language/

With the following language detection code you are now able to make conditional statements, in the same way other WordPress conditional functions work, like `is_single()`, `is_home()` etc.:
`
/**
 * WPML: Conditional Switching Languages
 *
 * @author David Decker - DECKERWEB
 * @link   https://twitter.com/deckerweb
 *
 * @global mixed $sitepress
 */
function is_language( $current_lang ) {

	global $sitepress;

	if ( $current_lang == $sitepress->get_current_language() ) {
		return TRUE;
	}
}
`

*Note:* Be careful with the function name 'is_language' - this only works if there's no other function in your install with that name! If it's already taken (very rare case though), then just add a prefix like `my_custom_is_language()`.

--> You now can use conditionals like that:

`
if ( is_language( 'de' ) ) {
	// do something for German language...
} elseif ( is_language( 'es' ) ) {
	// do something for Spanish language...
}
`


== Screenshots ==

1. Two additional Widget areas - here with some example widgets placed in

2. Live site: displaying 404 Page - widgetized now! (Demo: Genesis Sample 2.6.0)

3. Live site: displaying here the "Search not found" page (Demo: Genesis Sample 2.6.0)

4. Widgets in Customizer with Live Preview: setup the 404 Error Page Widget area (Demo: Genesis Sample 2.6.0)

5. The plugin's own search widget called "Genesis - Search Form" with way more options than the WordPress core search widget!

6. The lugin's optional Shortcodes in action for a page

7. Live site: Shortcode from test page in action (Demo: Genesis Sample 2.6.0)

8. Submenu on Genesis Settings - quick access to setup

9. The plugin's help tab on the Widgets admin page with additional info

10. Plugins page entry with Quick Jump Links for setup, preview/ testing


== Changelog ==

= 1.6.2 - 2018-11-03 =
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.0) - which brings enhanced CSS styles, including for the "Dark Mode" plugin
* Tweak: Few internal code tweaks and improvements


= 1.6.1 - 2018-10-01 =
* New: Added plugin update message also to Plugins page (overview table)
* New: Created special [Facebook Group for user community support](https://www.facebook.com/groups/deckerweb.wordpress.plugins/) for all plugins from me (David Decker - DECKERWEB), this one here included! ;-) - [please join at facebook!](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.1.0) - which brings smaller additions and enhancements, like CSS styles to the upload areas and plugin cards, plus plugin version number on plugin cards
* Tweak: Internal code improvements and tweaks
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs


= 1.6.0 - 2018-08-25 =
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


= 1.5.0 - 2013-05-29 =
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


= 1.4.0 - 2012-12-15 =
* *Maintenance release*
* UPDATE: Added the class placeholder to widget registrations to fullfill WordPress standard for Widgets API.
* NEW: Added constant for disabling the widget shortcode support (see FAQ here).
* CODE: Some code/documentation updates & improvements.
* UPDATE: Updated readme.txt file here.
* UPDATE: Initiated new three digits versioning, starting with this version.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Moved screenshots to 'assets' folder in WP.org SVN to reduce plugin package size.


= 1.3.0 - 2012-08-20 =
* *Maintenance release*
* NEW: Added help tab also on Genesis settings page.
* NEW: Compressed CSS file for improved performance (the development file has now the file name `gwnf-styles.dev.css` and is still packaged).
* CODE: Minor code/documentation updates & improvements.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Extended GPL License info in readme.txt as well as main plugin file.
* NEW: Easy plugin translation platform with GlotPress tool: [Translate "Genesis Widgetized Not Found & 404"...](https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound)


= 1.2.0 - 2012-04-27 =
* NEW: Added little help tab on Widget admin page for better user experience. (Works only with WordPress 3.3 or higher!)
* UPDATE: Moved plugin links from main file to extra admin file which only loads within 'wp-admin', this way it's performance-improved! This also effects the new help tab stuff :).
* UPDAGE: Added action hook `gwnf_load_styles` if you ever need to properly enqueue your own stylesheet for the edge cases... (Also see FAQ here).
* CODE: Minor code/documentation tweaks and improvements.
* UPDATE: Extended and improved readme.txt file documentation here, corrected typos.
* UPDATE: Updated German translations and also the .pot file for all translators.


= 1.1.0 - 2012-04-23 =
* NEW: Added two helper functions (via child theme) for applying the Genesis 'Full-Width' layout option for one or both 'not found' cases! This is very handy for lots of use cases... -- [See the FAQ section for more info on that!](https://wordpress.org/plugins/genesis-widgetized-notfound/#faq)
* UPDATE: Placed widget display in conditionals only for the "404" or the "Search not found" case to avoid overlaying of more than one 'no content messages'. This should finally cover more edge cases...
* UPDATE: Improved translations loading, especially for activation (messages).
* UPDATE: Improved registering of widget areas/sidebars: switching back to Genesis register function, but now properly wrapped in a conditional, checking for activated Genesis. This way we also get further improved Multisite support!
* UPDATE: Improved CSS styling, handling the limition of the empty "p" (left over from the original "no content status" of Genesis).
* UPDATE: Updated German translations and also the .pot file for all translators.


= 1.0.1 - 2012-04-20 =
* Bugfix release. Mmh, stuff happens...
* UPDATE: Changed widget registering from Genesis to WordPress function (it doesn't matter in the end!)
* BUGFIX: Fixed function typo that was causing notices on plugin activation.
* UPDATE: Minor code documentation updates. Also, minor updates to readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators.
* UPDATE: Added banner image on WordPress.org for better plugin branding :)


= 1.0.0 - 2012-04-20 =
* Initial release


== Upgrade Notice ==

= 1.6.2 =
Maintenance release. Bundled library update. Small tweaks. Update recommended.

= 1.6.1 =
Maintenance release: Various tweaks and improvements, plus updated bundled library. Update recommended.

= 1.6.0 =
Major release: Back in life :) - improved user guiding in admin. Lots of improvements, tweaks and fixes.

= 1.5.0 =
Major additions & improvements: Own search widget; Shortcodes. Some code & documentation optimizations and improvements. Also updated .pot file for translators plus German & Spanish translations.

= 1.4.0 =
Maintenance release: Improvements for the Widgets API. Minor code & documentation improvements. Also updated .pot file for translators plus German translations.

= 1.3.0 =
Maintenance release: Added help tab for Genesis settings. Minor code & documentation improvements. Also updated .pot file for translators plus German translations.

= 1.2.0 =
Several changes & improvements: Performance/Code improvements. Added little help tab, corrected typos and extended readme.txt documentation. Also updated .pot file for translators plus German translations.

= 1.1.0 =
Several changes & improvements: Added two layout helper functions. Further, improved conditional checks, code and documentation. Also updated readme.txt file as well as .pot plus German translations.

= 1.0.1 =
Several minor changes, mostly fixing two ugly bugs. Also changed readme files and updated translations.

= 1.0.0 =
Just released into the wild.

== Donate ==
Enjoy using *Genesis Widgetized Not Found & 404*? [**Please consider making a donation**](https://www.paypal.me/deckerweb) to support the project's continued development.

== Plugin Links ==
* [Translations (WP GlotPress Platform)](https://translate.wordpress.org/projects/wp-plugins/genesis-widgetized-notfound)
* [User support forums](https://wordpress.org/support/plugin/genesis-widgetized-notfound)
* [Code snippets archive for customizing, GitHub Gist](https://gist.github.com/deckerweb/2473125)
* [DECKERWEB WordPress Plugins Facebook Group](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)

== Translations ==

* English - default, always included
* German (de_DE): Deutsch - immer dabei! [Download auch via deckerweb.de](http://deckerweb.de/material/sprachdateien/genesis-plugins/#genesis-widgetized-notfound)
* Spanish (es_ES): Español - user-submitted, only a few strings yet...
* For custom and update-secure language files please upload them to `/wp-content/languages/genesis-widgetized-notfound/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that as well, just use a language file like `genesis-widgetized-notfound-en_US.mo/.po` to achieve that.

**Easy plugin translation platform with GlotPress tool:** [**Translate "Genesis Widgetized Not Found & 404"...**](http://translate.wpautobahn.com/projects/genesis-plugins-deckerweb/genesis-widgetized-notfound)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating I recommend the awesome ["Codestyling Localization" plugin](https://wordpress.org/plugins/codestyling-localization/) and for validating the ["Poedit Editor"](http://www.poedit.net/), which works fine on Windows, Mac and Linux.

== Idea Behind / Philosophy ==
I always wanted the 404 and search not found content easily customizeable! The standard messages like "Sorry, no posts matched your criteria." are a shame and lame user experience. Widgets in WordPress are powerful and allow for adding really diverse and custom stuff. So, when building my "Autobahn" child theme for Genesis I really came across this idea and technique. I also implemented it in a lot of my client projects. Now I am really happy to represent this tool in form of a plugin to make more webmasters and especially users/visitors really happy - and help them stay longer on your site!

== Credits ==
* Thanks to Genesis User & Blogger [Rick R. Duncan @RickRDuncan](https://twitter.com/RickRDuncan) for mentioning and supporting this plugin when it came out - Thank you! :-)
* Any other blog post or something cool about this plugin? - Just contact me :)