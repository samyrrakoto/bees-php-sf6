<?php

namespace App\Service;

use App\Class\AbstractBee;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BeeNormalizer
{
    public function normalizeHive(array $hive):array
    {
        $normalizedHive = array();
        foreach ($hive as $bee):
            $normalizedHive[] = $this->normalizeBee($bee);
        endforeach;

        return $normalizedHive;
    }

    private function normalizeBee(object $bee): array
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);

        return $serializer->normalize($bee);
    }

}