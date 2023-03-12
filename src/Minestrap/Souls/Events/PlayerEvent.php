<?php

namespace Minestrap\Souls\Events;

use Minestrap\Souls\Main;
use pocketmine\event\Listener;
use Minestrap\Souls\API\SoulsAPI;

use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class PlayerEvent implements Listener {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    /** @var SoulsAPI */
    private $soulsAPI;

    //==============================
    //     LISTENER CONSTRUCTOR
    //==============================   

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getPluginConfig();
        $this->soulsAPI = new SoulsAPI($main);
    }

    //==============================
    //     PLAYER KILL EVENT ADD
    //==============================       

    public function onDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $worldname = $player->getWorld()->getFolderName();

        if(!in_array($worldname, $this->config->get("souls-worlds", []))) {
            return;
        }

        $cause = $player->getLastDamageCause();

        if($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();

            if($killer instanceof Player) {
                $killername = $killer->getName();

                $amount = $this->config->get("souls-by-kill");
                $this->soulsAPI->addSouls($killer, $amount);
            }
        }
    }
}