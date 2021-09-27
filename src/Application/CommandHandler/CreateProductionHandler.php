<?php

namespace App\Application\CommandHandler;

use App\Application\Command\CreateProductionCommand;
use App\Document\Production;
use App\Infrastructure\Repository\ProductionRepository;

class CreateProductionHandler
{
    /** @var ProductionRepository */
    private $repository;

    /**
     * @param ProductionRepository $repository
     */
    public function __construct(ProductionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateProductionCommand $command)
    {
        $production = new Production();
        $production->setGeneratorId($command->getGeneratorId());
        $production->setPower($command->getPower());
        $production->setDateFrom($command->getDateFrom());
        $production->setDateTo($command->getDateTo());

        $this->repository->create($production);
    }
}
