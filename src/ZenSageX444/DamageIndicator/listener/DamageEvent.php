<?php

namespace ZenSageX444\DamageIndicator\listener;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

use ZenSageX444\DamageIndicator\Damage as Main;

class DamageEvent implements Listener{
    
    private Main $plugin;
    
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function getPlugin(): Main{
        return $this->plugin;
    }
    
    public function onEntityDamage(EntityDamageEvent $event): void{
        $entity = $event->getEntity();
        $this->getPlugin()->showDamage($entity->getLocation(), $event->getFinalDamage());
    }
}
        
