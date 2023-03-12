<?php

namespace Minestrap\Souls\Events;

use Minestrap\Souls\Main;
use pocketmine\utils\Config;
use pocketmine\event\Listener;

use pocketmine\player\Player;
use Minestrap\Souls\API\SoulsAPI;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerAdd implements Listener {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;
    
    /** @var Config */
    private $players;

    /** @var SoulsAPI */
    private $soulsAPI;    

    //==============================
    //     LISTENER CONSTRUCTOR
    //==============================

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getPluginConfig();
        $this->players = $this->main->getPlayers();
        $this->soulsAPI = new SoulsAPI($main);
    }

    //==============================
    //       JOIN PLAYER ADD
    //==============================    
    
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playername = $player->getName();

        if(!isset($this->players->getAll()["players"][$playername])) {
            $this->players->setNested("players.$playername", 0);
            $this->players->save();
        }
    }

    //==============================
    //     QUIT PLAYER CHECKER
    //==============================    
    
    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $playername = $player->getName();
        
        if($this->players->exists("players." . $playername)) {
            $this->players->setNested("players.". $playername, $this->soulsAPI->getSouls($player));
            $this->players->save();
        }
    }
}