<?php

declare(strict_types=1);

namespace charindo\lobby\form;

use charindo\lobby\database\Database;
use charindo\lobby\database\type\UserSelectServerType;
use pocketmine\form\Form;
use pocketmine\player\Player;

class SelectServerForm implements Form{

	/** @var Database */
	private $database;

	public function __construct(Database $database){
		$this->database = $database;
	}

	public function handleResponse(Player $player, $data) : void{
		if($data === null){
			return;
		}

		$servers = ['main', 'pt'];
		$this->database->putSelectServer(new UserSelectServerType($player->getName(), $servers[$data]));
	}

	public function jsonSerialize(){
		$servers = [""];
		return [
			'type' => 'form',
			'title' => 'サーバー選択 - SelectServer',
			'content' => '',
			'buttons' => [
				[
					'text' => 'Main server'
				],
				[
					'text' => 'Test server'
				]
			]
		];
	}
}