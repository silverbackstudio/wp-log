<?php 

namespace Svbk\WP\Log\Hook;

class Post {
 
    public $id = 'post';
 
    public static function setup(){
        add_action( 'wp_insert_post', array( __CLASS__, 'insert_post' ), 100, 3 );
    }

    public static function edit_post( $post_ID, $post ){
        do_action( 'log', 'info', 'User {user_id} Updated post: {post_id}/{post_title}', 
            array( 'post_id' => $post_ID, 'post_title' => $post->post_title, 'source' => 'wordpress.post' ) 
        );
    }
    
    public static function insert_post( $post_ID, $post, $update ){
        
        $context = array( 
            'post_id' => $post_ID, 
            'post_title' => $post->post_title, 
            'post_type' => $post->post_type, 
            'source' => 'wordpress.post' 
        );
    
        if( wp_is_post_autosave( $post ) ) {
            do_action( 'log', 'debug', 'User {user_login} autosave for post: {post_id}/{post_title}', $context );
            return;
        }
    
        if ( wp_is_post_revision( $post ) ) {
            do_action( 'log', 'info', 'User {user_login} created revision for post: {post_id}/{post_title}', $context );
        } elseif ( $update ) {
            do_action( 'log', 'info', 'User {user_login} updated post: {post_id}/{post_title}', $context );
        } else {
            do_action( 'log', 'info', 'User {user_login} created post: {post_id}/{post_title}', $context );            
        }
        
    }    

} 

?>