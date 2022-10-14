<?php

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HiveNormalizer
{
    public function __construct(private readonly BeeNormalizer $beeNormalizer)
    {
    }
    public function normalizeHive(array $hive):array
    {
        $normalizedHive = array();
        foreach ($hive as $bee):
            $normalizedHive[] = $this->beeNormalizer->normalizeBee($bee);
        endforeach;

        return $normalizedHive;
    }
}