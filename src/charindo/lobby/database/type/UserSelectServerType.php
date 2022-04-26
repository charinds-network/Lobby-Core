<?php

declare(strict_types=1);

namespace charindo\lobby\database\type;

class UserSelectServerType{

	/** @var string */
	public $name;
	/** @var string */
	public $server;

	/**
	 * @param string $name
	 * @param string $server
	 */
	public function __construct(string $name, string $server){
		$this->name = $name;
		$this->server = $server;
	}
}