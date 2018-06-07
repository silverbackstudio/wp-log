<?php
namespace Svbk\WP\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class Email extends AbstractLogger {

	public $defaultSubject = 'WP Logger Message';
	public $address = '';

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed  $level
	 * @param string $message
	 * @param array  $context
	 * @return null
	 */
	public function log( $level, $message, array $context = array() ) {

		$subject = "[{$level}] ";
		$subject .= empty( $context['subject'] ) ? $this->defaultSubject : $context['subject'];

		wp_mail( $this->address ?: get_bloginfo('admin_email'), $subject, $message );
	}

}
