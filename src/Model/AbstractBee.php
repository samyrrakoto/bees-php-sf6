<?php

namespace App\Model;

abstract class AbstractBee
{
    private bool $lastHit = false;
    private bool $isDead = false;

    public function __construct(
        private readonly string $name,
        private readonly int $lossPerHit,
        private int $hitPoints)
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getLossPerHit(): int
    {
        return $this->lossPerHit;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function getLastHit(): bool
    {
        return $this->lastHit;
    }

    public function getIsDead(): bool
    {
        return $this->isDead;
    }

    public function hit(): void
    {
        $this->hitPoints = $this->hitPoints - $this->lossPerHit;
        $this->lastHit = true;
    }

    public function untagLastHit(): void
    {
        $this->lastHit = false;
    }

    public function setHitPointsToZero(): void
    {
        $this->hitPoints = 0;
    }

    public function tagAsDead(): void
    {
        $this->isDead = true;
    }
}