<?php

/**
 * Cookie Disclaimer
 */

 /**
	Plugin name: Cookie Disclaimer
	Plugin URI: https://github.com/nemasmisal/cookie-disclaimer
	Description: Simple cookie notice plugin for Wordpress
	Version: 1.0
	Author: Nikolay
  */

if (!defined('ABSPATH')) {
	exit;
}

class CookieDisclaimer {
	
	function __construct() {
		@require_once 'settings.php';

		function addToFooter() {
			$cookie_disclaimer_settings_options = get_option( 'cookie_disclaimer_settings_option_name' );
			$cookie_statemant = $cookie_disclaimer_settings_options['cookie_statement'];
			$site_ownership = $cookie_disclaimer_settings_options['site_ownership'];
			$accept_button = $cookie_disclaimer_settings_options['accept_button'];
			$link_to_policy = $cookie_disclaimer_settings_options['link_to_policy'];
			echo '<div class="cookie-disclaimer"><button class="cookie-disclaimer-close-btn" id="cookie-disclaimer-close-btn">X</button><p>'.$cookie_statemant.'</p><p>'.$site_ownership.'<a href="'.$link_to_policy.'" target="_blank"> Privacy Policy</a></p><button class="cookie-disclaimer-accept-btn" id="cookie-disclaimer-accept-btn">'.$accept_button.'</button></div>';
		}
		add_action('wp_footer', 'addToFooter', 100);

		function cookie_disclaimer_script_load(){
			wp_enqueue_script( 'cookie-disclaimer-script', plugin_dir_url( __FILE__ ) . 'cookies.js', [], null, true );
		} 
		add_action('wp_enqueue_scripts', 'cookie_disclaimer_script_load', 100);

		function cookie_disclaimer_css_load(){
			wp_enqueue_style( 'cookie-disclaimer', plugin_dir_url( __FILE__ ) . 'style.css' );
		}
		add_action('wp_enqueue_scripts', 'cookie_disclaimer_css_load');
	}
	function activate() {
	}

	function deactivate() {
	}

	function uninstall() {
	}
}

// initialize plugin
if (class_exists('CookieDisclaimer')) {
	$cookieDisclaimer = new CookieDisclaimer();
}

register_activation_hook( __FILE__, array( $cookieDisclaimer , 'activate' ) );

register_deactivation_hook( __FILE__, array( $cookieDisclaimer , 'deactivate' ) );