<?php


namespace Appthis\Model;

class Platform extends AbstractModel {
	protected static $table = 'platform';

	const COLUMN_ID = 'id';
	const COLUMN_NAME = 'name';

	protected static $column_map = [
		self::COLUMN_ID => \PDO::PARAM_INT,
		self::COLUMN_NAME => \PDO::PARAM_STR,
	];
}