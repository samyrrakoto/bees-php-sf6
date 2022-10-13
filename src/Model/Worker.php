<?php

namespace App\Model;

class Worker extends AbstractBee
{
    public function __construct()
    {
        $this->lossPerHit = 20;
        $this->hitPoints = 50;
    }
}