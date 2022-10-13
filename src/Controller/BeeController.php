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

    #[Route('/bee', name: 'app_bee_new')]
    public function newBeeGame(): Response
    {
        $bees = $this->beeService->createHive();
        return $this->render('bee/index.html.twig', [
            'bees' => $bees,
        ]);
    }
}
