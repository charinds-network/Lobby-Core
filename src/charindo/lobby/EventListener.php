<?php

declare(strict_types=1);

namespace charindo\lobby;

use charindo\lobby\database\Database;
use charindo\lobby\item\ServerSelectClock;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

class EventListener implements Listener{

	/** @var Database */
	private $database;

	public function __construct(Database $database) {
		$this->database = $database;
	}

	public function onJoin(PlayerJoinEvent $event) : void {
		$event->setJoinMessage("");
		$player = $event->getPlayer();
		$name = $player->getName();
		$player->clickRestrictionTime = microtime(true);

		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(4, ServerSelectClock::getItem());
	}

	public function onQuit(PlayerQuitEvent $event) : void{
		$event->setQuitMessage("");
		$player = $event->getPlayer();
		$name = $player->getName();
		$this->database->deleteSelectServerData($name);
	}
}