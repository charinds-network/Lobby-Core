<?php

declare(strict_types=1);

namespace charindo\lobby;

use charindo\lobby\database\Database;
use charindo\lobby\database\type\UserSelectServerType;
use charindo\lobby\item\ServerSelectClock;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener {

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
		$player->moveEventRestrictionTime = microtime(true);
		$player->queuedServer = "";
		$player->beforePosition = $player->getPosition();

		$player->getInventory()->clearAll();
		$player->getInventory()->setItem(4, ServerSelectClock::getItem());
	}

	public function onQuit(PlayerQuitEvent $event) : void {
		$event->setQuitMessage("");
		$player = $event->getPlayer();
		$name = $player->getName();
		$this->database->deleteSelectServerData($name);
	}

	public function onMove(PlayerMoveEvent $event) : void{
		$player = $event->getPlayer();
		if(isset($player->moveEventRestrictionTime) && $player->moveEventRestrictionTime <= microtime(true)){
			$player->moveEventRestrictionTime = microtime(true) + 0.1;
			$player = $event->getPlayer();
			if(isset($player->beforePosition) && isset($player->queuedServer) && !empty($player->queuedServer)){
				if($player->getPosition()->getFloorX() !== $player->beforePosition->getFloorX() || $player->getPosition()->getFloorZ() !== $player->beforePosition->getFloorZ()){
					$this->database->putSelectServerData(new UserSelectServerType($player->getName(), $player->queuedServer));
				}
			}
		}
	}
}