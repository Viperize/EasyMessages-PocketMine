<?php

namespace easymessages;

use easymessages\command\EasyMessagesCommand;
use easymessages\event\EasyMessagesListener;
use easymessages\task\SendMessageTask;
use easymessages\task\SendPopupTask;
use easymessages\task\UpdateMotdTask;
use easymessages\utils\Utils;
use pocketmine\plugin\PluginBase;

class EasyMessages extends PluginBase{
    /** @var string */
    private $scrollingPopup = "";
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->saveResource("values.txt");
    	$this->getServer()->getCommandMap()->register("easymessages", new EasyMessagesCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new EasyMessagesListener($this), $this);
    	if($this->getConfig()->getNested("message.autoBroadcast")){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new SendMessageTask($this), ($this->getConfig()->getNested("message.interval") * 20));
    	}
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new SendPopupTask($this, $pType = $this->getConfig()->getNested("popup.displayType")), Utils::getInterval($pType, $this->getConfig()->getNested("popup.interval")));
        if(strtolower($this->getConfig()->getNested("motd.displayType")) === "dynamic"){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new UpdateMotdTask($this), ($this->getConfig()->getNested("motd.interval") * 20));
        }
        else{
            $this->getServer()->getNetwork()->setName($this->getConfig()->getNested("motd.staticMotd"));
        }
        $this->setScrollingPopup($this->getConfig()->getNested("popup.scrollingMessage"));
    }
    /**
     * @return string
     */
    public function getScrollingPopup(){
        return $this->scrollingPopup;
    }
    /**
     * @param string $message
     */
    public function setScrollingPopup($message){
        $this->scrollingPopup = (string) $message;
    }
}
