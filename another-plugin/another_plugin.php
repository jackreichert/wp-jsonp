<?php
/**
* Plugin Name: another plugin
* Plugin URI: http://www.jackreichert.com/2015/07/02/how-to-jsonp-ajax-to-ssl-in-wordpress-an-easier-way/
* Description: An example of how you might use wp_jsonp.
* Version: 0.1
* Author: jackreichert
* Author URI: http://www.jackreichert.com/
* License: GPL3
*/

class Another_Plugin {
    // actions on instatiation
	function __construct() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
        if ( is_plugin_active('jsonp/jsonp.php') ) { // plugin is active? Great we can use it! 
            add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ) );
            add_action( 'wp_ajax_wp_jsonp', array( $this, 'wp_jsonp_func' ) );
            add_action( 'wp_ajax_nopriv_wp_jsonp', array( $this, 'wp_jsonp_func' ) );
        }
	}

    // enqueue scripts
	function plugin_scripts() {
		wp_enqueue_script( 'wp_jsonp_call', plugins_url( '/scripts.js', __FILE__ ), array( 'wp_jsonp_script' ) );
	}

    // process the ajax calls
	function wp_jsonp_func() {
		if ( ! wp_verify_nonce( $_GET['ajaxSSLNonce'], 'wpAJAX-nonce' ) ) {
			die ( 'Busted!' );
		}

		$response = array();
		$method   = $_GET['method'];

        /**
        * Send what should be processed here.
        * Note: since you are sending the method via ajax, you MUST validate your data.
        * If you don't you probably should check your SQL queries because you probably don't sanitize those either.
        */
		switch ( $method ) {
			case 'getStuff':
                // if you get "hello world back, then it worked"
				$response = "Hello World";
				break;
            		default:
                		$response = "You didn't send any methods to process your variables?!";
				break;
		}

		// response output
		header( "content-type: text/javascript; charset=utf-8" ); // We're sending back a javascript function, remember?
		header( "access-control-allow-origin: *" ); // This is needed for JSONP.
		echo htmlspecialchars( $_GET['callback'] ) . '(' . json_encode( $response ) . ')'; // jQuery set up the callback for us.

		// IMPORTANT: don't forget to "exit"
		exit;
	}
}

$Another_Plugin = new Another_Plugin();
