<?php

namespace App\Model;

abstract class AbstractBee
{
    private readonly string $name;
    private readonly int $lossPerHit;
    private int $hitPoints;

    /**
     * @return bool wether the bee is dead or not
     */
    public function hit()
    {
        $this->hitPoints = $this->hitPoints - $this->lossPerHit;

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
}