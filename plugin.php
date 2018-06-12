<?php

/**
 * @package Silverback Log Services
 * @version 1.1
 */

/**
Plugin Name: Wordpress Log
Plugin URI: https://github.com/silverbackstudio/wp-log
Description: Setup Wordpress log actions and record core events
Author: Silverback Studio
Version: 1.1
Author URI: http://www.silverbackstudio.it/
Text Domain: svbk-wp-log
*/

function svbk_log_init() {
	
	load_plugin_textdomain( 'svbk-wp-log', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	
	if( !defined('WP_LOGGER_NAME') ) {
	    define( 'WP_LOGGER_NAME', 'wordpress' );
	}
	
	if( \Monolog\Registry::hasLogger( WP_LOGGER_NAME ) ) {
	   $wp_logger = \Monolog\Registry::getInstance( WP_LOGGER_NAME );
	} else {
	   $wp_logger = new \Monolog\Logger( WP_LOGGER_NAME );
		\Monolog\Registry::addLogger( $wp_logger, WP_LOGGER_NAME );
	}
	
    add_action( 'log', array( $wp_logger, 'log' ), 10, 3 );
    
    do_action( 'log_init', $wp_logger );
}

add_action( 'plugins_loaded', 'svbk_log_init', 5 );

add_action( 'init', array( Svbk\WP\Log\Core::class, 'all' ), 5 );