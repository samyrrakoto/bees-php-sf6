<?php

namespace App\Model;

abstract class AbstractBee
{
    private readonly string $name;
    private readonly int $lossPerHit;
    private int $hitPoints;
    private bool $lastHit = false;
    private bool $isDead = false;

    /**
     * @return bool wether the bee is dead or not
     */
    public function hit()
    {
        $this->hitPoints = $this->hitPoints - $this->lossPerHit;
        $this->lastHit = true;

        return ;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLossPerHit()
    {
        return $this->lossPerHit;
    }

    public function getHitPoints()
    {
        return $this->hitPoints;
    }

    public function getLastHit()
    {
        return $this->lastHit;
    }

    public function getIsDead()
    {
        return $this->isDead;
    }

    public function untagLastHit()
    {
        $this->lastHit = false;
    }

    public function setHitPointsToZero()
    {
        $this->hitPoints = 0;
    }

    public function tagAsDead()
    {
        $this->isDead = true;
    }
}