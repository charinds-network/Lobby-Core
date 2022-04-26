<?php

declare(strict_types=1);

namespace charindo\lobby\database;

use charindo\lobby\database\type\UserSelectServerType;

interface Database{

	/**
	 * @param UserSelectServerType $record
	 */
	public function putSelectServer(UserSelectServerType $record);
}