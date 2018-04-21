<?php

namespace Appthis\Model;

class Country extends AbstractModel {
	protected static $id = 'iso';
	protected static $table = 'country';

	const COLUMN_ISO = 'iso';
	const COLUMN_NAME = 'name';

	protected static $column_map = [
		self::COLUMN_ISO => \PDO::PARAM_STR,
		self::COLUMN_NAME => \PDO::PARAM_STR,
	];
}