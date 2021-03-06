<?php

/**
 * Provide the view for a metabox
 *
 * @since 		1.0.0
 *
 * @package 	WP_Music
 * @subpackage 	WP_Music/admin/partials
 */

//wp_nonce_field( $this->plugin_name, 'job_additional_info' );

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'price';
$atts['label'] 			= '';
$atts['name'] 			= 'price';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'number';
$atts['step']           = 'any';
$atts['value'] 			= '';

	
global $wpdb;

$custom_table = $wpdb->prefix . 'wp_music';
	
$post_id = get_the_ID();

$meta_value = $wpdb->get_var("SELECT price FROM  $custom_table where post_id = $post_id");

$atts['value'] = $meta_value;

//apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php' );

?></p>