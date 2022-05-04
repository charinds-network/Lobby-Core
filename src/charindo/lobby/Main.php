<?php

declare(strict_types=1);

namespace charindo\lobby;

use _PHPStan_c0c409264\Nette\InvalidStateException;
use charindo\lobby\database\Database;
use charindo\lobby\database\MySQL;
use charindo\lobby\item\ServerSelectClock;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

	/** @var Database */
	private $database;
	/** @var EventListener */
	private $eventListener;

	public function initItems() {
		$factory = ItemFactory::getInstance();
		$factory->register(new ServerSelectClock(new ItemIdentifier(ItemIds::CLOCK, 0), "Server Select Clock"), true);
	}

	public function onEnable() : void {
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
			"mysql" => [
				"host" => "host",
				"username" => "username",
				"password" => "password",
				"dbname" => "dbname",
			]
		));

		$dbConfig = $config->get("mysql");
		if($dbConfig["host"] === "host"){
			throw new InvalidStateException("データベースのログイン情報が未設定です。config.ymlを確認してください。");
		}
		$this->database = new MySQL();
		if(!$this->database->initDatabase($dbConfig["host"], $dbConfig["username"], $dbConfig["password"], $dbConfig["dbname"])){
			throw new InvalidStateException("データベース接続中にエラーが発生しました。");
		}else{
			$this->getLogger()->info("§aデータベースに接続しました");
		}

		$this->initItems();

		$this->eventListener = new EventListener($this->database);
		$this->getServer()->getPluginManager()->registerEvents($this->eventListener, $this);
	}
}