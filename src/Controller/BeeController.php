<?php

namespace App\Controller;

use App\Service\BeeNormalizer;
use App\Service\BeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BeeController extends AbstractController
{
    private $beeService;

    public function __construct(BeeService $beeService)
    {
        $this->beeService = $beeService;
    }

    #[Route('/', name: 'app_new_game')]
    public function newBeeGame(): Response
    {
        $hive = $this->beeService->createHive();
        $bees = $this->beeService->saveHiveState($hive);

        return $this->redirectToRoute('app_hit_bee');
    }

    #[Route('/hit', name: 'app_hit_bee')]
    public function displayHive(Request $request, BeeNormalizer $beeNormalizer): Response
    {
        $bees = $this->beeService->getHiveState();
        if (empty($bees))
            return $this->redirectToRoute('app_new_game');

        $form = $this->createFormBuilder()
            ->add('save', SubmitType::class, ['label' => 'Hit random bee'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->beeService->hitABee($bees);

            return $this->redirectToRoute('app_hit_bee');
        }

        $bees = $beeNormalizer->normalizeHive($bees);

        return $this->renderForm('bee/hit.html.twig', [
                'bees' => $bees,
                'form' => $form,
        ]);
    }
}
