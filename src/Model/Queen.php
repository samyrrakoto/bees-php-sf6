<?php

namespace App\Model;

class Queen extends AbstractBee
{
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->lossPerHit = 15;
        $this->hitPoints = 100;
    }
}