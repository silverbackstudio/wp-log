<?php 

namespace Svbk\WP\Log;

class Core {
  
    public static function all() {
        self::boot();
        self::user();
    }

    public static function boot(){
        if( !defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
            do_action( 'log', 'debug', 'Wordpress Startup for request', array( 'request_uri' => $_SERVER['REQUEST_URI']) );
        }
        
        if( is_user_logged_in() ) { 
            $user = wp_get_current_user();
            do_action( 'log', 'debug', 'User logged in as {user_login}', array( 'user_id' => $user->ID, 'user_login' => $user->user_login  ) );
        }
        
    }

    public static function user(){
        add_filter( 'authenticate', array( __CLASS__, 'user_authenticate' ), 100, 2 );
        add_action( 'wp_login_failed', array( __CLASS__, 'user_login_failed' ) );
        add_action( 'user_register', array( __CLASS__, 'user_created' ) );
        add_action( 'profile_update', array( __CLASS__, 'user_updated' ) );
        add_action( 'deleted_user', array( __CLASS__, 'user_deleted' ) );
    }

    public static function user_authenticate( $result, $username ){
        do_action( 'log', 'info', 'Login attempt for user: {username}', array( 'username' => $username ) );
        return $result;
    }
  
    public static function user_login_failed( $username ){
        do_action( 'log', 'warning', 'Login failed for user: {username}',  array( 'username' => $username ) );
    }
    
    public static function user_created( $user_id ){
        do_action( 'log', 'info', 'Created user ID: {user_id}', array( 'user_id' => $user_id ) );
    }    
  
    public static function user_updated( $user_id ){
        do_action( 'log', 'info', 'Updated user ID: {user_id}', array( 'user_id' => $user_id ) );
    }   
    
    public static function user_deleted( $user_id ){
        do_action( 'log', 'info', 'Deleted user ID: {user_id}', array( 'user_id' => $user_id ) );
    }

} 

?>