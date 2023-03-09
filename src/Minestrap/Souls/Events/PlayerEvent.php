<?php

namespace Minestrap\Souls\Events;

use Minestrap\Souls\Main;
use pocketmine\event\Listener;
use Minestrap\Souls\API\AddSouls;

use pocketmine\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class PlayerEvent implements Listener {

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
    //     KILLS SOULS MANAGER
    //==============================

    public function onDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $playername = $player->getName();
        $worldname = $player->getWorld()->getFolderName();

        if(!in_array($worldname, $this->config->get("souls-worlds", []))) {
            return;
        }

        if($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();
            if($killer instanceof Player) {
                $killername = $killer->getName();
                $amount = $this->config->get("souls-by-kill");

                $addSouls = new AddSouls($this->config);
                $addSouls->addSouls($killername, $amount);
            }
        }        
    }
}