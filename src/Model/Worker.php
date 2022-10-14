<?php

namespace App\Model;

class Worker extends AbstractBee
{
    public function __construct(string $name)
    {
        parent::__construct($name, lossPerHit: 20, hitPoints: 50);
    }
}