<?php

namespace App\Controller;

use App\Service\HiveNormalizer;
use App\Service\HiveRepository;
use App\Service\HiveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeeController extends AbstractController
{
    public function __construct(
        private readonly HiveService $hiveService,
        private readonly HiveRepository $hiveRepository
    )
    {}

    #[Route('/', name: 'app_new_game')]
    public function newBeeGame(): Response
    {
        $hive = $this->hiveService->createHive();
        $this->hiveRepository->storeNewHive($hive);

        return $this->redirectToRoute('app_hit_bee');
    }

    #[Route('/hit', name: 'app_hit_bee')]
    public function displayHive(Request $request, HiveNormalizer $hiveNormalizer): Response
    {
        $hive = $this->hiveRepository->getHiveState();
        if (empty($hive[0])) {
            return $this->redirectToRoute('app_new_game');
        }

        $form = $this->createFormBuilder()
            ->add('save', SubmitType::class, ['label' => 'Hit random bee'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newHiveState = $this->hiveService->hitABee($hive[0], $hive[1]);
            $this->hiveRepository->saveHiveState($newHiveState[0], $newHiveState[1]);

            return $this->redirectToRoute('app_hit_bee');
        }

        $hive = $hiveNormalizer->normalizeHive($hive[0]);

        return $this->renderForm('bee/hit.html.twig', [
                'hive' => $hive,
                'form' => $form,
        ]);
    }
}
