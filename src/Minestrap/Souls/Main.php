<?php

namespace Minestrap\Souls;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use Minestrap\Souls\Events\PlayerAdd;
use Minestrap\Souls\Events\PlayerEvent;

use Minestrap\Souls\API\SoulsAPI;
use Minestrap\Souls\Commands\SoulsViewCommand;
use Minestrap\Souls\Commands\SoulsSellCommand;

class Main extends PluginBase implements Listener {

    /** @var Config */
    private $config;

    /** @var Config */
    private $players;

    /** @var SoulsAPI */
    private $soulsAPI;

    //==============================
    //       ENABLE FUNCTION
    //==============================

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->players = new Config($this->getDataFolder() . "souls.yml", Config::YAML);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerAdd($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvent($this), $this);
        
        $this->soulsAPI = new SoulsAPI($this);
		$this->getServer()->getCommandMap()->register("souls", new SoulsViewCommand($this));
        $this->getServer()->getCommandMap()->register("soulssell", new SoulsSellCommand($this));
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

    public function getPluginConfig(): Config  {
        return $this->config;
    }

    //==============================
    //    GET GENERAL SOULS API
    //==============================        

    public function getSoulsAPI(): SoulsAPI {
        return $this->soulsAPI;
    }
}