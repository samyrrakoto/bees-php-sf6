<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class HiveRepository
{
    public function __construct(private readonly RequestStack $requestStack)
    {}

    public function storeNewHive(array $hive)
    {
        $session = $this->requestStack->getSession();
        $session->set('currentHive', $hive);
        $session->set('deadBeesIndex', []);
    }

    public function saveHiveState($hive, $deadBeesIndex): array
    {
        $session = $this->requestStack->getSession();
        $session->set('currentHive', $hive);
        $session->set('deadBeesIndex', $deadBeesIndex);

        return [$session->get('currentHive'), $session->get('deadBeesIndex')];
    }

    public function getHiveState(): array
    {
        $session = $this->requestStack->getSession();

        return [$session->get('currentHive'), $session->get('deadBeesIndex')];
    }

}