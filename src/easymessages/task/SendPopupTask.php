<?php

namespace easymessages\task;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class SendPopupTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
    /** @var string */
    private $type;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin, $type){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->type = strtolower($type);
    }
    public function onRun($currentTick){
        switch($this->type){
            case "auto":
                $this->plugin->getServer()->broadcastPopup(Utils::getRandom($this->plugin->getConfig()->getNested("popup.autoMessages")));
                break;
            case "blinking":
                $this->plugin->getServer()->broadcastPopup($this->plugin->getConfig()->getNested("popup.blinkingMessage"));
                break;
            case "infinite":
                $this->plugin->getServer()->broadcastPopup($this->plugin->getConfig()->getNested("popup.infiniteMessage"));
                break;
            case "scrolling":
                $popup = $this->plugin->getScrollingPopup();
                $this->plugin->getServer()->broadcastPopup($popup);
                $this->plugin->setScrollingPopup(Utils::next($popup));
                break;
            default:
                //For some reason the task doesn't cancel, I'll comment out the log message to prevent console spam
                //$this->plugin->getServer()->getLogger()->notice("Invalid type set in popup.displayType, stopping task...");
                $this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
                break;
        }
    }
}