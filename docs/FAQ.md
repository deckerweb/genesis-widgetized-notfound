# FAQ by topic

### Where do I add the content?

Open Genesis → Not Found & 404 Page for the setup overview, layout options, search message and optional 404 starter. Use each area’s editing link or Appearance → Widgets to assign content.

### Does this work without Genesis?

The page integration requires an active Genesis parent theme. Without Genesis it pauses safely and keeps saved widgets. The Library and updater remain available.

### What happens with empty widget areas?

An empty 404 area keeps Genesis output unless the optional 404 starter is enabled. An empty search area shows the no-results message and search form. bbPress keeps its own feedback when its widget area is empty. Assigned widgets take precedence even if their own visibility rules hide them.

### Which shortcodes are available?

Use [gwnf-search] and [gwnf-widget-area area="404"]. The other area values are notfound and bbpress-notfound. Search attributes: search_text, button_text, form_label, wrapper, class, post_type. Copy buttons for the search form and the two main areas are available on the settings page; manual selection also works. Area shortcodes do not insert 404 starter content.

### Does it support Multisite?

Yes. Widgets belong to each site. Network activation is allowed; Genesis features run only on sites using Genesis. Shared Library settings belong to the network. Theme editors manage widgets; network administrators manage network-wide plugin updates.

### Does a 404 still return HTTP 404?

Yes. WordPress and Genesis determine the HTTP status. This plugin changes the displayed content, without redirects or soft-404 handling.

### What happens to data when I remove it?

Deactivation and uninstall preserve widget content and this site’s presentation settings. Final-host uninstall cleans temporary shared Library data; optional Library settings deletion follows its own switch. Other plugins and content are never deleted.

## Customization and development

### How do I style the widget areas?

Use child-theme CSS with #gwnf-404-area, #gwnf-notfound-area and .gwnf-bbpress-notfound-area. The gwnf_load_styles action allows additional enqueued styles. Custom CSS is not stored by this plugin.

### How do I use a full-width layout?

Enable the corresponding option under Genesis → Not Found & 404 Page. The search option only changes searches with no results; successful searches keep their usual layout. Existing __gwnf_layout_404_full_width and __gwnf_layout_searchnotfound_full_width helpers remain available.

### Can I disable shortcodes?

Define GWNF_SHORTCODE_FEATURES as false before init to disable both plugin shortcodes. Define GWNF_NO_WIDGETS_SHORTCODE as true to disable the plugin-added legacy text-widget processing. WordPress’s own modern text-widget shortcode support remains under WordPress control.

### How do search attributes work?

wrapper accepts div, section, aside, nav and span, falling back to div. class supports space-separated CSS classes. post_type accepts comma-separated publicly searchable registered post types. Label text is always provided to assistive technology, even with no custom label.

### Which developer filters remain available?

Existing gwnf output/title/description filters remain. The intended area-description filters gwnf/filter/widget_areas/404/description and gwnf/filter/widget_areas/notfound/description now receive the corresponding area. gwnf_filter_shortcode_widget_area now filters the captured output.

### How do I change the default search message?

Enter plain text under Genesis → Not Found & 404 Page. It appears only when the Search Not Found widget area is empty; the search form stays visible. Leave the field empty to restore the translated default. The existing output filter remains available. Without Genesis, the settings page is under Settings.

### How do I test the result?

Use the frontend test links on the settings page for a normal missing-page request and a search with a random term. The existing Customizer previews remain available. Also check the result while logged out. Search plugins or redirects can change the outcome.

### Why is an assigned search widget not visible?

Check its display rule and logged-in-only setting. Single-post and single-page rules do not match 404 or empty-search contexts. Use Global or the matching new rule. The setup overview and saved widget form explain conflicting rules. A hidden assigned widget does not count as an empty area.
