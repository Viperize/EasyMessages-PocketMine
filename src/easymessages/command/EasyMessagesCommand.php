<?php

namespace easymessages\command;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class EasyMessagesCommand extends Command{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct("easymessages", "Shows all EasyMessages commands", null, ["em"]);
        $this->setPermission("easymessages.command.easymessages");
        $this->plugin = $plugin;
    }
    /** 
     * @param CommandSender $sender 
     */
    private function sendCommandHelp(CommandSender $sender){
        $commands = [
            "help" => "Shows all EasyMessages commands",
            "message" => "Sends a message",
            "motd" => "Sets the server motd",
            "popup" => "Sends a popup"
        ];
        $sender->sendMessage("EasyMessages commands:");
        foreach($commands as $name => $description){
            $sender->sendMessage("/easymessages $name: $description");
        }
    }
    /**
     * @param CommandSender $sender
     * @param string $label
     * @param string[] $args
     * @return bool
     */
    public function execute(CommandSender $sender, $label, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "m":
                case "message":
                    if(isset($args[1])){
                        $message = Utils::replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $sender->getServer()->broadcastMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to @all.");
                        }
                        elseif($player = $sender->getServer()->getPlayer($args[1])){
                            $player->sendMessage($message);
                            $sender->sendMessage(TextFormat::GREEN."Sent message to ".$player->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s) specified.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                case "motd":
                    if(isset($args[1])){
                        $motd = Utils::replaceSymbols(implode(" ", array_slice($args, 1)));
                        $sender->getServer()->getNetwork()->setName($motd);
                        $sender->sendMessage(TextFormat::GREEN."Set server motd to: ".TextFormat::RESET.$motd.".");
                    }
                    else{
                        $sender->sendMessage(TextFormat::GREEN."Current server motd: ".TextFormat::RESET.$sender->getServer()->getNetwork()->getName());
                    }
                    break;
                case "p":
                case "popup":
                    if(isset($args[1])){
                        $popup = Utils::replaceSymbols(implode(" ", array_slice($args, 2)));
                        if(strtolower($args[1]) === "@all"){
                            $sender->getServer()->broadcastPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to @all.");
                        }
                        elseif($player = $sender->getServer()->getPlayer($args[1])){
                            $player->sendPopup($popup);
                            $sender->sendMessage(TextFormat::GREEN."Sent popup to ".$player->getName().".");
                        }
                        else{
                            $sender->sendMessage(TextFormat::RED."Failed to send message due to invalid recipient(s) specified.");
                        }
                    }
                    else{
                        $sender->sendMessage(TextFormat::RED."Please specify a recipient.");
                    }
                    break;
                default:
                    $sender->sendMessage("Usage: /easymessages <sub-command> [parameters]");
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return false;
        }
        return true;
    }
}
