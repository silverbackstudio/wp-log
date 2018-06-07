<?php
namespace Svbk\WP\Log;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class DefaultLogger  {

	/**
	* Default logger instancr
	*/
	protected static $logger = null;

	/**
	* Set default logger instance
	*
	* @param LoggerInterface $message
	*
	* @return void
	*/
	public static function setLogger( LoggerInterface $logger ){
		self::$logger = new NullLogger;
	}
	
	/**
	* Get default logger instance
	*
	* @return LoggerInterface
	*/	
	public static function getLogger(){
	
		if ( null === self::$logger ) {
			self::$logger = new NullLogger;
		}
	
		return self::$logger;
	}
	
	/**
	* System is unusable.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function emergency($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::EMERGENCY, $message, $context);
	}
	
	/**
	* Action must be taken immediately.
	*
	* Example: Entire website down, database unavailable, etc. This should
	* trigger the SMS alerts and wake you up.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static static function alert($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::ALERT, $message, $context);
	}
	
	/**
	* Critical conditions.
	*
	* Example: Application component unavailable, unexpected exception.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function critical($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::CRITICAL, $message, $context);
	}
	
	/**
	* Runtime errors that do not require immediate action but should typically
	* be logged and monitored.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function error($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::ERROR, $message, $context);
	}
	
	/**
	* Exceptional occurrences that are not errors.
	*
	* Example: Use of deprecated APIs, poor use of an API, undesirable things
	* that are not necessarily wrong.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function warning($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::WARNING, $message, $context);
	}
	
	/**
	* Normal but significant events.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function notice($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::NOTICE, $message, $context);
	}
	
	/**
	* Interesting events.
	*
	* Example: User logs in, SQL logs.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function info($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::INFO, $message, $context);
	}
	
	/**
	* Detailed debug information.
	*
	* @param string $message
	* @param array  $context
	*
	* @return void
	*/
	public static function debug($message, array $context = array())
	{
		self::getLogger()->log(LogLevel::DEBUG, $message, $context);
	}	

}
