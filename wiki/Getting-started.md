# Getting started

[English](Home) · [Deutsch](Start)

1. Download the installable plugin ZIP from Releases and upload it under Plugins → Add Plugin → Upload Plugin.
2. Activate the plugin on a site using Genesis as its parent theme.
3. Open Genesis → Not Found & 404 Page. Review each area and follow its editing link to assign widgets.
4. Choose full-width layouts or a no-results message if needed. For an empty 404 area, optionally enable the starter content.
5. Save and use the frontend test links. Check the result while logged out as well.

The previous installer-recommendations library is removed. Version 2.0.0 is distributed through GitHub and includes the deckerweb Library and Updater. Older saved widgets and settings are preserved. No plugin settings or widget content are deleted on uninstall.

The setup overview shows assigned widget counts, the empty-area fallback and individual editing links, including bbPress when its area is registered. Counts do not guarantee visible output: widget visibility rules still apply. Conflicting search-widget rules and logged-in-only visibility are explained. The new rules Only on 404 pages and Only on searches with no results are optional.

Frontend test links open normal requests in a new tab, separately from the existing Customizer previews. Also test logged out; search plugins and redirects may affect the result. Shortcodes can be copied with the button, or selected manually if clipboard access is unavailable. Widget-area shortcodes render assigned widgets, not starter content.

The optional 404 starter is off by default. When enabled and the 404 widget area is empty, it supplies a heading and explanation, plus optional search form and homepage link. Empty text fields use translated defaults. Assigned 404 widgets always take precedence; even a widget hidden by its own rule prevents the empty-area fallback. Disabling the starter restores the usual Genesis output for an empty 404 area. The real missing-page request keeps its 404 status. All settings belong to the current site.
