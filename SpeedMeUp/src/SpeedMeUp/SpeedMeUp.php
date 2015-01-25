<?php

namespace SpeedMeUp;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;


class SpeedMeUp extends PluginBase implements Listener{
	private $speedup;
	
	public function onEnable(){ 
		$this->getLogger()->info("SpeedMeUp Is Loading!");
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		@mkdir($this->getDataFolder(), 0777, true);
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
		if($this->config->exists("speedup") AND $this->config->get("speedup") !== array() and $this->config->exists("swim") ){
			$this->speedup =  $this->config->get("speedup");
			$this->getLogger()->info(TextFormat::DARK_GREEN . "SpeedUpBlock:".$this->speedup ."!");
		}else{
		$this->speedup= Item::DOOR_BLOCK;
		$this->getLogger()->info(TextFormat::DARK_RED . "SpeedUpBlock in unseted, changed into:".Item::DOOR_BLOCK."!");
		$this->config->set("speedup",Item::DOOR_BLOCK);
		$this->config->save();
		}
		$this->getLogger()->info("Loaded!!!!!");
	}
			
	public function SpeedMeUp(PlayerMoveEvent $event){
	$p = $event->getPlayer();
	$poss = new Vector3 ($p->x, $p->y-1, $p->z);
	$blocks = $this->getServer ()->getDefaultLevel ()->getBlock ( $poss );
	for($i1 = - 1; $i1 <= 1; $i1 ++)
				for($b1 = - 1; $b1 <= 1; $b1 ++) {
					$pos = new Vector3 ( $p->x + $i1, $p->y, $p->z + $b1 );
					$block = $this->getServer ()->getDefaultLevel ()->getBlock ( $pos );
					if ($block->getID () == $this->speedup) {
					//var_dump($event->getTo ());
	$x = $event->getTo()->getX() - $event->getFrom()->getX();
	$y = $event->getTo()->getY() - $event->getFrom()->getY();
	$z = $event->getTo()->getZ() - $event->getFrom()->getZ();
	$pos2 = new Vector3 ($x*2,$y*2,$z*2);
	//var_dump("X:".$x." Y:".$y." Z:".$z);
	//$pos2 = new Vector3 ($event->getTo()->getX() +1,$event->getTo()->getY(),$event->getTo()->getZ() +1);
	//setTo (Location $to)
	$p->setMotion($pos2);	
			}		
		}
	}
	
	public function onDisable(){
		$this->getLogger()->info("SpeedMeUp Unload Success!");
	}
	
}

