<?php

namespace App\Controller;

use App\Application\Command\CreateProductionCommand;
use App\Application\CommandHandler\CreateProductionHandler;
use App\Application\QueryHandler\ReportQueryHandler;
use App\Document\Production;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductionController extends AbstractController
{
    /**
     * @Route("/production", name="production", methods={"GET"})
     */
    public function index(DocumentManager $dm): Response
    {
        $products = $dm->getRepository(Production::class)->findAll();

        if (! $products) {
            throw $this->createNotFoundException('No products found ' );
        }

        $arr = [];

        foreach ($products as $product) {
            $arr[] = [
                'generatorId' => $product->getGeneratorId(),
                'power' => $product->getPower(),
                'dateFrom' => $product->getDateFrom(),
                'dateTo' => $product->getDateTo(),
            ];
        }

        return new JsonResponse($arr);
    }

    /**
     * @Route("/production/create", methods={"POST"})
     */
    public function create(Request $request, CreateProductionHandler $handler): Response
    {
        $command = $this->get('serializer')->deserialize(
            $request->getContent(),
            CreateProductionCommand::class,
            'json'
        );

        $handler->handle($command);

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/production/dailyReport", methods={"GET"})
     */
    public function report(ReportQueryHandler $handler): JsonResponse
    {
        $data = $handler->handle();

        return new JsonResponse($data);
    }

    /**
     * @Route("/production/show/{id}", methods={"GET"})
     */
    public function show(DocumentManager $dm, $id)
    {
        $product = $dm->getRepository(Production::class)->find($id);

        if (! $product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        return new JsonResponse([
            'generatorId' => $product->getGeneratorId(),
            'power' => $product->getPower(),
            'dateFrom' => $product->getDateFrom(),
            'dateTo' => $product->getDateTo(),
        ]);
    }

}
