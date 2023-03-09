<?php

namespace Minestrap\Souls\API;

use Minestrap\Souls\Main;
use pocketmine\player\Player;

class ResetSouls {

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

    public function resetSouls(Player $player) : int {
        $this->config->setNested("players." . $player->getName(), 0);
        $this->config->save();
        
        return 0;
    }
}