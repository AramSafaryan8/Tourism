<?php
declare(strict_types = 1);

namespace Models;

use AppData\Config;

interface IRetriever
{
	static function get_by(array $params) : array;
	function get_keys() : array;
	function retrieve(array $resp) : array;
}