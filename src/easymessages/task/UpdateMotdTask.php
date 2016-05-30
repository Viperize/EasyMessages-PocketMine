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
        //TODO: Optimize code
        $this->plugin->getServer()->getNetwork()->setName(str_replace(
            [
                "{SERVER_API_VERSION}",
                "{SERVER_CODENAME}",
                "{SERVER_DEFAULT_LEVEL}",
                "{SERVER_IP}",
                "{SERVER_LANGUAGE}",
                "{SERVER_MAX_PLAYER_COUNT}",
                "{SERVER_MOTD}",
                "{SERVER_NAME}",
                "{SERVER_PLAYER_COUNT}",
                "{SERVER_POCKETMINE_VERSION}",
                "{SERVER_PORT}",
                "{SERVER_TICK_USAGE}",
                "{SERVER_TICK_USAGE_AVERAGE}",
                "{SERVER_TPS}",
                "{SERVER_TPS_AVERAGE}",
                "{SERVER_VERSION}"
            ],
            [
                $this->plugin->getServer()->getApiVersion(),
                $this->plugin->getServer()->getCodename(),
                $this->plugin->getServer()->getDefaultLevel()->getName(),
                $this->plugin->getServer()->getIp(),
                $this->plugin->getServer()->getLanguage()->getName(),
                $this->plugin->getServer()->getMaxPlayers(),
                $this->plugin->getServer()->getMotd(),
                $this->plugin->getServer()->getName(),
                count($this->plugin->getServer()->getOnlinePlayers()),
                $this->plugin->getServer()->getPocketMineVersion(),
                $this->plugin->getServer()->getPort(),
                $this->plugin->getServer()->getTickUsage(),
                $this->plugin->getServer()->getTickUsageAverage(),
                $this->plugin->getServer()->getTicksPerSecond(),
                $this->plugin->getServer()->getTicksPerSecondAverage(),
                $this->plugin->getServer()->getVersion()
            ],
            $this->plugin->getConfig()->getNested("motd.dynamicMotd")
        ));
    }
}
