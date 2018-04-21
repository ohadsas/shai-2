<?php

namespace Appthis\Model;
use Appthis\Exception\StorageException;
use Appthis\Helper\Config;
use Appthis\Helper\Logger;
use Doctrine\DBAL\Query\QueryBuilder;

class AbstractModel {
	private $conn;
	protected $logger;
	protected static $table;
	protected static $column_map;
	protected static $columnMap;

	public function __construct() {
		$this->conn = Config::getDbConnection();
		$this->logger = Config::getLogger();
	}

	public static function getTable() {
		return static::$table;
	}

	/**
	 * Creates a dbal query builder
	 * @return \Doctrine\DBAL\Query\QueryBuilder
	 * @throws StorageException
	 */
	protected function getQueryBuilder() {
		return $this->conn->createQueryBuilder();
	}

	/**
	 * Executes a query and logs error
	 * @param QueryBuilder $qb
	 * @return array
	 * @throws StorageException
	 */
	protected function execute(QueryBuilder $qb) {
		try {
			return $qb->execute()->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\Exception $e) {
			$this->logger->error(json_encode(Logger::formatError($e)));
			throw new StorageException('Error in query execution');
		}
	}

	/**
	 * Simple select query to fetch all table entries
	 * @return array
	 */
	public function getAll() {
		$qb = $this->getQueryBuilder();
		$qb->select('*')->from(static::$table);
		return $this->execute($qb);
	}
}