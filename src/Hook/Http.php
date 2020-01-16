<?php

namespace Svbk\WP\Log\Hook;

class Http {

	public $id = 'http';

	public static function setup() {
		add_action( 'http_api_debug', array( __CLASS__, 'request' ), 9, 5 );
	}

	public static function request( $response, $request_context, $class, $parsed_args, $url ) {

		$context = array(
			'source' => 'wordpress.http',

			'request_url' => $url,
			'request_method' => $parsed_args['method'],
			'request_args' => $parsed_args,
			'request_context' => $request_context,
			'request_class' => $class,
		);

		$log_type = 'debug';

		if ( is_wp_error( $response ) ) {
			$log_type = 'warning';
			$context['response_type'] = 'FAILURE';
			$context['response_message'] = $response->get_error_message();
		} else {
			$context['response_type'] = 'SUCCESS';
			$context['response_body'] = $response['body'];
			$context['response_code'] = $response['response']['code'];
			$context['response_message'] = $response['response']['message'];
		}

		do_action( 'log', 'debug', 'HTTP {request_method} Request for url {request_url}: {response_type}', $context );
	}

}


