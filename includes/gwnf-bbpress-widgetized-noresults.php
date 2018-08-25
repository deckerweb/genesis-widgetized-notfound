<?php

// includes/gwnf-bbpress-widgetized-noresults

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


//add_action( 'init', 'ddw_gwnf_bbpress_search_actions' );
/**
 * Test:
 *
 * @since 1.5.0
 */
function ddw_gwnf_bbpress_search_actions() {

	/** Add the magic bbPress filter to do the heavy lifting, finally! :) */
	add_filter( 'bbp_get_template_part', 'ddw_gwnf_bbpress_noresults_template_logic', 10, 3 );

}  // end function


add_action( 'init', 'ddw_gwnf_bbpress_widgetized_noresults_area', 9 );
/**
 * Register widget area for bbPress Forum search no results status.
 *
 * Note: Forgive this one inline styling rule (at 'before_widget'), please! :)
 *       It just adds appropriate spacing; avoids extra stylesheet HTTP request!
 *
 * @since 1.5.0
 *
 * @uses  register_sidebar()
 */
function ddw_gwnf_bbpress_widgetized_noresults_area() {

	$gwnf_bbpress_noresults_widget_title = esc_html(
		apply_filters(
			'gwnf/filter/widget_areas/bbpress-notfound/title',
			__( 'bbPress: Forum Search No Results', 'genesis-widgetized-notfound' )
		)
	);

	$gwnf_bbpress_noresults_widget_description = apply_filters(
		'gwnf/filter/widget_areas/bbpress-notfound/description',
		__( 'Only for bbPress 2.3+: Widgetized content area if there are no forum search results.', 'genesis-widgetized-notfound' )
	);

	/** Register Sidebar for widgetized "no results" area ---test: bbp-pagination */
	register_sidebar( array(
		'id'            => 'gwnf-bbpress-notfound-area',
		'name'          => $gwnf_bbpress_noresults_widget_title,
		'description'   => esc_attr__( $gwnf_bbpress_noresults_widget_description ),
		'before_widget' => '<div id="%1$s" class="widget gwnf-bbpress-widgetized-noresults %2$s" style="margin-bottom: 30px;">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
	) );

}  // end function


/**
 * Template logic helper function for bbPress filter 'bbp_get_template_part'.
 *
 * @since  1.5.0
 *
 * @param  array  $templates
 * @param  string $slug
 * @param  string $name
 * @return array $templates Array of template parts for bbPress.
 */
function ddw_gwnf_bbpress_noresults_template_logic( $templates, $slug, $name ) {

	/** Only do stuff when on 'feedback-no-search.php' template part: */
	if ( $slug == 'feedback' && $name == 'no-search' && is_bbpress() ) {

		/** Only for no forum search results, remove this original bbPress filter */
		remove_filter( 'the_content', 'bbp_replace_the_content' );

		/**
		 * Add our widgetized area instead.
		 *
		 * Note: This needs to happen early on, BEFORE the original bbPress content.
		 */
		add_action( 'the_content', 'ddw_gwnf_bbpress_widgetized_noresults_content', 5 );

	}  // end-if bbPress template part check

	/** Let bbPress take over its templates again */
	return $templates;

}  // end function


/**
 * Our template part:
 *    Widgetized content area, when there are no bbPress Forum search results.
 *
 * @since 1.5.0
 *
 * @uses  bbp_breadcrumb() 	Original bbPress breadcrumb functionality.
 * @uses  do_action() 		Original bbPress action hooks.
 */
function ddw_gwnf_bbpress_widgetized_noresults_content() {

	/** Let bbPress take over its own Breadcrumbs */
	echo '<div id="bbpress-forums">';
		bbp_breadcrumb();
	echo '</div>';

	/** Add bbPress own "before" action hook */
	do_action( 'bbp_template_before_search' );

	/** Here is where the magic happens - our widgetized area gets displayed */
	echo '<div id="gwnf-bbpress-widgetized-content" class="gwnf-bbpress-notfound-area entry-content">';

		dynamic_sidebar( 'gwnf-bbpress-notfound-area' );

	echo '</div><!-- end #content .gwnf-bbpress-notfound-area .entry-content -->';

	/** Add bbPress own "after" action hook */
	do_action( 'bbp_template_after_search_results' );

}  // end function