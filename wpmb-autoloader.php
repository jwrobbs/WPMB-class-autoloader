<?php
/**
 * Plugin Name: WPMB autoloader plugin
 * Plugin URI: http://www.wpmasterbuilder.com
 * Description: Autoload your classes
 * Version: 0.0.1
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
 * See the 1st comment for assumptions and details.
 *
 * @param string $class_name The name of the class to load.
 * @return void
 */
function wpmb_autoload( $class_name ) {
	/*
		Rules to follow:
		1. This is for classes in the plugins directory.
		2. You have to use namespaces that follow the plugin's directory pattern.
		3. The file name must match the class name as per WPCS.
		4. If you prepend your namespace with a prefix, you must set it below.
			$my_namespace_prefix

		If you do those 3 things, this will automatically include your class file
		without you having to do anything else. When the class is needed, the
		function will use the namespace to create the file path and then include
		the file.

		Example:
		In my plugin, I have a class named 'My_Widgets'.
		It's in a subdirectory named 'php'.
		For the sake of uniqueness, I prepend my namespace with my initials: 'jwr'.

		That means my file name is: 'class-my-widgets.php'
		The file's namespace is: 'jwr\php\'

	*/

	// Set your prefix or comment out.
	$my_namespace_prefix = 'wpmb\\';
	$class_name          = str_replace( $my_namespace_prefix, '', $class_name );

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
	$directory = __DIR__;
	// !! watch this line.
	// $directory = str_replace( '\\utilities', '', $directory );

	$file = $directory . '/' . $path . $file_name;

	// Update filepath to match your system.
	$file = str_replace( '\\', DIRECTORY_SEPARATOR, $file );
	$file = str_replace( '/', DIRECTORY_SEPARATOR, $file );

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( __NAMESPACE__ . '\wpmb_autoload' );
