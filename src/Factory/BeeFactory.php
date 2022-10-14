<?php

namespace App\Factory;

class BeeFactory
{
    private CONST POSSIBLE_BEE_TYPES = ['Queen', 'Worker', 'Scout'];

    public static function makeBees(string $type, int $number): ?array
    {
        if (in_array($type, self::POSSIBLE_BEE_TYPES))
        {
            $bees = [];
            $fullClassName = 'App\Model\\' . $type;
            for ($i = 0; $i < $number; $i++)
            {
                $bees[] = new $fullClassName($type === 'Queen' ? $type : $type . ' ' . $i + 1);
            }

            return $bees;
        } else {
            return null;
        }
    }
}