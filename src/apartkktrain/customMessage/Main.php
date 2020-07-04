<?php

namespace apartkktrain\customMessage;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\Config;


class Main extends PluginBase implements Listener
{

  private $config;
  private $config2;
  private $config3;

    public function onEnable()
    {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->config = new Config($this->getDataFolder() . "quitmessage.yml", Config::YAML, array(
            "client disconnect" => "§6 %name is client disconnect.",
            "timeout" => "§6 %name is timeout.",
            "Internal server error" => "§6 %name is Internal server error",
            ));
        $this->config2 = new Config($this->getDataFolder() . "joinmessage.yml" , Config::YAML, array( 
            "serverjoin" => "§6 %name is join.",
            "opjoin" => "§6§lOP!! %name is join",
            ));


        $this->config3 = new Config($this->getDataFolder() . "deathmessage.yml" , Config::YAML, array( 
            "death" => "§6 %name is death.",
            ));


    }


    public function onjoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name =   $event->getPlayer()->getName();

        $join1 = $this->config2->get("serverjoin") ;
        $join2 = $this->config2->get("opjoin");

 
        $join1 = str_replace("%name", $name, $join1);
        $join2 = str_replace("%name", $name, $join2);       

        if ($player->isOp()) {
            $event->setJoinMessage($join1);
        }else{
            $event->setJoinMessage($join2);
        }

    }




///quitMessage
    public function onquit(PlayerQuitEvent $event)
    {
    	$reason = $event->getQuitReason();
    	$player = $event->getPlayer();
    	$name   = $event->getPlayer()->getName();


        $quit1 = $this->config->get("client disconnect") ;
        $quit2 = $this->config->get("timeout");
        $quit3 = $this->config->get("Internal server error");

        $quit1 = str_replace("%name", $name, $quit1);
        $quit2 = str_replace("%name", $name, $quit2);
        $quit3 = str_replace("%name", $name, $quit3);
    	if ($reason === 'client disconnect') {
    		$event->setQuitMessage($quit1);
    		return true;

    	}
    	if ($reason === 'timeout') {
    		$event->setQuitMessage($quit2);
    		return true;
    	}
    	if ($reason === 'Internal server error') {
    		$event->setQuitMessage($quit3);
    		return true;
    	}
    }

    public function playerdeath(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        $name   = $event->getPlayer()->getName();

        $death = $this->config3->get("death");

        $death = str_replace("%name", $name, $death);

        $event->setDeathMessage($death);     
    }
}
