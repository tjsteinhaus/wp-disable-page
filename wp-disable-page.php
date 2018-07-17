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

/**
  * Create our Autoload so we don't have to include files.
  */
spl_autoload_register( function( $class ) {
    $class = ltrim( $class, '\\' );

    if( strpos( $class, __NAMESPACE__ ) !== 0 ) return;

    $class = str_replace( __NAMESPACE__, '', $class );

    $path = __DIR__ . '/src' . str_replace( '\\', DIRECTORY_SEPARATOR, $class ) . '.php';

    require_once( $path );
} );

add_action( 'init', function() {
	// Start the engines
	$GLOBALS[\WPDisablePage\Setup::PLUGIN_ID] = new \WPDisablePage\Setup();
	$GLOBALS[\WPDisablePage\Setup::PLUGIN_ID]->init();
}, 0 );