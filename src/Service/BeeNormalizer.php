<?php

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BeeNormalizer
{
    public function normalizeBee(object $bee): array
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);
        $normalizedBee = $serializer->normalize($bee);
        $normalizedBee['type'] = (new \ReflectionClass($bee))->getShortName();

        return $normalizedBee;
    }
}