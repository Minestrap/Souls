<?php

namespace Minestrap\Souls;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use Minestrap\Souls\Events\PlayerAdd;
use Minestrap\Souls\Events\PlayerEvent;

use Minestrap\Souls\API\AddSouls;
use Minestrap\Souls\API\ResetSouls;
use Minestrap\Souls\API\RemoveSouls;

class Main extends PluginBase {

    private $config;
    private $players;

    private AddSouls $addSouls;
    private ResetSouls $resetSouls;
    private RemoveSouls $removeSouls;

    //==============================
    //       ENABLE FUNCTION
    //==============================

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml" . Config::YAML);
        $this->players = new Config($this->getDataFolder() . "souls.yml" . Config::YAML);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerAdd($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvent($this), $this);

        $this->addSouls = new AddSouls($config);
        $this->resetSouls = new ResetSouls($config);
        $this->removeSouls = new RemoveSouls($config);
    }

    //==============================
    //       DISABLE FUNCTION
    //==============================

    public function onDisable(): void {
        $this->players->save();
    }

    //==============================
    //      GET PLAYERS CONFIG
    //==============================        

    public function getPlayers(): Config {
        return $this->players;
    }

    //==============================
    //      GET GENERAL CONFIG
    //==============================        

    public function getConfig(): Config  {
        return $this->config;
    }

} 