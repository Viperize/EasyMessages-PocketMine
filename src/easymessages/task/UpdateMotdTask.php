<?php

namespace easymessages\task;

use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class UpdateMotdTask extends PluginTask{
    /** @var EasyMessages */
    private $plugin;
    /**
     * @param EasyMessages $plugin
     */
    public function __construct(EasyMessages $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $this->plugin->getServer()->getNetwork()->setName(str_replace(
            [
                "{SERVER_DEFAULT_LEVEL}",
                "{SERVER_MAX_PLAYER_COUNT}",
                "{SERVER_PLAYER_COUNT}",
                "{SERVER_NAME}",
                "{SERVER_PORT}",
                "{SERVER_TPS}"
            ],
            [
                $this->plugin->getServer()->getDefaultLevel()->getName(),
                $this->plugin->getServer()->getMaxPlayers(),
                count($this->plugin->getServer()->getOnlinePlayers()),
                $this->plugin->getServer()->getMotd(),
                $this->plugin->getServer()->getPort(),
                $this->plugin->getServer()->getTicksPerSecond()
            ],
            $this->plugin->getConfig()->getNested("motd.dynamicMotd")
        ));
    }
}
