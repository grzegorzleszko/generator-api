<?php

namespace App\Infrastructure\Repository;

use App\Document\Production;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ProductionRepository extends DocumentRepository
{
    /** @var DocumentManager */
    protected $dm;

    /**
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function create($production)
    {
        $this->dm->persist($production);

        $this->dm->flush();

        return $production->getId();
    }

    public function getHourlyProductionInMW(\DateTime $date): array
    {
        $from = $date->format('Y-m-j 00:00:00');
        $to = $date->modify('+1 day')->format('Y-m-j 00:00:00');

        $builder = $this->dm->createAggregationBuilder(Production::class);
        $builder
            ->match()
                ->field('dateFrom')
                ->gte($from)
                ->field('dateTo')
                ->lt($to)
            ->group()
                ->field('id')
                ->expression($builder->expr()
                    ->field('generatorId')
                    ->expression('$generatorId')
//                    ->field('year')
//                    ->year('$dateFrom')
                    ->field('hour')
                    ->hour('$dateFrom')
                )
            ->field('power')
            ->sum('$power');

        $data = $builder->getAggregation()->getIterator()->toArray();

        $result = [];

        foreach ($data as $item) {
            $result[$item['_id']['generatorId']][$item['_id']['hour']] = $item['power'] / 1000;
        }

        return $result;
    }

    public function production($generatorId, $dateFrom, $dateTo): array
    {
        $builder = $this->dm->createQueryBuilder(Production::class);
        $builder
                ->field('dateFrom')
                ->gte($dateFrom)
                ->field('dateTo')
                ->lt($dateTo)
                ->field('generatorId')
                ->equals($generatorId);

        return $builder->getQuery()->execute()->toArray();
    }
}