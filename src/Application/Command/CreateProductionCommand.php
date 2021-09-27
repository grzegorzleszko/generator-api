<?php

namespace App\Application\Command;

class CreateProductionCommand
{
    /**
     * @var int
     */
    private $generatorId;

    /**
     * @var float
     */
    private $power;

    /**
     * @var \DateTimeInterface
     */
    private $dateFrom;

    /**
     * @var \DateTimeInterface
     */
    private $dateTo;


    /**
     * @return int
     */
    public function getGeneratorId(): int
    {
        return $this->generatorId;
    }

    /**
     * @param int $generatorId
     */
    public function setGeneratorId(int $generatorId): void
    {
        $this->generatorId = $generatorId;
    }

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    /**
     * @param float $power
     */
    public function setPower(float $power): void
    {
        $this->power = $power;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateFrom(): \DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTimeInterface $dateFrom
     */
    public function setDateFrom(\DateTimeInterface $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateTo(): \DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTimeInterface $dateTo
     */
    public function setDateTo(\DateTimeInterface $dateTo): void
    {
        $this->dateTo = $dateTo;
    }
}
