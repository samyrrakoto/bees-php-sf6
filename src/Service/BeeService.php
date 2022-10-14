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

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function createHive(): array
    {
        $beeFactory = new BeeFactory();
        $queens = $beeFactory->makeBees('Queen', self::MAX_QUEENS);
        $workers = $beeFactory->makeBees('Worker', self::MAX_WORKERS);
        $scouts = $beeFactory->makeBees('Scout', self::MAX_SCOUTS);
        $hive = array_merge($queens, $workers, $scouts);
        shuffle($hive);
        $session = $this->requestStack->getSession();
        $session->set('deadBeesIndex', []);

        return $hive;
    }

    public function saveHiveState(array $hive)
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
        $beeRange = range(0, count($hive) - 1);
        $session = $this->requestStack->getSession();
        $randomBee = (!empty($session->get('deadBeesIndex')) ? array_rand(array_diff($beeRange, $session->get('deadBeesIndex')),1) : rand(0, count($hive) -1));
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

            return $hive;
        } else {
            return $hive;
        }
    }

    private function untagLastHitOtherBees(array $hive, int $exclusion): array
    {
        foreach ($hive as $key => $bee):
            if ($key === $exclusion)
                continue;
            $bee->untagLastHit();
        endforeach;

        return $hive;
    }
}