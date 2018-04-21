<?php

namespace Appthis\Helper;


class Logger {
	public static function formatError(\Exception $e) {
		return [
			'type'    => get_class($e),
			'code'    => $e->getCode(),
			'message' => $e->getMessage(),
			'file'    => $e->getFile(),
			'line'    => $e->getLine()
		];
	}
}