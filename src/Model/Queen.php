<?php

namespace App\Model;

class Queen extends AbstractBee
{
    public function __construct()
    {
        $this->lossPerHit = 15;
        $this->hitPoints = 100;
    }
}