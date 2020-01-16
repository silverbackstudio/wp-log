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

use Svbk\WP\Log as WP_Log;


function svbk_logger_init() {

	load_plugin_textdomain( 'svbk-wp-log', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if ( ! defined( 'WP_LOGGER_NAME' ) ) {
		define( 'WP_LOGGER_NAME', 'wordpress' );
	}

	if ( Monolog\Registry::hasLogger( WP_LOGGER_NAME ) ) {
		$wp_logger = Monolog\Registry::getInstance( WP_LOGGER_NAME );
	} else {
		$wp_logger = new Monolog\Logger( WP_LOGGER_NAME );
		Monolog\Registry::addLogger( $wp_logger, WP_LOGGER_NAME );
	}

	$wp_logger->pushProcessor( new WP_Log\Processor\PlaceholderProcessor() );
	$wp_logger->pushProcessor(
		new Monolog\Processor\WebProcessor(
			null,
			array(
				'url' => 'REQUEST_URI',
				'ip'          => 'REMOTE_ADDR',
				'http_method' => 'REQUEST_METHOD',
			)
		)
	);

	$wp_logger->pushProcessor( new Monolog\Processor\MemoryUsageProcessor() );
	$wp_logger->pushProcessor( new WP_Log\Processor\WordpressProcessor() );

	add_action( 'log', array( $wp_logger, 'log' ), 10, 3 );

	do_action( 'svbk_logger_init', $wp_logger );

	return $wp_logger;
}

add_action( 'plugins_loaded', 'svbk_logger_init', 5 );

function svbk_logger_register_hooks() {

	$channels = apply_filters(
		'svbk_log_classes',
		array(
			'core' => WP_Log\Hook\Core::class,
			'user' => WP_Log\Hook\User::class,
			'post' => WP_Log\Hook\Post::class,
			'http' => WP_Log\Hook\Http::class,
		)
	);

	foreach ( $channels as $channel => $className ) {
		if ( false === $className ) {
			continue;
		}

		$className::setup();
	}

}

add_action( 'init', 'svbk_logger_register_hooks', 5 );
