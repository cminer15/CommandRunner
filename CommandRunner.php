<?php

namespace CommandRunner;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

use CommandRunner\MySQL;

class MainClass extends PluginBase implements Listener{

	public function onLoad(){
		$this->getLogger()->info(TextFormat::WHITE . "CommandRunner loaded!");
	}
        //Need to do MySWL file

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TextFormat::Black . "CommandRunner is now in use on this server!");
		$this-> api->console->alias("cr", "commandrunner");
		$this->MySQL = new MySQL($this);
    }

	public function onDisable(){
		$this->getLogger()->info(TextFormat::DARK_RED . "You have disabled CommandRunner!");
	}
public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
	$sender->getName() = $owner;
	//TODO
	//ADD CONSOLE RUN PROTECTION
		switch ($command->getName()) {
		//main command
			case "commandrunner":
			//SWICHES TO SUBCOMMANDS
				$subCommand = strtolower(array_shift($args));
				switch ($subCommand) {
					case "":
					case "help":
						$sender->sendMessage("/cr help Gives you instructions");
						$sender->sendMessage("/cr pos1 Sets your first block position");
						$sender->sendMessage("/cr Sets your secound block position");
						$sender->sendMessage("/cr set <command> Sets what command to run when player goes through pos1 and pos2, use @player for their username.");
                        break;

					case "pos1":
						$x1 = $sender->getX();
						$y1 = $sender->getY();
						$z1 = $sender->getZ();
						$sender->sendMessage("[CommandRunner]First position set");
							break;

					case "pos2":
						$x2 = $sender->getX();
						$y2 = $sender->getY();
						$z2 = $sender->getZ();
						$sender->sendMessage("[CommandRunner]Secound position set, now do /cr set <command>");
						break;
						
					case "set":
						$command = array_shift($args);
						$this->MySQL->createArea($owner, $name, $command, $x1, $y1, $z1, $x2, $y2, $z2,);
						//I'm in the process of adding names to each selection, 
                                                //like /cr <command> <name>
						if (is_null($command)) {
							$sender->sendMessage("Usage: /cr set <command>");
							}
							break;
						}

					default:
                        $sender->sendMessage("\"/cr $subCommand\" dose not exist");
						break;
				}
				return true;
            default:
                return false;
		}
	}
//Special Thanks to limbo! V
function onMove(EntityMoveEvent $event, $x1, $y1, $z1, $x2, $y2, $z2, $command){
	if($event->getEntity() instanceof Player){
		$minx = min($x1,$x2);
		$maxx = max($x,$x2);
		$miny = min($y1,$y2);
		$maxy = max($y,$y2);
		$minz = min($z1,$z2);
		$maxz = max($z1,$z2);
		$event->getEntity() = $player;
	if($event->getEntity()->getFloorX() >= $minx and $event->getEntity()->getFloorX() <= $maxx){
	if($event->getEntity()->getFloorY() >= $miny and $event->getEntity()->getFloorY() <= $maxy){
	if($event->getEntity()->getFloorY() >= $minz and $event->getEntity()->getFloorZ() <= $maxz)}
		str_replace("@player", $player->getName(), $command);
		
         }
      }
   }
}}
