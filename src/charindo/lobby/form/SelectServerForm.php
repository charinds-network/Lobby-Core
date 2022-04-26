<?php

declare(strict_types=1);

namespace charindo\lobby\form;

use pocketmine\form\Form;
use pocketmine\player\Player;

class SelectServerForm implements Form
{
	public function handleResponse(Player $player, $data): void
	{
		if ($data === null) {
			return;
		}

		$buttons = ['main', 'pt'];
		$player->sendMessage("§e{$buttons[$data]} §fを選びました。");
	}

	public function jsonSerialize()
	{
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