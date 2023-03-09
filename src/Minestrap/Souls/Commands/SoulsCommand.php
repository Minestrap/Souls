<?php

namespace Minestrap\Souls\Commands;

use Minestrap\Souls\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Minestrap\Souls\SubCommands\SellSouls;

class SoulsCommand extends Command {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    //==============================
    //     LISTENER CONSTRUCTOR
    //==============================
    
    public function __construct(Main $main) {
        parent::__construct("souls", "souls avabiable subcommands");
        $this->registerSubCommand(new SellSouls());
    }

    //==============================
    //      COMMAND EXECUTER
    //==============================
    
    public function execute(CommandSender $sender, String $commandLabel, array $args) {
        if(!isset($args[0])) {
            if($this->config->get("help-by-ui")) {

            } else {
                $sender->sendMessage("§a==== COMMANDS ====");
                $sender->sendMessage("§e- /souls sell");
            }
            return;
        }
    }
}