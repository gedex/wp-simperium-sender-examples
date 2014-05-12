<?php
/**
 * Plugin Name: Simperium Sender Examples
 * Plugin URI: https://github.com/x-team/wp-simperium-sender-examples
 * Description: This plugin contains sender examples for Simperium plugin
 * Version: 0.1.0
 * Author: Akeda Bagus
 * Author URI: http://gedex.web.id
 * Text Domain: simperium
 * Domain Path: /languages
 * License: GPL v2 or later
 * Requires at least: 3.6
 * Tested up to: 3.9
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

add_action( 'plugins_loaded', function() {

	/**
	 * Get classname from given a file path.
	 *
	 * @param string $file File path
	 *
	 * @return string Class name according to convention
	 */
	$get_class_name = function( $file ) {
		return 'Simperium_Sender_' . str_replace(
			' ',
			'_',
			ucwords(
				str_replace(
					'-',
					' ',
					basename( $file, '.php' )
				)
			)
		);
	};

	// Base class for sender.
	require_once dirname( __FILE__ ) . '/class-simperium-sender.php';

	// Loads all sender classes.
	foreach ( glob( dirname( __FILE__ ) . '/sender/*.php' ) as $sender ) {
		require_once $sender;

		// Sender can throws Exception, so I'm trying to be nice here
		// for the sake of plugin-as-examples.
		try {
			$sender_class = $get_class_name( $sender );
			$sender       = new $sender_class( __FILE__ );
			$sender->listen_to_actions();
		} catch ( Exception $e ) {
			// Just do error_log for now
			error_log( $e->getMessage() );
		}
	}

} );
