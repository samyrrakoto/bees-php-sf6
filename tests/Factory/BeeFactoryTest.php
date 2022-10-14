<?php

namespace App\Tests\Factory;

use App\Factory\BeeFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BeeFactoryTest extends KernelTestCase
{
    /**
     * @dataProvider provideBeeFactoryData
     */
    public function testMakeBees(string $type, int $number, string $fqcn)
    {
        $bees = BeeFactory::makeBees($type, $number);
        $this->assertIsArray($bees);
        $this->assertCount($number, $bees);
        foreach ($bees as $bee)
        {
            $this->assertInstanceOf($fqcn, $bee);
        }
    }

    public function testFailMakeBees()
    {
        $bees = BeeFactory::makeBees('Foo', 0);
        $this->assertNull($bees);
    }

    public function provideBeeFactoryData()
    {
        return [
            [
                'Queen',
                1,
                'App\Model\Queen',
            ],
            [
                'Worker',
                5,
                'App\Model\Worker',
            ],
            [
                'Scout',
                8,
                'App\Model\Scout',
            ],
        ];
    }
}