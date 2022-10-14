<?php

namespace App\Tests\Model;

use App\Model\AbstractBee;
use App\Model\Queen;
use App\Model\Scout;
use App\Model\Worker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BeeTest extends KernelTestCase
{
    /**
     * @dataProvider provideBeeCreationData
     */
    public function testCreateBee(string $fqcn, string $name, int $lossPerHit, int $hitPoints)
    {

        $bee = new $fqcn($name);
        $this->assertInstanceOf(AbstractBee::class, $bee);
        $this->assertEquals($lossPerHit, $bee->getLossPerHit());
        $this->assertEquals($hitPoints, $bee->getHitPoints());
        $this->assertFalse($bee->getLastHit());
        $this->assertFalse($bee->getIsDead());
    }

    /**
     * @dataProvider provideBeeLifecycleData
     */
    public function testBeeLifeCycle(string $fqcn, int $remainingHp)
    {
        $bee = new $fqcn('Bee');
        $bee->hit();
        $this->assertEquals($remainingHp, $bee->getHitPoints());
        $this->assertTrue($bee->getLastHit());

        $bee->untagLastHit();
        $this->assertFalse($bee->getLastHit());

        $bee->tagAsDead();
        $this->assertTrue($bee->getIsDead());

        $bee->setHitPointsToZero();
        $this->assertEquals(0, $bee->getHitPoints());
    }

    public function provideBeeCreationData()
    {
        return [
            [
                'App\Model\Queen',
                'Queen',
                15,
                100,
            ],
            [
                'App\Model\Worker',
                'Worker',
                20,
                50,
            ],
            [
                'App\Model\Scout',
                'Scout',
                15,
                30,
            ],
        ];
    }

    public function provideBeeLifecycleData()
    {
        return [
            [
                'App\Model\Queen',
                85,
            ],
            [
                'App\Model\Worker',
                30,
            ],
            [
                'App\Model\Scout',
                15,
            ],
        ];
    }
}