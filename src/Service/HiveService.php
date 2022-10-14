<?php

namespace App\Service;

use App\Factory\BeeFactory;
use App\Model\Queen;

class HiveService
{
    private CONST MAX_QUEENS = 1;
    private CONST MAX_WORKERS = 5;
    private CONST MAX_SCOUTS = 8;

    private array $hive = [];
    private array $deadBeesIndex = [];

    public function createHive(): array
    {
        $queens = BeeFactory::makeBees('Queen', self::MAX_QUEENS);
        $workers = BeeFactory::makeBees('Worker', self::MAX_WORKERS);
        $scouts = BeeFactory::makeBees('Scout', self::MAX_SCOUTS);
        $this->hive = array_merge($queens, $workers, $scouts);
        shuffle($this->hive);

        return $this->hive;
    }

    public function hitABee(array $bees, array $deadBees): array
    {
        $this->hive = $bees;
        $this->deadBeesIndex = $deadBees;
        $beeRange = range(0, count($this->hive) - 1);
        $randomBee = array_rand(array_diff($beeRange, $this->deadBeesIndex));
        $this->hive[$randomBee]->hit();
        $this->untagLastHitOtherBees($randomBee);
        $this->tagBeeAsDead($randomBee);

        return [$this->hive, $this->deadBeesIndex];
    }

    private function tagBeeAsDead(int $index): void
    {
        if ($this->hive[$index]->getHitPoints() <= 0)
        {
            $this->hive[$index]->setHitPointsToZero();
            $this->hive[$index]->tagAsDead();
            $this->deadBeesIndex[] = $index;

            if ($this->hive[$index] instanceof Queen)
            {
                $this->hive = [];
            }
        }
    }

    private function untagLastHitOtherBees(int $exclusion): void
    {
        foreach ($this->hive as $key => $bee) {
            if ($key === $exclusion) {
                continue;
            }
            $bee->untagLastHit();
        }
    }
}