<?php

namespace App\Controller;

use App\Service\BeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BeeController extends AbstractController
{
    private $beeService;

    public function __construct(BeeService $beeService)
    {
        $this->beeService = $beeService;
    }

    #[Route('/bee/new', name: 'app_bee_new')]
    public function newBeeGame(): Response
    {
        $hive = $this->beeService->createHive();
        $bees = $this->beeService->saveHiveState($hive);

        return $this->redirectToRoute('app_bee_hive');
    }

    #[Route('/bee/hit', name: 'app_bee_hit')]
    public function hitBee(): Response
    {
        return new Response;
    }

    #[Route('/bee/hive', name: 'app_bee_hive')]
    public function displayHive(): Response
    {
        $bees = $this->beeService->getHiveState();

        return $this->render('bee/index.html.twig', [
            'bees' => $bees,
        ]);
    }
}
