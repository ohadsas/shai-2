<?php

namespace Appthis\Model;

class Publisher extends AbstractModel {
	protected static $table = 'publisher';

	const COLUMN_ID = 'id';
	const COLUMN_NAME = 'name';

	protected static $column_map = [
		self::COLUMN_ID => \PDO::PARAM_INT,
		self::COLUMN_NAME => \PDO::PARAM_STR,
	];


}