<?php
/**
 * Plugin Name: WPMB autoloader plugin
 * Plugin URI: http://www.wpmasterbuilder.com
 * Description: Autoload your classes
 * Version: 0.5.0
 * Author: Josh Robbs
 * Author URI: http://www.wpmasterbuilder.com
 * License: GPL2
 *
 * @package wpmb
 */

namespace wpmb_autoloader;

defined( 'ABSPATH' ) || exit;

/**
 * Autoload classes
 *
 * This will automatically and conditionally load your classes.
 * See the README for assumptions and details.
 *
 * @param string $class_name The name of the class to load.
 * @return void
 */
function wpmb_autoload( $class_name ) {
	// Convert to lowercase and replace underscores with dashes.
	$class_name = str_replace( '_', '-', $class_name );
	$class_name = strtolower( $class_name );

	// Split the file path from the class name.
	$pattern = '/^(.*\\\)([\w-]*)$/';
	$match   = preg_match( $pattern, $class_name, $matches );
	if ( 1 !== $match ) {
		return;
	}

	$path = $matches[1];
	$name = $matches[2];

	$file_name = 'class-' . $name . '.php';
	$directory = WP_PLUGIN_DIR;
	$file      = $directory . '\\' . $path . $file_name;

	// Update filepath to match your system.
	$file = str_replace( '\\', DIRECTORY_SEPARATOR, $file );
	$file = str_replace( '/', DIRECTORY_SEPARATOR, $file );

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( __NAMESPACE__ . '\wpmb_autoload' );
