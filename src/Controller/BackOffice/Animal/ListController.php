<?php

namespace App\Controller\BackOffice\Animal;

use App\Repository\AnimalRepository;
use App\Services\SecureInputService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin/animal")]
#[IsGranted("ROLE_ADMIN")]
class ListController extends AbstractController
{
    const MAX_RESULT = 3;
    #[Route("/list", name: "admin_animal_list")]
    public function list(AnimalRepository $animalRepository,SecureInputService $secureInputService)
    {
        $currentPage = isset($_GET["p"]) ? intval($secureInputService->secureArray($_GET)["p"]) : 1;

        $animals = $animalRepository->findByPage($currentPage,self::MAX_RESULT);


        return $this->render("back-office/animal/list.html.twig",[
            "animals" => $animals,
            "currentPage" => $currentPage,
            "pagesTot" => ceil(count($animalRepository->findAll())/self::MAX_RESULT)
        ]);
    }
}