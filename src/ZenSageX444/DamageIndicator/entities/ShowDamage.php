<?php

namespace ZenSageX444\DamageIndicator\entities;

use pocketmine\player\Player;
use pocketmine\entity\object\ItemEntity;
use pocketmine\event\entity\EntityDamageEvent;

class ShowDamage extends ItemEntity{
    
    protected int $age = 0;
    
    public function entityBaseTick(int $tickDiff = 1): bool{
        if($this->isClosed())return false;
        $hasUpdate= parent::entityBaseTick($tickDiff);
        if(!$this->isFlaggedForDespawn()){
            $this->age += $tickDiff;
            if($this->age >= 30){
                $this->flagForDespawn();
            }
        }
        return $hasUpdate;
    }
    
	public function onCollideWithPlayer(Player $player) : void{
		return;
	}
}
