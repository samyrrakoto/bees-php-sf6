<?php

namespace App\Model;

class Scout extends AbstractBee
{
    public function __construct()
    {
        $this->lossPerHit = 15;
        $this->hitPoints = 30;
    }
}