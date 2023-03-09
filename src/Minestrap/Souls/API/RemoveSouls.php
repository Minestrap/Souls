<?php

namespace Minestrap\Souls\API;

use Minestrap\Souls\Main;
use pocketmine\player\Player;

class RemoveSouls {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    //========================
    //   SOULS CONSTRUCTOR
    //========================

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getConfig();
    }

    //========================
    //      SOULS MANAGER
    //========================

    public function removeSouls(Player $player, int $amount) : int {
        $souls = $this->config->getNested("players." . $player->getName());
        $newsouls = $souls - $amount;
        $this->config->setNested("players." . $player->getName(), $newsouls);
        $this->config->save();

        return $newsouls;
    }
}