<?php

// includes/gwnf-widget-search

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * The main plugin class - creating the bbPress search widget
 *
 * @since 1.5.0
 */
class DDW_GWNF_Search_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @since 1.6.0
	 *
	 * @var   array
	 */
	protected $defaults;


	/**
	 * Constructor.
	 *
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.5.0
	 */
	public function __construct() {
	
		/** Array of default widget options */
		$this->defaults = array(
			'hide_title'       => 0,
			'title_url'        => '',
			'title_url_target' => 0,
			'label_text'       => apply_filters( 'genesis_search_form_label', '' ),
			'placeholder_text' => apply_filters( 'genesis_search_text', esc_attr__( 'Search this website', 'genesis-widgetized-notfound' ) . ' &#x02026;' ),
			'button_text'      => apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis-widgetized-notfound' ) ),
			'widget_display'   => 'global',
			'not_in_public'    => 0
		);

		/** Defaults array, filterable */
		$this->defaults = (array) apply_filters( 'gwnf_filter_search_widget_defaults', $this->defaults );

		$widget_options = apply_filters(
			'gwnf_filter_search_widget_options',
			array(
				'classname'   => 'gwnf-search-widget',
				'description' => esc_html__( 'A search form for your site. With a more options than the default one.', 'genesis-widgetized-notfound' ) . ' &ndash; ' . sprintf(
					esc_html__( 'Provided by the plugin %s.', 'genesis-widgetized-notfound' ),
					'*' . __( 'Genesis Widgetized Not Found & 404', 'genesis-widgetized-notfound' ) . '*'
				),
			)
		);

		/* Set up (additional) widget control options. */
		$control_options = array(
			'id_base' => 'gwnf-search-widget'
		);

		/** Create the widget */
		parent::__construct(
			'gwnf-search-widget',
			__( 'Genesis - Search Form', 'genesis-widgetized-notfound' ),
			$widget_options,
			$control_options
		);

	}  // end method


	/**
	 * Display the widget, based on the parameters/ arguments set through the
	 *    widget options.
	 *
	 * @since 1.5.0
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
	
		/** Check SPECIFIC display option for this widget and optionally disable it from displaying */
		if ( $instance[ 'not_in_public' ] && ! is_user_logged_in() ) {
			return;
		}

		/** Check GENERAL display option for this widget and optionally disable it from displaying */
		if (
				/** Posts/ Pages stuff */
			( ( 'single_posts' == $instance[ 'widget_display' ] ) && ! is_singular( 'post' ) )
			|| ( ( 'single_pages' == $instance[ 'widget_display' ] ) && ! is_singular( 'page' ) )
			|| ( ( 'single_posts_pages' == $instance[ 'widget_display' ] ) && ! is_singular( array( 'post', 'page' ) ) )
		) {

			return;

		}  // end-if widget display checks


		/** Extract the widget arguments */
		extract( $args );

		/** Set up the arguments */
		$args = array(
			'intro_text' => $instance[ 'intro_text' ],
			'outro_text' => $instance[ 'outro_text' ]
		);

		$instance = wp_parse_args( (array) $instance, array(
			'title'            => '',
			'label_text'       => '',
			'placeholder_text' => '',
			'button_text'      => ''
		) );

		/** Optional title URL target */
		$title_url_target = ( $instance[ 'title_url_target' ] ) ? ' target="_blank"' : '';

		/** Typical WordPress Widget title filter */
		$title = apply_filters( 'widget_title', $instance[ 'title' ], $instance, $this->id_base );

		/** GWNF Widget title filter */
		$title = apply_filters( 'gwnf_filter_search_widget_title', $instance[ 'title' ], $instance, $this->id_base );

		/** Build the title display string */
		$title_display = sprintf(
			'%1$s%2$s%3$s',
			( ! empty( $instance[ 'title_url' ] ) ) ? '<a href="' . esc_url( $instance[ 'title_url' ] ) . '"' . $title_url_target . '>' : '',
			esc_attr( $instance[ 'title' ] ),
			( ! empty( $instance[ 'title_url' ] ) ) ? '</a>' : ''
		);

		/** Output the widget wrapper and title */
		echo $before_widget;

		/** Display the widget title */
		if ( empty( $instance[ 'hide_title' ] ) && $instance[ 'title' ] ) {

			echo $before_title . $title_display . $after_title;

		}  // end-if title

		/** Action hook 'gwnf_before_search_widget' */
		do_action( 'gwnf_before_search_widget' );

		/** Display widget intro text if it exists */
		if ( ! empty( $instance[ 'intro_text' ] ) ) {

			echo '<div class="textwidget"><p class="'. $this->id . '-intro-text gwnf-intro-text">' . $instance[ 'intro_text' ] . '</p></div>';

		}  // end-if optional intro

		/** Set filters for various strings */
		$gwnf_label_string  = ( ! empty( $instance[ 'label_text' ] ) ) ? '<label class="screen-reader-text gwnf-search-label" for="s">' . apply_filters( 'gwnf_filter_label_string', $instance[ 'label_text' ] ) . '</label>' : '';
		$gwnf_search_string = get_search_query() ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : apply_filters( 'gwnf_filter_placeholder_string', $instance[ 'placeholder_text' ] );
		$gwnf_button_string = apply_filters( 'gwnf_filter_button_string', $instance[ 'button_text' ] );

		/** Helper Strings */
		$gwnf_onfocus = "onfocus=\"if (this.value == '$gwnf_search_string') {this.value = '';}\"";
		$gwnf_onblur  = "onblur=\"if (this.value == '') {this.value = '$gwnf_search_string';}\"";

		/** XHTML search form */
		$gwnf_xhtml_form = sprintf(
			'<form method="get" class="searchform search-form gwnf-search-widget" action="%1$s" role="search" >%2$s<input type="text" value="%3$s" name="s" class="s search-input" %4$s %5$s /><input type="submit" class="searchsubmit search-submit" value="%6$s" /></form>',
			esc_url( home_url( '/' ) ),
			$gwnf_label_string,
			esc_attr( $gwnf_search_string ),
			$gwnf_onfocus,
			$gwnf_onblur,
			esc_attr( $gwnf_button_string )
		);

		/** HTML5 search form */
		$gwnf_html5_form = sprintf(
			'<form method="get" class="search-form gwnf-search-widget" action="%1$s" role="search">%2$s<input type="search" name="s" placeholder="%3$s" /><input type="submit" value="%4$s" /></form>',
			esc_url( home_url( '/' ) ),
			$gwnf_label_string,
			$gwnf_search_string,
			esc_attr( $gwnf_button_string )
		);

		//$form = ( function_exists( 'genesis_html5' ) && genesis_html5() ) ? $gwnf_html5_form : $gwnf_xhtml_form;
		$gwnf_search_form = ( function_exists( 'genesis_html5' ) && genesis_html5() ) ? $gwnf_html5_form : $gwnf_xhtml_form;

		/** Search form output for display */
		echo '<div id="gwnf-search-widget-wrapper">' . $gwnf_search_form . '</div>';

		/** Display widget outro text if it exists */
		if ( ! empty( $instance[ 'outro_text' ] ) ) {

			echo '<div class="textwidget"><p class="'. $this->id . '-outro_text gwnf-outro-text">' . $instance[ 'outro_text' ] . '</p></div>';

		}  // end-if optional outro

		/** Action hook 'gwnf_after_search_widget' */
		do_action( 'gwnf_after_search_widget' );

		/** Output the closing widget wrapper */
		echo $after_widget;

	}  // end method


	/**
	 * Updates the widget control options for the particular instance of the
	 *    widget.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since  1.5.0
	 *
	 * @param  array $new_instance New settings for this instance as input by the user via form()
	 * @param  array $old_instance Old settings for this instance
	 *
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {

		/** Strip tags from elements that don't need them */
		$new_instance[ 'title' ]            = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
		$new_instance[ 'hide_title' ]       = isset( $new_instance[ 'hide_title' ] );
		$new_instance[ 'title_url' ]        = strip_tags( stripslashes( $new_instance[ 'title_url' ] ) );
		$new_instance[ 'title_url_target' ] = isset( $new_instance[ 'title_url_target' ] );
		$new_instance[ 'intro_text' ]       = current_user_can( 'unfiltered_html' ) ? $new_instance[ 'intro_text' ] : genesis_formatting_kses( $new_instance[ 'intro_text' ] );
		$new_instance[ 'outro_text' ]       = current_user_can( 'unfiltered_html' ) ? $new_instance[ 'outro_text' ] : genesis_formatting_kses( $new_instance[ 'outro_text' ] );
		$new_instance[ 'label_text' ]       = strip_tags( stripslashes( $new_instance[ 'label_text' ] ) );
		$new_instance[ 'placeholder_text' ] = strip_tags( stripslashes( $new_instance[ 'placeholder_text' ] ) );
		$new_instance[ 'button_text' ]      = strip_tags( stripslashes( $new_instance[ 'button_text' ] ) );
		$new_instance[ 'widget_display' ]   = strip_tags( $new_instance[ 'widget_display' ] );
		//$new_instance[ 'not_in_bbpbase' ]   = strip_tags( $new_instance[ 'not_in_bbpbase' ] );
		//$new_instance[ 'not_in_bbpsearch' ] = strip_tags( $new_instance[ 'not_in_bbpsearch' ] );
		$new_instance[ 'not_in_public' ]    = isset( $new_instance[ 'not_in_public' ] );

		return $new_instance;

	}  // end method


	/**
	 * Displays the widget options in the Widgets admin screen.
	 *
	 * @since 1.5.0
	 *
	 * @param array $instance Current settings
	 */
	public function form( $instance ) {

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		/** Get values from instance */
		$title      = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : null;
		$title_url  = ( isset( $instance[ 'title_url' ] ) ) ? esc_url( $instance[ 'title_url' ] ) : null;
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;
	
		$gwnf_hr_style = 'style="border: 1px dashed #ddd; margin: 15px 0 !important;"';
		$gwnf_select_divider = '<option value="void" disabled="disabled">—————————————————</option>';

		/** Begin form code */
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title:', 'genesis-widgetized-notfound' ); ?></strong>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
	   	</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title_url' ); ?>">
			<?php _e( 'Optional Title URL:', 'genesis-widgetized-notfound' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title_url' ); ?>" name="<?php echo $this->get_field_name( 'title_url' ); ?>" value="<?php echo $title_url; ?>" />
	   	</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'title_url_target' ] ); ?> id="<?php echo $this->get_field_id( 'title_url_target' ); ?>" name="<?php echo $this->get_field_name( 'title_url_target' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'title_url_target' ); ?>">
				<?php _e( 'Open the URL in a new window/ tab?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'hide_title' ] ); ?> id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'hide_title' ); ?>">
				<?php _e( 'Do not display the Title?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<label for="<?php /** Optional intro text */ echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Optional intro text:', 'genesis-widgetized-notfound' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'genesis-widgetized-notfound' ), __( 'Search', 'genesis-widgetized-notfound' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<strong><?php _e( 'Search form', 'genesis-widgetized-notfound' ); ?>:</strong>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'label_text' ); ?>">
			<?php _e( 'Label string before search input field:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'label_text' ); ?>" name="<?php echo $this->get_field_name( 'label_text' ); ?>" value="<?php echo esc_attr( $instance[ 'label_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'placeholder_text' ); ?>">
			<?php _e( 'Placeholder string for search input field:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_text' ); ?>" value="<?php echo esc_attr( $instance[ 'placeholder_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>">
			<?php _e( 'Search button string:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $instance[ 'button_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Displaying may depend on your child theme settings/ styles.', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
    		<label for="<?php echo $this->get_field_id( 'widget_display' ); ?>">
				<strong><?php _e( 'Where to display this widget?', 'genesis-widgetized-notfound' ); ?>:</strong>
				<select id="<?php echo $this->get_field_id( 'widget_display' ); ?>" name="<?php echo $this->get_field_name( 'widget_display' ); ?>">        
					<?php
						printf( '<option value="global" %s>%s</option>', selected( 'global', $instance[ 'widget_display' ], 0 ), __( 'Global (default)', 'genesis-widgetized-notfound' ) );
						
						echo $gwnf_select_divider;

						printf( '<option value="single_posts" %s>%s</option>', selected( 'single_posts', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'genesis-widgetized-notfound' ), __( 'Posts', 'genesis-widgetized-notfound' ) ) );

						printf( '<option value="single_pages" %s>%s</option>', selected( 'single_pages', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'genesis-widgetized-notfound' ), __( 'Pages', 'genesis-widgetized-notfound' ) ) );

						printf( '<option value="single_posts_pages" %s>%s</option>', selected( 'single_posts_pages', $instance[ 'widget_display' ], 0 ), __( 'Both, Single Posts & Pages', 'genesis-widgetized-notfound' ) );
					?>
				</select>
        	</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'not_in_public' ] ); ?> id="<?php echo $this->get_field_id( 'not_in_public' ); ?>" name="<?php echo $this->get_field_name( 'not_in_public' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'not_in_public' ); ?>">
				<?php _e( 'Only displaying for logged in users?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<label for="<?php /** Optional outro text */ echo $this->get_field_id( 'outro_text' ); ?>"><?php _e( 'Optional outro text:', 'genesis-widgetized-notfound' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'genesis-widgetized-notfound' ), __( 'Search', 'genesis-widgetized-notfound' ) ); ?></small>
				<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end method

}  // end of class