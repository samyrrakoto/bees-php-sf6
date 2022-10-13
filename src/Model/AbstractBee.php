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
    public function hit(): bool
    {
        return ($this->hitPoints - $this->lossPerHit >= 0);
    }
}