<?php

namespace App\Service;

use App\Factory\BeeFactory;

class BeeService
{
    private CONST MAX_QUEENS = 1;
    private CONST MAX_WORKERS = 5;
    private CONST MAX_SCOUTS = 8;

    public function createHive(): array
    {
        $beeFactory = new BeeFactory();
        $queens = $beeFactory->makeBees('Queen', self::MAX_QUEENS);
        $workers = $beeFactory->makeBees('Worker', self::MAX_WORKERS);
        $scouts = $beeFactory->makeBees('Scout', self::MAX_SCOUTS);
        $hive = array_merge($queens, $workers, $scouts);
        shuffle($hive);

        return $hive;
    }
}