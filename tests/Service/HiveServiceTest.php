<?php

namespace App\Tests\Service;

use App\Model\AbstractBee;
use App\Service\HiveService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HiveServiceTest extends KernelTestCase
{
    public function testCreateHive()
    {
        self::bootKernel();
        $container = static::getContainer();
        $hiveService = $container->get(HiveService::class);

        $hive = $hiveService->createHive();
        $this->assertIsArray($hive);

        foreach ($hive as $bee)
        {
            $this->assertInstanceOf(AbstractBee::class, $bee);
        }
    }

    public function testHitABee()
    {
        self::bootKernel();
        $container = static::getContainer();
        $hiveService = $container->get(HiveService::class);
        $hive = $hiveService->createHive();
        $hive = $hiveService->hitABee($hive, []);
        $this->assertIsArray($hive);
        $this->assertCount(2, $hive);
    }
}