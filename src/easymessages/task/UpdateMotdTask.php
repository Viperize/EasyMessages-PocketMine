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
        $server = $this->plugin->getServer();
        $server->getNetwork()->setName(str_replace(
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
                $server->getApiVersion(),
                $server->getCodename(),
                $server->getDefaultLevel()->getName(),
                $server->getIp(),
                $server->getLanguage()->getName(),
                $server->getMaxPlayers(),
                $server->getMotd(),
                $server->getName(),
                count($server->getOnlinePlayers()),
                $server->getPocketMineVersion(),
                $server->getPort(),
                $server->getTickUsage(),
                $server->getTickUsageAverage(),
                $server->getTicksPerSecond(),
                $server->getTicksPerSecondAverage(),
                $server->getVersion()
            ],
            $this->plugin->getConfig()->getNested("motd.dynamicMotd")
        ));
    }
}
