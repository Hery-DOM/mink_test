<?php

namespace App\Controller\FrontOffice\Animal;

use App\Repository\AnimalRepository;
use App\Repository\BreedRepository;
use App\Repository\TypeRepository;
use App\Services\SecureInputService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    const MAX_RESULT = 10;

    #[Route('/animaux', name: "animal_list")]
    public function index(AnimalRepository $animalRepository,SecureInputService $secureInputService, TypeRepository $typeRepository, BreedRepository $breedRepository): Response
    {

        $params = $secureInputService->secureArray($_GET);

        $animals = $animalRepository->findPublishedByPage($params,self::MAX_RESULT);

        return $this->render('front-office/animals/list/index.html.twig',[
            "animals" => $animals,
            "pagesTot" => ceil(count($animalRepository->findPublished($params))/self::MAX_RESULT),
            "currentPage" => isset($params["p"]) ? intval($params["p"]) : 1,
            "filters" => [
                "type" => $typeRepository->findAll(),
                "breed" => $breedRepository->findAll()
            ]
        ]);
    }
}