<?php

declare(strict_types=1);

namespace charindo\lobby\database;

use charindo\lobby\database\type\UserSelectServerType;

interface Database {

	/**
	 * @return Database
	 */
	public static function getInstance() : Database;

	/**
	 * @return \mysqli
	 */
	public function getConnection() : \mysqli;

	/**
	 * @param UserSelectServerType $record
	 */
	public function putSelectServerData(UserSelectServerType $record);

	/**
	 * @param string $name
	 */
	public function deleteSelectServerData(string $name);
}