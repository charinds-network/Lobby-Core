<?php

declare(strict_types=1);

namespace charindo\lobby\database;

use charindo\lobby\database\type\UserSelectServerType;

class MySQL implements Database {

	/** @var Database */
	private static $instance;

	/** @var \mysqli */
	private $connection;

	/**
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 * @return bool
	 */
	public function initDatabase(string $host, string $username, string $password, string $dbname) : bool {
		$this->connection = new \mysqli($host, $username, $password, $dbname);
		if($this->connection->connect_error){
			return false;
		}
		self::$instance = $this;
		return true;
	}

	public static function getInstance() : Database {
		return self::$instance;
	}

	public function getConnection() : \mysqli {
		return $this->connection;
	}

	public function putSelectServerData(UserSelectServerType $record) {
		$stmt = $this->connection->prepare("INSERT INTO `proxy_waiting_list` (`name`, `server`) VALUES (?, ?)");
		$stmt->bind_param("ss", $record->name, $record->server);
		$stmt->execute();
	}

	public function deleteSelectServerData(string $name) {
		$stmt = $this->connection->prepare("DELETE FROM `proxy_waiting_list` WHERE `name` = ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();
	}
}