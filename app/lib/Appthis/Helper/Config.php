<?php



namespace Appthis\Helper;

use Appthis\Exception;
use Symfony\Component\Yaml\Yaml;
use Doctrine\DBAL\DriverManager;
use Monolog\Logger;
use Twig\Template;

class Config {

	/* @var $dbConn \Doctrine\DBAL\Connection */
	private static $dbConn;
	/* @var Logger */
	private static $logger;
	private static $appConfig;
	/* @var Template */
	private static $twig;

	public static $logLevels = [
		'debug' => Logger::DEBUG,
		'warn' => Logger::WARNING,
		'error' => Logger::ERROR,
		'info' => Logger::INFO,
		'default' => Logger::INFO
	];

	private function __construct() { }

	public static function setGlobalConfig($path) {
		$conf = Yaml::parse(file_get_contents($path));
		$pathConf = $conf['paths'];

		// Configure Db connection
		$dbConf = $conf['db'];
		static::$dbConn =  DriverManager::getConnection($dbConf);

		// Configuration log
		$logPath = $pathConf['log'] . '/' . date('Ymd') . '.log';
		$logConf = $conf['log'];
		$logLevel = array_key_exists($logConf['level'], static::$logLevels) ? static::$logLevels[$logConf['level']] : static::$logLevels['default'];
		static::$logger = new Logger($logConf['name'], [new \Monolog\Handler\StreamHandler($logPath, $logLevel)]);

		// Configure template engine
		$loader = new \Twig_Loader_Filesystem($pathConf['templates']);
		static::$twig = new \Twig_Environment($loader);

		// Configure app environment
		static::$appConfig = $conf['app'];
	}

	/**
	 * @return \Doctrine\DBAL\Connection
	 * @throws Exception\ConfigException
	 */
	public static function getDbConnection() {
		if (static::$dbConn == null) {
			throw new Exception\ConfigException('Missing DB configuration');
		} else {
			return static::$dbConn;
		}
	}


	/**
	 * @return array
	 * @throws Exception\ConfigException
	 */
	public static function getAppConfig() {
		if (static::$appConfig == null) {
			throw new Exception\ConfigException('Missing app configuration');
		} else {
			return static::$appConfig;
		}
	}

	/**
	 * @return Logger
	 * @throws Exception\ConfigException
	 */
	public static function getLogger() {
		if (static::$logger == null) {
			throw new Exception\ConfigException('Missing log configuration');
		} else {
			return static::$logger;
		}
	}

	/**
	 * @return Template
	 * @throws Exception\ConfigException
	 */
	public static function getViewEngine() {
		if (static::$twig == null) {
			throw new Exception\ConfigException('Missing templates configuration');
		} else {
			return static::$twig;
		}
	}
}