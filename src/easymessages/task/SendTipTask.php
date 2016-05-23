<?php

namespace easymessages\task;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

//TODO: Remove tip, due to it being deprecated as of MCPE v0.14.0
class SendTipTask extends PluginTask{
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
                $this->plugin->broadcastTip(Utils::getRandom($this->plugin->getConfig()->getNested("tip.autoMessages")));
                break;
            case "blinking":
                $this->plugin->broadcastTip($this->plugin->getConfig()->getNested("tip.blinkingMessage"));
                break;
            case "infinite":
                $this->plugin->broadcastTip($this->plugin->getConfig()->getNested("tip.infiniteMessage"));
                break;
            case "scrolling":
                $tip = $this->plugin->getScrollingTip();
                $this->plugin->broadcastTip($tip);
                $this->plugin->setScrollingTip(Utils::next($tip));
                break;
            default:
                //For some reason PocketMine doesn't cancel the task, I'll comment out the log message to prevent console spam
                //$this->plugin->getServer()->getLogger()->notice("Invalid type set in tip.displayType, stopping task...");
                $this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
                break;
        }
    }
}