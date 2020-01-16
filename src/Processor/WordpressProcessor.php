<?php

/*
 * Add useful informations to a Wordpress Log.
 *
 * (c) Brando Meniconi <b.meniconi@silverbackstudio.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svbk\WP\Log\Processor;

/**
 * Adds a unique identifier into records
 *
 * @author Brando Meniconi <b.meniconi@silverbackstudio.it>
 */
class WordpressProcessor {


	public function __invoke( array $record ) {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$record['context']['wp_request_type'] = 'ajax';
		} else if ( is_admin() ) {
			$record['context']['wp_request_type'] = 'admin';
		} else {
			$record['context']['wp_request_type'] = 'frontend';
		}

		$record['context']['siteurl'] = get_site_url();
		$record['context']['site_id'] = get_current_blog_id();
		$record['context']['host'] = $_SERVER['HTTP_HOST'];

		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$record['context']['user_id'] = $user->ID;
			$record['context']['user_login'] = $user->user_login;
		}

		return $record;
	}

}
