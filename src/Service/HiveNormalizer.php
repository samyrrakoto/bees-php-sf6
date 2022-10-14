<?php

namespace App\Service;

class HiveNormalizer
{
    public function __construct(private readonly BeeNormalizer $beeNormalizer)
    {}

    public function normalizeHive(array $hive):array
    {
        $normalizedHive = [];
        foreach ($hive as $bee)
        {
            $normalizedHive[] = $this->beeNormalizer->normalizeBee($bee);
        }

        return $normalizedHive;
    }
}