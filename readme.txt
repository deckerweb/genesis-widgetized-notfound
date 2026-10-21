=== Genesis Widgetized Not Found & 404 ===
Contributors: daveshine
Tags: genesis, 404, widgets, search
Requires at least: 6.4
Tested up to: 7.1.3
Requires PHP: 8.1
Stable tag: 2.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Widgetized Genesis 404 pages and empty searches, with an accessible search widget and shortcodes.

== Description ==

The search widget controls label, placeholder and button text. Shortcodes place forms or active widget areas in supported content. bbPress gets its own area for unsuccessful forum searches. Styling comes from your child theme.

Under Genesis → Not Found & 404 Page, choose full content width separately for 404 and empty searches, and customize the default search message. Both layout options are off by default; an empty text field uses the translated default. Settings belong to each site and are preserved when the plugin is removed.

GitHub updates request release metadata and download the package during an update. The Library displays its bundled catalog locally; online catalog retrieval is optional and off by default. GitHub sees the requesting IP address during external requests. No telemetry or required GitHub account/token. If an active Git Updater causes problems, temporarily deactivate it and reactivate it afterward if needed.

The setup overview shows assigned widget counts, the empty-area fallback and individual editing links, including bbPress when its area is registered. Counts do not guarantee visible output: widget visibility rules still apply. Conflicting search-widget rules and logged-in-only visibility are explained. The new rules Only on 404 pages and Only on searches with no results are optional.

Frontend test links open normal requests in a new tab, separately from the existing Customizer previews. Also test logged out; search plugins and redirects may affect the result. Shortcodes can be copied with the button, or selected manually if clipboard access is unavailable. Widget-area shortcodes render assigned widgets, not starter content.

The optional 404 starter is off by default. When enabled and the 404 widget area is empty, it supplies a heading and explanation, plus optional search form and homepage link. Empty text fields use translated defaults. Assigned 404 widgets always take precedence; even a widget hidden by its own rule prevents the empty-area fallback. Disabling the starter restores the usual Genesis output for an empty 404 area. The real missing-page request keeps its 404 status. All settings belong to the current site.

== Installation ==

Upload the plugin ZIP and activate it. Genesis must be the active parent theme on the current site. Open **Appearance → Widgets** and populate the two areas. Updates preserve existing widget IDs and settings.

== Frequently Asked Questions ==

= Where do I add the content? =

Open Genesis → Not Found & 404 Page for the setup overview, layout options, search message and optional 404 starter. Use each area’s editing link or Appearance → Widgets to assign content.

= Does this work without Genesis? =

The page integration requires an active Genesis parent theme. Without Genesis it pauses safely and keeps saved widgets. The Library and updater remain available.

= What happens with empty widget areas? =

An empty 404 area keeps Genesis output unless the optional 404 starter is enabled. An empty search area shows the no-results message and search form. bbPress keeps its own feedback when its widget area is empty. Assigned widgets take precedence even if their own visibility rules hide them.

= Which shortcodes are available? =

Use [gwnf-search] and [gwnf-widget-area area="404"]. The other area values are notfound and bbpress-notfound. Search attributes: search_text, button_text, form_label, wrapper, class, post_type. Copy buttons for the search form and the two main areas are available on the settings page; manual selection also works. Area shortcodes do not insert 404 starter content.

= Does it support Multisite? =

Yes. Widgets belong to each site. Network activation is allowed; Genesis features run only on sites using Genesis. Shared Library settings belong to the network. Theme editors manage widgets; network administrators manage network-wide plugin updates.

= Does a 404 still return HTTP 404? =

Yes. WordPress and Genesis determine the HTTP status. This plugin changes the displayed content, without redirects or soft-404 handling.

= What happens to data when I remove it? =

Deactivation and uninstall preserve widget content and this site’s presentation settings. Final-host uninstall cleans temporary shared Library data; optional Library settings deletion follows its own switch. Other plugins and content are never deleted.

== Changelog ==

= 2.0.1 · 2026-10-21 =

* Improved: Updated deckerweb Library and GitHub Updater with current package and compatibility checks.
* Fixed: Hardened output escaping in search-widget settings.
* Misc: Requires PHP 8.1; WordPress 6.4 remains supported. Existing widgets and settings are preserved.

= 2.0.0 · 2026-10-15 =

* New: Setup overview with widget counts, editing shortcuts and visibility hints.
* New: Optional 404 starter content with custom heading, explanation, search form and homepage link.
* New: Independent full-width options for 404 pages and empty searches, plus a custom no-results message.
* New: Direct frontend tests, copyable shortcodes and search-widget rules for 404 and empty-search pages.
* Improved: Compatibility with current WordPress, PHP and Genesis, including per-site settings and network activation.
* Improved: Accessible search forms, local documentation, German translations and updated banners and icons.
* Fixed: Safer widget input, shortcode rendering and bbPress empty-search integration.
* Misc: Requires WordPress 6.4 and PHP 8.0. Existing widgets and settings are preserved.
* Misc: Distributed through GitHub with deckerweb Library and Updater; the previous installer-recommendations library has been removed.

= 1.6.4 · 2019-05-04 =

* New: Site Health debug information and newsletter links.
* Improved: WordPress 5.2 compatibility, installer recommendations library 1.4.0 and German translations.

= 1.6.3 · 2018-11-22 =

* Improved: Installation instructions, HTTP-status FAQ and installer recommendations library 1.2.1.
* Fixed: Widget administration and Customizer styles while adding widgets.

= 1.6.2 · 2018-11-03 =

* New: Plugin walkthrough video.
* Improved: Installer recommendations library 1.2.0 with Dark Mode styling.

= 1.6.1 · 2018-10-01 =

* New: Update messages on the Plugins screen and community support links.
* Improved: Installer recommendations library 1.1.0 and German translations.

= 1.6.0 · 2018-08-25 =

* New: Genesis menu shortcut, Customizer preview/test links, widget-area hints, GitHub distribution, Composer metadata, icons and installer recommendations.
* Improved: Widget registration, developer filters, documentation, translations and screenshots.
* Misc: Removed unavailable Facetious integration.
