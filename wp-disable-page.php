<?php
/**
 * 
 * Plugin Name: WP Disable Page
 * Plugin URI: https://github.com/tjsteinhaus/wp-disable-page
 * Description: Instead of deleting the page, you can disable it and redirect it elsewhere.
 * Author: Tyler Steinhaus
 * Version: 1.0
 * Author URI: https://tylersteinhaus.com
*/

namespace WPDisablePage;

define( 'WPDisablePage_DIR', plugin_dir_path( __FILE__ ) );

// use Composer autoload
require __DIR__ . '/vendor/autoload.php';

add_action( 'init', function() {
	// Start the engines
	$GLOBALS[\WPDisablePage\Setup::PLUGIN_ID] = new \WPDisablePage\Setup();
	$GLOBALS[\WPDisablePage\Setup::PLUGIN_ID]->init();
}, 0 );