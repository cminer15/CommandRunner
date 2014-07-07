<?php

namespace AreaCommand;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityMoveEvent;
//This is part of the MySQL table creating function.
use AreaCommand\MySQL;

class AreaCommandPlugin extends PluginBase implements Listener{

	public function onLoad(){
		$this->getLogger()->info(TextFormat::WHITE . "You have installed AreaCommand, enable the plugin to use it.");
	}
        //Need to do MySQL file
	public function onEnable(){
		$this->getLogger()->info(TextFormat::WHITE . "AreaCommand loading...!");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this-> api->console->alias("ac", "AreaCommand");
		$this->MySQL = new MySQL($this);
		$this->getLogger()->info(TextFormat::Green . "AreaCommand loaded!");
    }

	public function onDisable(){
		$this->MySQL->close();
		$this->getLogger()->info(TextFormat::DARK_RED . "You have disabled AreaCommand!");
	}
public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
	$sender->getName() = $owner;
	$sender->getLevel()->getName() = $issuerworld
	//TODO
	//ADD CONSOLE RUN PROTECTION
		switch ($command->getName()) {
		//main command
			case "AreaCommand":
			//SWICHES TO SUBCOMMANDS
				$subCommand = strtolower(array_shift($args));
				switch ($subCommand) {
					case "":
					case "help":
						$sender->sendMessage("/ac help Gives you instructions");
						$sender->sendMessage("/ac pos1 Sets your first block position");
						$sender->sendMessage("/ac pos2 Sets your secound block position");
						$sender->sendMessage("/ac set <command> Sets what command to run when player goes through pos1 and pos2, use @player for their username.");
                        break;

					case "pos1":
						$x1 = $sender->getX();
						$y1 = $sender->getY();
						$z1 = $sender->getZ();
						$sender->sendMessage("[AreaCommand]First position set");
							break;

					case "pos2":
						$x2 = $sender->getX();
						$y2 = $sender->getY();
						$z2 = $sender->getZ();
						$sender->sendMessage("[AreaCommand]Secound position set, now do /ac set <command>");
						break;
						
					case "set":
						$command = array_shift($args);
						$name = array_shift($args);
						$this->MySQL->checkName($name) = $pname;
						if ($pname != $name) {
						$this->MySQL->createArea($owner, $name, $command, $x1, $y1, $z1, $x2, $y2, $z2, $issuerworld);
						$sender->sendMessage("[AreaCommander] Area created!");
						 }
						else {
							$sender->sendMessage("[AreaCommander] Area already exists!");
						}
						if (is_null($command)) {
							$sender->sendMessage("Usage: /ac set <command> <nameofselection>");
							}
							break;
						}

					default:
				}
				return true;
            default:
                return false;
		}
	}
//Special Thanks to Lambo! (For part of this) V
function onMove(EntityMoveEvent $event){
	if($event->getEntity() instanceof Player){
		$x1 = $this->MySQL->checkCoords($x1);
		$x2 = $this->MySQL->checkCoords($x2);
		$y1 = $this->MySQL->checkCoords($y1);
		$y2 = $this->MySQL->checkCoords($y2);
		$z1 = $this->MySQL->checkCoords($z1);
		$z2 = $this->MySQL->checkCoords($z2);
		$command = $this->MySQL->checkCommand($command);
		$issuerworld = $this->MySQL->checkWorld($issuerworld);
		$minx = min($x1,$x2);
		$maxx = max($x,$x2);
		$miny = min($y1,$y2);
		$maxy = max($y,$y2);
		$minz = min($z1,$z2);
		$maxz = max($z1,$z2);
		$event->getEntity() = $player;
		$event->getEntity()->getLevel()->getName() = $world;
	if($world = $issuerworld) {
	if($event->getEntity()->getFloorX() >= $minx and $event->getEntity()->getFloorX() <= $maxx){
	if($event->getEntity()->getFloorY() >= $miny and $event->getEntity()->getFloorY() <= $maxy){
	if($event->getEntity()->getFloorY() >= $minz and $event->getEntity()->getFloorZ() <= $maxz){
		str_replace("@player", $player->getName(), $command);
		
         }
      }
   }
}
}