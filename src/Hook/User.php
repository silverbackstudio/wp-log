<?php

namespace Svbk\WP\Log\Hook;

class User {

	public $id = 'user';

	public static function setup() {
		add_filter( 'authenticate', array( __CLASS__, 'user_authenticate' ), 100, 2 );
		add_action( 'wp_login_failed', array( __CLASS__, 'user_login_failed' ) );
		add_action( 'user_register', array( __CLASS__, 'user_created' ) );
		add_action( 'profile_update', array( __CLASS__, 'user_updated' ) );
		add_action( 'deleted_user', array( __CLASS__, 'user_deleted' ) );
	}

	public static function user_authenticate( $result, $username ) {
		do_action(
			'log', 'info', 'Login attempt for user: {username}', array(
				'username' => $username,
				'source' => 'wordpress.user',
				'sensitive' => true,
			)
		);
		return $result;
	}

	public static function user_login_failed( $username ) {
		do_action(
			'log', 'warning', 'Login failed for user: {username}',  array(
				'username' => $username,
				'source' => 'wordpress.user',
			)
		);
	}

	public static function user_created( $user_id ) {
		do_action(
			'log', 'info', 'Created user ID: {user_id}', array(
				'user_id' => $user_id,
				'source' => 'wordpress.user',
			)
		);
	}

	public static function user_updated( $user_id ) {
		do_action(
			'log', 'info', 'Updated user ID: {user_id}', array(
				'user_id' => $user_id,
				'source' => 'wordpress.user',
			)
		);
	}

	public static function user_deleted( $user_id ) {
		do_action(
			'log', 'info', 'Deleted user ID: {user_id}', array(
				'user_id' => $user_id,
				'source' => 'wordpress.user',
			)
		);
	}

}


