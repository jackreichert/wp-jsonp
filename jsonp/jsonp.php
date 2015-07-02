<?php
/**
* Plugin Name: WordPress JSONp Helper
* Plugin URI: http://www.jackreichert.com/2015/07/02/how-to-jsonp-ajax-to-ssl-in-wordpress-and-easier-way/
* Description: A paradigm for easy AJAX over SSL in WordPress using JSONP.
* Version: 0.1
* Author: jackreichert
* Author URI: http://www.jackreichert.com/
* License: GPL3
*/

class WP_AJAX_JSONp {
    // actions on instatiation
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_jsonp_scripts' ) );
	}

    // enqueue scripts
	function wp_jsonp_scripts() {
		wp_enqueue_script( 'wp_jsonp_script', plugins_url( '/jsonp.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'wp_jsonp_script', 'wp_jsonp_vars', array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'wpAJAXNonce' => wp_create_nonce( 'wpAJAX-nonce' )
		) );
	}
}

$WP_AJAX_JSONp = new WP_AJAX_JSONp();