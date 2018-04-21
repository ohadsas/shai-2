<?php
/**
 * Created by PhpStorm.
 * User: majal
 * Date: 10/23/17
 * Time: 13:22
 */

require_once "vendor/autoload.php";
date_default_timezone_set('utc');

Appthis\Helper\Config::setGlobalConfig(__DIR__ . '/config/default.conf.yml');