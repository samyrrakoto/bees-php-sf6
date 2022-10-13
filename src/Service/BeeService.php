<?php

namespace App\Service;

use App\Factory\BeeFactory;
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
}