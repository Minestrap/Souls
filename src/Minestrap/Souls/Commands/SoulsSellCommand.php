<?php

namespace Minestrap\Souls\Commands;

use Minestrap\Souls\Main;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Minestrap\Souls\API\SoulsAPI;
use Minestrap\Souls\Utils\PluginUtils;

use Vecnavium\FormsUI\Form;
use davidglitch04\libEco\libEco;
use Vecnavium\FormsUI\SimpleForm;

class SoulsSellCommand extends Command {

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
        $this->config = $this->main->getConfig();
        $this->soulsAPI = new SoulsAPI($main);

        parent::__construct("soulssell");
        $this->setDescription("sell your souls by default system");
        $this->setPermission("souls.sell.command");
    }

    //==============================
    //     COMMAND EXECUTION
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

        if(!$this->config->get("souls-sell-command")) {
            $sender->sendMessage($this->config->get("command-not-available"));
        } else {
            $this->soulsSellUI($sender);
        }
        return true;
    }

    //==============================
    //        FORM GENERATOR
    //==============================

    public function soulsSellUI(Player $player): void {
        $form = new SimpleForm(function(Player $player, ?int $data) {
            if($data === null) {
                return;
            }

            switch($data) {
                case 0:
                    $soulprice = $this->config->get("price-per-soul");
                    $souls = $this->soulsAPI->getSouls($player);
                    $price = $souls * $soulprice;

                    if($this->config->get("souls-sell-mode") == 1) {
                        if($price > 0) {
                            libEco::getInstance()->addMoney($player, $price);
                            $this->soulsAPI->setSouls($player, 0);
							$player->sendMessage($this->config->get("success-when-selling"));
						
                        } else {
							$player->sendMessage($this->config->get("not-enough-souls"));
						}

                    } else {
                        if($price > 0) {
                            $player->getXpManager()->addXpLevels($price);
                            $this->soulsAPI->setSouls($player, 0);
							$player->sendMessage($this->config->get("success-when-selling"));
                        
                        } else {
                            $player->sendMessage($this->config->get("not-enough-souls"));
                        }
                    }
                break;

                case 1:
                    PluginUtils::playSound($player, "random.pop", 1, 1);
                break;
            }
        });

        $content = $this->config->get("souls-sell-description");
        $playerSouls = $this->soulsAPI->getSouls($player);
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