<?php

namespace ZenSageX444\DamageIndicator;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\entity\Location;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\EntityDataHelper;
use pocketmine\item\LegacyStringToItemParser;

use pocketmine\world\World;
use pocketmine\nbt\tag\CompoundTag;

use ZenSageX444\DamageIndicator\entities\ShowDamage;

class Damage extends PluginBase{
    
    private string $prefix = "§cDamageIndicator§f:";
    
    public function getPrefix(): String{
        return $this->prefix;
    }
    
    public function onLoad(): void{
        $this->getLogger()->info($this->getPrefix()." §ei've been loading...");
    }
    
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(new listener\DamageEvent($this), $this);
        
        EntityFactory::getInstance()->register(ShowDamage::class, function(World $world, CompoundTag $nbt): ShowDamage{
            $itemTag = $nbt->getCompoundTag("Item");
            $item = Item::nbtDeserialize($itemTag);
            return new ShowDamage(EntityDataHelper::parseLocation($nbt, $world), $item, $nbt);
        }, ["ShowDamage"]);
        
        $this->getLogger()->info($this->getPrefix()." §ai've been enabled...");
    }
    
    public function onDisable(): void{
        $this->getLogger()->info($this->getPrefix()." §ci've been disable...");
    }
    
    public function showDamage(Location $pos, int|float $damage): void{
        $text = "-".$damage;
        $location = new Location($pos->getX(), $pos->getY()+0.5, $pos->getZ(), $pos->getWorld(), 0, 0);
        $item = LegacyStringToItemParser::getInstance()->parse('77:0');
        $entity = new ShowDamage($location, $item);
        $entity->spawnToAll();
        $entity->setNameTag($text);
        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
        $entity->setMotion(new Vector3(lcg_value() * 0.2 - 0.1, 0.3, lcg_value() * 0.2 - 0.1));
    }

}
