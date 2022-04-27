<?php

declare(strict_types=1);

namespace charindo\lobby\item;

use charindo\lobby\database\MySQL;
use charindo\lobby\form\SelectServerForm;
use pocketmine\block\Block;
use pocketmine\item\Clock;
use pocketmine\item\Item;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class ServerSelectClock extends Item {
	public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector) : ItemUseResult {
		if(isset($player->clickRestrictionTime) && $player->clickRestrictionTime <= microtime(true)){
			$player->clickRestrictionTime = microtime(true) + 0.2;
			$item = $player->getInventory()->getItemInHand();
			$tag = $item->getNamedTag() ?? new CompoundTag();
			if($tag->getTag("ssc")){
				$player->sendForm(new SelectServerForm(MySQL::getInstance()));
				return ItemUseResult::SUCCESS();
			}
		}
		return ItemUseResult::FAIL();
	}

	public static function getItem() : Item {
		$item = VanillaItems::CLOCK();
		$item->getNamedTag()->setString("ssc", "ssc");
		return $item;
	}
}