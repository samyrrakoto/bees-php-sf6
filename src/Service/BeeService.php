<?php

namespace App\Service;

use App\Factory\BeeFactory;
use App\Model\Queen;
use Symfony\Component\HttpFoundation\RequestStack;

class BeeService
{
    private CONST MAX_QUEENS = 1;
    private CONST MAX_WORKERS = 5;
    private CONST MAX_SCOUTS = 8;

    public function __construct(private readonly RequestStack $requestStack)
    {}

    public function createHive(): array
    {
        $queens = BeeFactory::makeBees('Queen', self::MAX_QUEENS);
        $workers = BeeFactory::makeBees('Worker', self::MAX_WORKERS);
        $scouts = BeeFactory::makeBees('Scout', self::MAX_SCOUTS);
        $hive = array_merge($queens, $workers, $scouts);
        shuffle($hive);
        $session = $this->requestStack->getSession();
        $session->set('deadBeesIndex', []);

        return $hive;
    }

    public function saveHiveState(array $hive): array
    {
        $session = $this->requestStack->getSession();
        $session->set('currentHive', $hive);

        return $session->get('currentHive');
    }

    public function getHiveState(): array
    {
        $session = $this->requestStack->getSession();

        return $session->get('currentHive');
    }

    public function hitABee(array $hive): array
    {
        $session = $this->requestStack->getSession();
        $deadBeesIndex = $session->get('deadBeesIndex');
        $beeRange = range(0, count($hive) - 1);
        $randomBee = array_rand(array_diff($beeRange, $deadBeesIndex));
        $hive[$randomBee]->hit();
        $hive = $this->untagLastHitOtherBees($hive, $randomBee);
        $hive = $this->tagBeeAsDead($hive, $randomBee);

        return $this->saveHiveState($hive);
    }

    private function tagBeeAsDead(array $hive, int $index): array
    {
        if ($hive[$index]->getHitPoints() <= 0)
        {
            if ($hive[$index] instanceof Queen)
            {
                return array();
            }
            $hive[$index]->setHitPointsToZero();
            $hive[$index]->tagAsDead();
            $session = $this->requestStack->getSession();
            $deadBees = $session->get('deadBeesIndex');
            $deadBees[] = $index;
            $session->set('deadBeesIndex', $deadBees);
        }

        return $hive;
    }

    private function untagLastHitOtherBees(array $hive, int $exclusion): array
    {
        foreach ($hive as $key => $bee) {
            if ($key === $exclusion) {
                continue;
            }
            $bee->untagLastHit();
        }

        return $hive;
    }
}