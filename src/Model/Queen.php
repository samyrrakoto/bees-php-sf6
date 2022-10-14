<?php

namespace App\Model;

class Queen extends AbstractBee
{
    public function __construct(string $name)
    {
        parent::__construct($name, lossPerHit: 15, hitPoints: 100);
    }
}