<?php

namespace Minestrap\Souls\API;

use Minestrap\Souls\Main;
use pocketmine\utils\Config;
use pocketmine\player\Player;

class SoulsAPI {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    /** @var Config */
    private $players;

    //==============================
    //     LISTENER CONSTRUCTOR
    //==============================     

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getPluginConfig();
        $this->players = $this->main->getPlayers();
    }

    //==============================
    //        ADD SOULS API
    //==============================     

    public function addSouls(Player $player, int $amount) : int {
        $souls = $this->players->getNested("players." . $player->getName());
        $newsouls = $souls + $amount;
        $this->players->setNested("players." . $player->getName(), $newsouls);
        $this->players->save();

        return $newsouls;
    }

    //==============================
    //      REMOVE SOULS API
    //==============================     

    public function removeSouls(Player $player, int $amount) : int {
        $souls = $this->players->getNested("players." . $player->getName());
        $newsouls = $souls - $amount;
        if($newsouls < 0) {
            $newsouls = 0;
        }
        $this->players->setNested("players." . $player->getName(), $newsouls);
        $this->players->save();

        return $newsouls;
    }

    //==============================
    //       SET SOULS API
    //==============================     

    public function setSouls(Player $player, int $amount) : int {
        $this->players->setNested("players." . $player->getName(), $amount);
        $this->players->save();

        return $amount;
    }

    //==============================
    //       GET SOULS API
    //==============================

    public function getSouls(Player $player) : int {
        return $this->players->getNested("players." . $player->getName(), 0);
    }    
}