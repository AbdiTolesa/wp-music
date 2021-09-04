<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/abditsori/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 * @author     Abdi Tolessa <tolesaabdi1@gmail.com>
 */
class Wp_Music_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-music-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-music-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Processes shortcode music
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 *
	 * @return	mixed	$output		Output of the template
	 */
	public function show_music_information( $atts = array() ){

		$defaults['year'] 			= '';
		$defaults['genre'] 		    = '';

		$args = shortcode_atts( $defaults, $atts, 'music' );

		$music_list = $this->get_music_detail($args);

		$this->music_details_template($music_list);

	}


	public function get_music_detail($args){

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_music';

		$year = $args['year'];

		$genre = $args['genre'];

		$sql_query = "SELECT * FROM $table_name";
		
		$year ? $sql_query .= " WHERE year_of_recording = $year" : '';

		$output = $wpdb->get_results($sql_query);
		
		if($genre){
			foreach($output as $key=>$music_row){
				if(!has_term($genre, 'genre', $music_row->post_id)){
					unset($output[$key]);
				}
			}
		}

		return $output;
	}

	public function music_details_template($music_list){
		echo '<div style="max-width:80%; text-align:center;">';
		echo '<h3>'.__('Music list', 'wp-music').'</h3>';
		echo '<table>
				<tr>
					<th>Title</th>
					<th>Composer Name</tdh>
					<th>Publisher</th>
					<th>Year of recording</th>
					<th>Additional contributors</th>
					<th>URL</th>
					<th>Price</th>
					<th>Genres</th>
				</tr>';
		foreach($music_list as $music){
			echo '<tr>';
			echo '<td>'.get_the_title($music->post_id).'</td>';
			echo '<td>'.$music->composer_name.'</td>';
			echo '<td>'.$music->publisher.'</td>';
			echo '<td>'.$music->year_of_recording.'</td>';
			echo '<td>'.$music->additional_contributors.'</td>';
			echo '<td><a href="'.$music->url.'">'.$music->url.'</a></td>';
			echo '<td>'.$music->price.'</td>';
			echo '<td>';
			
			$terms = get_the_terms($music->post_id, 'genre');
			if(is_array($terms)){
				foreach($terms as $term){
					echo '<a href="'.get_term_link($term->term_id).'">'.$term->name.'</a>';
					echo ' ';
				}
			}

			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</div>';
	}

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'music', array( $this, 'show_music_information' ) );

	} // register_shortcodes()
}
