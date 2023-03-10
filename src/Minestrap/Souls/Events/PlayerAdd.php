<?php

namespace Minestrap\Souls\Events;

use Minestrap\Souls\Main;
use pocketmine\utils\Config;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;

class PlayerAdd implements Listener {

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
        $this->config = $this->main->getConfig();
        $this->players = $this->main->getPlayers();
    }

    //==============================
    //      JOIN EVENT CREATOR
    //==============================

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playername = $player->getName();

        if(!$this->config->exists("players.$playername")) {
            $this->players->setNested("players.$playername", 0);
            $this->players->save();
        }
    }
}