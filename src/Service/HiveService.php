<?php

namespace App\Service;

use App\Factory\BeeFactory;
use App\Model\Queen;
use Symfony\Component\HttpFoundation\RequestStack;

class HiveService
{
    private CONST MAX_QUEENS = 1;
    private CONST MAX_WORKERS = 5;
    private CONST MAX_SCOUTS = 8;

    private array $hive;

    public function __construct(private readonly RequestStack $requestStack)
    {}

    public function createHive(): array
    {
        $queens = BeeFactory::makeBees('Queen', self::MAX_QUEENS);
        $workers = BeeFactory::makeBees('Worker', self::MAX_WORKERS);
        $scouts = BeeFactory::makeBees('Scout', self::MAX_SCOUTS);
        $this->hive = array_merge($queens, $workers, $scouts);
        shuffle($this->hive);
        $session = $this->requestStack->getSession();
        $session->set('deadBeesIndex', []);

        return $this->hive;
    }

    public function saveHiveState(): array
    {
        $session = $this->requestStack->getSession();
        $session->set('currentHive', $this->hive);

        return $session->get('currentHive');
    }

    public function getHiveState(): array
    {
        $session = $this->requestStack->getSession();

        return $session->get('currentHive');
    }

    public function hitABee(): array
    {
        $this->hive = $this->getHiveState();
        $session = $this->requestStack->getSession();
        $deadBeesIndex = $session->get('deadBeesIndex');
        $beeRange = range(0, count($this->hive) - 1);
        $randomBee = array_rand(array_diff($beeRange, $deadBeesIndex));
        $this->hive[$randomBee]->hit();
        $this->untagLastHitOtherBees($randomBee);
        $this->tagBeeAsDead($randomBee);

        return $this->saveHiveState();
    }

    private function tagBeeAsDead(int $index): void
    {
        if ($this->hive[$index]->getHitPoints() <= 0)
        {
            $this->hive[$index]->setHitPointsToZero();
            $this->hive[$index]->tagAsDead();
            $session = $this->requestStack->getSession();
            $deadBees = $session->get('deadBeesIndex');
            $deadBees[] = $index;
            $session->set('deadBeesIndex', $deadBees);
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