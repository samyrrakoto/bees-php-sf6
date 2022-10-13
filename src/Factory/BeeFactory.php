<?php

namespace App\Factory;

use App\Model\Queen;
use App\Model\Scout;
use App\Model\Worker;

class BeeFactory
{
    private CONST POSSIBLE_BEE_TYPES = ['Queen', 'Worker', 'Scout'];

    public function makeBees(string $type, int $number): ?array
    {
        if (in_array($type, self::POSSIBLE_BEE_TYPES))
        {
            $bees = array();
            $fullClassName = 'App\Model\\' . $type;
            for ($i = 0; $i < $number; $i++)
            {
                $bees[] = (array) new $fullClassName($type . ' ' . $i + 1);
            }

            return $bees;
        } else {
            return null;
        }

    }
}