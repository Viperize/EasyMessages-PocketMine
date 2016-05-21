<?php

namespace easymessages\task;

use easymessages\utils\Utils;
use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class SendMessageTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function onRun($currentTick){
        $this->plugin->getServer()->broadcastMessage(Utils::getRandom($this->plugin->getConfig()->getNested("message.messages")));
    }
}