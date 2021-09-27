<?php

namespace App\Application\QueryHandler;

use App\Infrastructure\Repository\ProductionRepository;

class ReportQueryHandler
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

    public function handle(): array
    {
//        $result = $this->repository->production(3, new \DateTime('2021-06-15'), new \DateTime('2021-06-16'));
        $result = $this->repository->getHourlyProductionInMW(new \DateTime('2021-06-15'));

        return $result;
    }
}