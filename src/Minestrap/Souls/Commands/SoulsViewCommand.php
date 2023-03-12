<?php

namespace Minestrap\Souls\Commands;

use Minestrap\Souls\Main;
use pocketmine\utils\Config;
use Minestrap\Souls\API\SoulsAPI;
use Minestrap\Souls\Utils\PluginUtils;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class SoulsViewCommand extends Command {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    /** @var SoulsAPI */
    private $soulsAPI;    

    //==============================
    //     COMMAND CONSTRUCTOR
    //==============================

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getPluginConfig();
        $this->soulsAPI = new SoulsAPI($main);

        parent::__construct("souls");
        $this->setDescription("view your total souls on server");
        $this->setPermission("souls.view.command");
    }

    //==============================
    //     COMMAND EXECUTION
    //==============================
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
        if(!$sender instanceof Player) {
            $sender->sendMessage($this->config->get("in-game-message"));
            return true;
        }

        if(!$sender->hasPermission("souls.view.command")) {
            $sender->sendMessage($this->config->get("no-perms-message"));
            return true;
        }

        if(!$this->config->get("souls-view-command")) {
            $sender->sendMessage($this->config->get("command-not-available"));
        } else {
            $playerSouls = $this->soulsAPI->getSouls($sender);
            $playerName = $sender->getName();

            $sender->sendMessage(str_replace(["%player_souls%", "%player_name%"], [$playerSouls, $playerName], $this->config->get("souls-view-message-command")));
        }
        return true;
    }
}