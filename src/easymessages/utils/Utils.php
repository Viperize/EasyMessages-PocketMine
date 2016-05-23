<?php

namespace easymessages\utils;

use pocketmine\utils\TextFormat;

class Utils{
    /**
     * Gets the next message, for scrolling
     * @param string $message
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function next($message){
        if(is_string($message)){
            return substr($message, -1).substr($message, 0, -1);
        }
        else{
            throw new \InvalidArgumentException("Expected string, ".gettype($message)." given.");
        }
    }
    /**
     * Replaces all formatted color codes in the specified message, if revert is true, it will remove all text effects
     * @param string $message
     * @param bool $revert
     * @return string
     */
    public static function replaceSymbols($message, $revert = false){
    	$defaultFormat = [
    	    TextFormat::BLACK,
    	    TextFormat::DARK_BLUE,
    	    TextFormat::DARK_GREEN,
    	    TextFormat::DARK_AQUA,
    	    TextFormat::DARK_RED,
    	    TextFormat::DARK_PURPLE,
    	    TextFormat::GOLD,
    	    TextFormat::GRAY,
    	    TextFormat::DARK_GRAY,
    	    TextFormat::BLUE,
    	    TextFormat::GREEN,
    	    TextFormat::AQUA,
    	    TextFormat::RED,
    	    TextFormat::LIGHT_PURPLE,
    	    TextFormat::YELLOW,
    	    TextFormat::WHITE,
    	    TextFormat::OBFUSCATED,
    	    TextFormat::BOLD,
    	    TextFormat::STRIKETHROUGH,
    	    TextFormat::UNDERLINE,
    	    TextFormat::ITALIC,
    	    TextFormat::RESET
    	];
    	$newFormat = [
    	    "&0", "&1", "&2", "&3",
    	    "&4", "&5", "&6", "&7",
    	    "&8", "&9", "&a", "&b",
    	    "&c", "&d", "&e", "&f",
    	    "&k", "&l", "&m", "&n",
    	    "&o", "&r"
    	];
    	if($revert){
    	    return TextFormat::clean($message);
    	}
    	else{
    	    return str_replace($newFormat, $defaultFormat, $message);
    	}
    }
    /** 
     * Draws a random value out of an array
     * @param array $stack
     * @return string
     */
    public static function getRandom(array $stack){
    	if(is_array($stack)){
            return $stack[array_rand($stack, 1)];
        }
    }
    /**
     * Returns interval of a certain task
     * @param string $type
     * @param int $interval
     * @return int
     */
    public static function getInterval($type, $interval = 1){
        switch(strtolower($type)){
            case "auto":
                return $interval * 20;
            case "blinking":
                return 30;
            case "infinite":
                return 7;
            case "scrolling":
                return 8;
            default:
                return 1;
        }
    }
}