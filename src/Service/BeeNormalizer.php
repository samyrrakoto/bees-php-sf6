<?php

namespace App\Service;

use App\Model\AbstractBee;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BeeNormalizer
{
    public function normalizeBee(AbstractBee $bee): array
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);
        $normalizedBee = $serializer->normalize($bee);
        $normalizedBee['type'] = (new \ReflectionClass($bee))->getShortName();

        return $normalizedBee;
    }
}