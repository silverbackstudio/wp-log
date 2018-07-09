<?php 

namespace Svbk\WP\Log\Hook;

class Core {
  
    public $id = 'core';
  
    public static $events = array(
        'request' => true,
        'cron' => true,
        'shutdown' => true,
    );
  
    public static function setup() {
        
        self::cron();
        
        add_action('shutdown', array( __CLASS__, 'shutdown' ) );
    }

    public static function request(){
        do_action( 'log', 'debug', 'Wordpress {wp_request_type} request: {url}', array( 'source' => 'wordpress.core' ) );
    }
    
    public static function cron(){
        
        if( defined( 'DOING_CRON' ) && DOING_CRON ) {
            do_action( 'log', 'info', 'Cron Job Started', array( 'source' => 'wordpress.cron' ) );
        }           
        
    }
    
    public static function shutdown(){
        do_action( 'log', 'debug', '{wp_request_type} request for page {url} completed. Memory usage of: {memory_usage}', array( 'source' => 'wordpress.core') );
    }    

} 

?>