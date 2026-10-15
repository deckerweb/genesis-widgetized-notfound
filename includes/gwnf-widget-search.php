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
 * The main plugin class - creating the site search widget
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
	 * @return void
	 */
	public function __construct() {

		/** Array of default widget options */
		$this->defaults = array(
			'title' => '', 'intro_text' => '', 'outro_text' => '',
			'hide_title'       => 0,
			'title_url'        => '',
			'title_url_target' => 0,
			'label_text'       => apply_filters( 'genesis_search_form_label', '' ),
			'placeholder_text' => apply_filters( 'genesis_search_text', esc_attr__( 'Search this website', 'genesis-widgetized-notfound' ) . ' &#x02026;' ),
			'button_text'      => apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis-widgetized-notfound' ) ),
			'widget_display'   => 'global',
			'not_in_public'    => 0
		);

		/** Filter complete search-widget defaults. @since 1.5.0 @param array $defaults Default saved settings. */
		$this->defaults = (array) apply_filters( 'gwnf_filter_search_widget_defaults', $this->defaults );

		/** Filter widget registration options. @since 1.5.0 @param array $options Widget classname and description. */
		$widget_options = apply_filters(
			'gwnf_filter_search_widget_options',
			array(
				'classname'   => 'gwnf-search-widget',
				'description' => esc_html__( 'A search form for your site. With more options than the default one.', 'genesis-widgetized-notfound' ) . ' &ndash; ' . sprintf(
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
	 * @return void
	 */
	public function widget( $args, $instance ) {
  $instance = wp_parse_args( (array) $instance, $this->defaults );
  if ( ! empty( $instance['not_in_public'] ) && ! is_user_logged_in() ) { return; }
  if ( 'only_404' === $instance['widget_display'] && ! is_404() ) { return; }
  if ( 'only_notfound' === $instance['widget_display'] && ( is_404() || ! is_search() || ! empty( $GLOBALS['wp_query']->posts ) ) ) { return; }
  $contexts = array( 'single_posts' => 'post', 'single_pages' => 'page', 'single_posts_pages' => array( 'post', 'page' ) );
  if ( isset( $contexts[$instance['widget_display']] ) && ! is_singular( $contexts[$instance['widget_display']] ) ) { return; }
  $args = wp_parse_args( $args, array( 'before_widget' => '', 'after_widget' => '', 'before_title' => '', 'after_title' => '' ) );
  $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
  /**
   * Filter the search widget title after the standard WordPress title filter.
   * @since 1.5.0
   * @param string $title Display title; plain text is escaped on output.
   * @param array $instance Saved instance.
   * @param string $id_base Widget type identity.
   */
  $title = apply_filters( 'gwnf_filter_search_widget_title', $title, $instance, $this->id_base );
  echo $args['before_widget']; // Theme-owned widget wrapper.
  if ( empty( $instance['hide_title'] ) && $title ) {
   $display = esc_html( $title );
   if ( $instance['title_url'] ) {
    $display = '<a href="' . esc_url( $instance['title_url'] ) . '"' . ( $instance['title_url_target'] ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>' . $display . '</a>';
   }
   echo $args['before_title'] . $display . $args['after_title'];
  }
  /** Fires before search widget content. @since 1.5.0 */
  do_action( 'gwnf_before_search_widget' );
  if ( $instance['intro_text'] ) { echo '<div class="textwidget gwnf-intro-text">' . wp_kses_post( $instance['intro_text'] ) . '</div>'; }
  /** Filter the accessible search label. @since 1.5.0 @param string $label Plain label text. */
  $label = apply_filters( 'gwnf_filter_label_string', $instance['label_text'] );
  /** Filter the search placeholder. @since 1.5.0 @param string $placeholder Plain placeholder text. */
  $placeholder = apply_filters( 'gwnf_filter_placeholder_string', $instance['placeholder_text'] );
  /** Filter the search submit label. @since 1.5.0 @param string $button Plain button text. */
  $button = apply_filters( 'gwnf_filter_button_string', $instance['button_text'] );
  echo '<div class="gwnf-search-widget-wrapper">' . ddw_gwnf_search_form( array( 'search_text' => $placeholder, 'button_text' => $button, 'form_label' => $label, 'form_class' => 'gwnf-search-widget' ) ) . '</div>';
  if ( $instance['outro_text'] ) { echo '<div class="textwidget gwnf-outro-text">' . wp_kses_post( $instance['outro_text'] ) . '</div>'; }
  /** Fires after search widget content. @since 1.5.0 */
  do_action( 'gwnf_after_search_widget' );
  echo $args['after_widget'];
 }

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
  $new_instance = wp_parse_args( (array) $new_instance, $this->defaults );
  $instance = wp_parse_args( (array) $old_instance, $this->defaults );
  foreach ( array( 'title', 'label_text', 'placeholder_text', 'button_text' ) as $key ) { $instance[$key] = sanitize_text_field( $new_instance[$key] ); }
  foreach ( array( 'hide_title', 'title_url_target', 'not_in_public' ) as $key ) { $instance[$key] = ! empty( $new_instance[$key] ); }
  $instance['title_url'] = esc_url_raw( $new_instance['title_url'] );
  foreach ( array( 'intro_text', 'outro_text' ) as $key ) { $instance[$key] = wp_kses_post( $new_instance[$key] ); }
  $instance['widget_display'] = in_array( $new_instance['widget_display'], array( 'global', 'single_posts', 'single_pages', 'single_posts_pages', 'only_404', 'only_notfound' ), true ) ? $new_instance['widget_display'] : 'global';
  return $instance;
 }

	/**
	 * Displays the widget options in the Widgets admin screen.
	 *
	 * @since 1.5.0
	 *
	 * @param array $instance Current settings
	 * @return void
	 */
	public function form( $instance ) {

		/** Get the values from the instance */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		/** Get values from instance */
		$title      = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : null;
		$title_url  = ( isset( $instance[ 'title_url' ] ) ) ? esc_url( $instance[ 'title_url' ] ) : null;
		$intro_text = ( isset( $instance[ 'intro_text' ] ) ) ? esc_textarea( $instance[ 'intro_text' ] ) : null;
		$outro_text = ( isset( $instance[ 'outro_text' ] ) ) ? esc_textarea( $instance[ 'outro_text' ] ) : null;

		$gwnf_hr_style = 'class="gwnf-widget-divider"';
		$gwnf_select_divider = '<option value="void" disabled="disabled">—————————————————</option>';

		if ( function_exists( 'ddw_gwnf_widget_rule_hint' ) ) { ddw_gwnf_widget_rule_hint( $this->id, $instance ); }
		/** Begin form code */
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<strong><?php _e( 'Title:', 'genesis-widgetized-notfound' ); ?></strong>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo $title; ?>" />
	   	</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>">
			<?php _e( 'Optional Title URL:', 'genesis-widgetized-notfound' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_url' ) ); ?>" value="<?php echo $title_url; ?>" />
	   	</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'title_url_target' ] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'title_url_target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_url_target' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_url_target' ) ); ?>">
				<?php _e( 'Open the URL in a new window/ tab?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'hide_title' ] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_title' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>">
				<?php _e( 'Do not display the Title?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<label for="<?php /** Optional intro text */ echo esc_attr( $this->get_field_id( 'intro_text' ) ); ?>"><?php _e( 'Optional intro text:', 'genesis-widgetized-notfound' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'genesis-widgetized-notfound' ), __( 'Search', 'genesis-widgetized-notfound' ) ); ?></small>
				<textarea name="<?php echo esc_attr( $this->get_field_name( 'intro_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'intro_text' ) ); ?>" rows="2" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<strong><?php _e( 'Search form', 'genesis-widgetized-notfound' ); ?>:</strong>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'label_text' ) ); ?>">
			<?php _e( 'Label string before search input field:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'label_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_text' ) ); ?>" value="<?php echo esc_attr( $instance[ 'label_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>">
			<?php _e( 'Placeholder string for search input field:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder_text' ) ); ?>" value="<?php echo esc_attr( $instance[ 'placeholder_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Leave empty to not use/ display this string!', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
			<?php _e( 'Search button string:', 'genesis-widgetized-notfound' ); ?>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $instance[ 'button_text' ] ); ?>" class="widefat" />
				<small><?php _e( 'NOTE: Displaying may depend on your child theme settings/ styles.', 'genesis-widgetized-notfound' ); ?></small>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_display' ) ); ?>">
				<strong><?php _e( 'Where to display this widget?', 'genesis-widgetized-notfound' ); ?>:</strong>
				<select id="<?php echo esc_attr( $this->get_field_id( 'widget_display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_display' ) ); ?>">
					<?php
						printf( '<option value="global" %s>%s</option>', selected( 'global', $instance[ 'widget_display' ], 0 ), __( 'Global (default)', 'genesis-widgetized-notfound' ) );

						printf( '<option value="only_404" %s>%s</option>', selected( 'only_404', $instance['widget_display'], false ), esc_html__( 'Only on 404 pages', 'genesis-widgetized-notfound' ) );
						printf( '<option value="only_notfound" %s>%s</option>', selected( 'only_notfound', $instance['widget_display'], false ), esc_html__( 'Only on searches with no results', 'genesis-widgetized-notfound' ) );
						echo $gwnf_select_divider;

						printf( '<option value="single_posts" %s>%s</option>', selected( 'single_posts', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'genesis-widgetized-notfound' ), __( 'Posts', 'genesis-widgetized-notfound' ) ) );

						printf( '<option value="single_pages" %s>%s</option>', selected( 'single_pages', $instance[ 'widget_display' ], 0 ), sprintf( __( 'Single %s', 'genesis-widgetized-notfound' ), __( 'Pages', 'genesis-widgetized-notfound' ) ) );

						printf( '<option value="single_posts_pages" %s>%s</option>', selected( 'single_posts_pages', $instance[ 'widget_display' ], 0 ), __( 'Both, Single Posts & Pages', 'genesis-widgetized-notfound' ) );
					?>
				</select>
			</label>
		</p>

		<p>
			<input type="checkbox" value="1" <?php checked( '1', $instance[ 'not_in_public' ] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'not_in_public' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'not_in_public' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'not_in_public' ) ); ?>">
				<?php _e( 'Only displaying for logged in users?' , 'genesis-widgetized-notfound' ); ?>
			</label>
		</p>

		<hr <?php echo $gwnf_hr_style; ?> />

		<p>
			<label for="<?php /** Optional outro text */ echo esc_attr( $this->get_field_id( 'outro_text' ) ); ?>"><?php _e( 'Optional outro text:', 'genesis-widgetized-notfound' ); ?>
				<small><?php echo sprintf( __( 'Add some additional %s info. NOTE: Just leave blank to not use at all.', 'genesis-widgetized-notfound' ), __( 'Search', 'genesis-widgetized-notfound' ) ); ?></small>
				<textarea name="<?php echo esc_attr( $this->get_field_name( 'outro_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'outro_text' ) ); ?>" rows="2" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>

		<?php
		/** ^End form code */

	}  // end method

}  // end of class
