<?php

namespace App\Model;

class Worker extends AbstractBee
{
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->lossPerHit = 20;
        $this->hitPoints = 50;
    }
}