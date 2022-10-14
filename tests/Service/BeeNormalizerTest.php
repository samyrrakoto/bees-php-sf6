<?php

namespace App\Tests\Service;

use App\Service\BeeNormalizer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BeeNormalizerTest extends KernelTestCase
{
     /**
     * @dataProvider provideBeeFqcn
     */
    public function testNormalizeBee(string $fqcn)
    {
        $bee = new $fqcn('Bee');
        $beeNormalizer = new BeeNormalizer();
        $normalizedBee = $beeNormalizer->normalizeBee($bee);

        $this->assertIsArray($normalizedBee);
        $this->assertArrayHasKey('name', $normalizedBee);
        $this->assertArrayHasKey('hitPoints', $normalizedBee);
        $this->assertArrayHasKey('lossPerHit', $normalizedBee);
        $this->assertArrayHasKey('isDead', $normalizedBee);
        $this->assertArrayHasKey('lastHit', $normalizedBee);
    }

    public function provideBeeFqcn()
    {
        return [
            [
                'App\Model\Queen',
            ],
            [
                'App\Model\Worker',
            ],
            [
                'App\Model\Scout',
            ],
        ];
    }
}