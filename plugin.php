<?php

/**
 * @package Silverback Log Services
 * @version 1.1
 */

/**
Plugin Name: Silverback Log Services
Plugin URI: https://github.com/silverbackstudio/wp-log
Description: SilverbackStudio Log
Author: Silverback Studio
Version: 1.1
Author URI: http://www.silverbackstudio.it/
Text Domain: svbk-log-services
 */


function svbk_log_services_init() {
	load_plugin_textdomain( 'svbk-log', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'svbk_log_services_init' );
