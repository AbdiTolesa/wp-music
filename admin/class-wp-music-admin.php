<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/abditsori/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 * @author     Abdi Tolessa <tolesaabdi1@gmail.com>
 */
class Wp_Music_Admin {

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->set_options();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-music-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Music_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Music_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-music-admin.js', array( 'jquery' ), $this->version, false );

	}

	
	/**
	 * Creates a new custom post type, music
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public function create_cpt_music() {

		$args = array( 
			'labels'      => array( 
				'name'          => __( 'Music', 'wp-music' ),
				'singular_name' => __( 'Music', 'wp-music' ),
				),
			'public'             => true,
			'publicly_queryable' => true,
			'has_archive'        => true,
			);

		 register_post_type('music', $args);

	}

	public function create_taxonomy_genre(){

		$labels = array(
			'name'              => __( 'Genres', 'wp-music' ),
			'singular_name'     => __( 'Genre', 'wp-music' ),
			'search_items'      => __( 'Search Genres', 'wp-music' ),
			'all_items'         => __( 'All Genres', 'wp-music' ),
			'parent_item'       => __( 'Parent Genre', 'wp-music' ),
			'parent_item_colon' => __( 'Parent Genre:', 'wp-music' ),
			'edit_item'         => __( 'Edit Genre', 'wp-music' ),
			'update_item'       => __( 'Update Genre', 'wp-music' ),
			'add_new_item'      => __( 'Add New Genre', 'wp-music' ),
			'new_item_name'     => __( 'New Genre Name', 'wp-music' ),
		);
	 
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
		);

		register_taxonomy('genre', 'music', $args);
	}

	public function create_taxonomy_music_tag(){
		$labels = array(
			'name'                       => __( 'Music Tags', 'wp-music' ),
			'singular_name'              => __( 'Music Tag', 'wp-music' ),
			'search_items'               => __( 'Search Music Tags', 'wp-music' ),
			'popular_items'              => __( 'Popular Music Tags', 'wp-music' ),
			'all_items'                  => __( 'All Music Tags', 'wp-music' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit music tag', 'wp-music' ),
			'update_item'                => __( 'Update music tag', 'wp-music' ),
			'add_new_item'               => __( 'Add New music tag', 'wp-music' ),
			'new_item_name'              => __( 'New music tag Name', 'wp-music' ),
			'separate_items_with_commas' => __( 'Separate music tags with commas', 'wp-music' ),
			'add_or_remove_items'        => __( 'Add or remove music tags', 'wp-music' ),
			'choose_from_most_used'      => __( 'Choose from the most used music tags', 'wp-music' ),
			'not_found'                  => __( 'No music tags found.', 'wp-music' ),
			'menu_name'                  => __( 'Music Tags', 'wp-music' ),
		);
	 
		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'music-tag' ),
		);
	 
		register_taxonomy( 'music-tag', 'music', $args );

	}

	public function add_settings_menu(){
		add_submenu_page(
			'edit.php?post_type=music',
			__( 'Settings', 'wp-music' ),
			__( 'Settings', 'wp-music' ),
			'manage_options',
			'music_settings',
			array($this, 'settings_callback')
		);
	}

	public function settings_callback(){
		include( plugin_dir_path( __FILE__ ) . 'partials/wp-music-admin-page-settings.php' );
	}

	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		add_settings_field(
			'setting-currency',
			__('Currency', 'wp-music'),
			array( $this, 'field_select' ),
			$this->plugin_name,
			$this->plugin_name . '-section',
			array(
				'description' 	=> 'Change currency',
				'id' 			=> 'currency',
				'value' 		=> 'USD',
				'class'         => 'setting-field',
				'selections'    => array('USD', 'GBP', 'Euro'),
			)
		);

		add_settings_field(
			'setting-music-per-page',
			__('Music per page', 'wp-music'),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-section',
			array(
				'description' 	=> 'Number of musics displayed per page',
				'id' 			=> 'music-per-page',
				'value' 		=> '',
				'type'          => 'number',
				'class'         => 'setting-field',
			)
		);


	}

	
	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-section',
			__( '', 'wp-music' ),
			array( $this, 'section_messages' ),
			$this->plugin_name
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }

		$return 	= '';
		$sanitizer 	= new WP_Music_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	} // sanitizer()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );

	} // field_text()

	
	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= 'widefat';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-select.php' );

	} // field_select()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		$options[] = array( 'currency', 'text', '' );
		$options[] = array( 'music-per-page', 'text', '' );
		$options[] = array( 'repeat-test', 'repeater', array( array( 'test1', 'text' ), array( 'test2', 'text' ), array( 'test3', 'text' ) ) );

		return $options;

	} // get_options_list()


	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function section_messages( $params ) {

		echo '';
	} // section_messages()


	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()


	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		//wp_die( print_r( $input ) );

		$valid 		= array();
		$options 	= $this->get_options_list();

		foreach ( $options as $option ) {

			$name = $option[0];
			$type = $option[1];

			if ( 'repeater' === $type && is_array( $option[2] ) ) {

				$clean = array();

				foreach ( $option[2] as $field ) {

					foreach ( $input[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count = now_hiring_get_max( $clean );

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$valid[$option[0]][$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			} else {

				$valid[$option[0]] = $this->sanitizer( $type, $input[$name] );

			}

		}

		return $valid;

	} // validate_options()

}
