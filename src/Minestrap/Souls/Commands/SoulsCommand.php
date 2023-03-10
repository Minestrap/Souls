<?php

namespace Minestrap\Souls\Commands;

use Minestrap\Souls\Main;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Minestrap\Souls\API\SoulsAPI;
use Minestrap\Souls\Utils\PluginUtils;

use davidglitch04\libEco\libEco;
use Vecnavium\FormsUI\SimpleForm;

class SoulsCommand extends Command {

    /** @var Main */
    private $main;

    /** @var Config */
    private $config;

    /** @var SoulsAPI */
    private $SoulsAPI;

    //==============================
    //     COMMAND CONSTRUCTOR
    //==============================

    public function __construct(Main $main) {
        $this->main = $main;
        $this->config = $this->main->getConfig();
        $this->soulsAPI = new SoulsAPI($main);

        parent::__construct("soulssell");
        $this->setDescription("sell your souls by default system");
        $this->setPermission("souls.sell.command");
    }

    //==============================
    //     COMMAND CONSTRUCTOR
    //==============================
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
        if(!$sender instanceof Player) {
            $sender->sendMessage($this->config->get("in-game-message"));
            return true;
        }

        if(!$sender->hasPermission("souls.sell.command")) {
            $sender->sendMessage($this->config->get("no-perms-message"));
            return true;
        }

        if(!$this->config->get("commands-by-ui")) {
            $sender->sendMessage("not available yet.");
        } else {
            $this->SoulsSellUI($player);
        }
    }

    //==============================
    //        FORM GENERATOR
    //==============================

    public function SoulsSellUI(Player $player): void {
        $form = new SimpleForm(function(Player $player, ?int $data) {
            if($data === null) {
                return;
            }

            switch($data) {
                case 0:
                    $soulprice = $this->config->get("price-per-soul");
                    $souls = $this->soulsAPI->getSouls($player);
                    $price = $souls * $souprice;

                    if($this->config->get("souls-sell-way") == 1) {
                        if($price > 0) {
                            libEco::addMoney($player, $price);
                            $this->setSouls($player, 0);
                        }

                    } else {
                        if($price > 0) {
                            $sender->getXpManager()->addXp($price);
                            $this->setSouls($player, 0);
                        }
                    }
                break;

                case 1:
                    PluginUtils::playSound($sender, "random.pop", 1, 1);
                break;
            }
        });

        $content = $this->config->get("souls-sell-description");
        $playerSouls = $soulsAPI->getSouls($player);
        $playerName = $player->getName();
        
        $content = str_replace("%player_souls%", $playerSouls, $content);
        $content = str_replace("%player_name%", $playerName, $content);
        
        $form->setTitle($this->config->get("souls-sell-title"));
        $form->setContent($content);
        $form->addButton($this->config->get("souls-sell-button"));
        $form->addButton($this->config->get("souls-sell-exit-button"));
        
        $player->sendForm($form);        
    }
}
