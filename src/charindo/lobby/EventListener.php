<?php

declare(strict_types=1);

namespace charindo\lobby;

use charindo\lobby\database\Database;
use charindo\lobby\form\SelectServerForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener{

	/** @var Database */
	private $database;

	public function __construct(Database $database){
		$this->database = $database;
	}

	public function onJoin(PlayerJoinEvent $event) : void{
		$event->setJoinMessage("");
		$player = $event->getPlayer();
		$name = $player->getName();
		$player->sendForm(new SelectServerForm());
	}

	public function onQuit(PlayerQuitEvent $event) : void{
		$event->setQuitMessage("");
		$player = $event->getPlayer();
		$name = $player->getName();
	}
}