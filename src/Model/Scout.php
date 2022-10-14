<?php

namespace App\Model;

class Scout extends AbstractBee
{
    public function __construct(string $name)
    {
        parent::__construct($name, lossPerHit: 15, hitPoints: 30);
    }
}