<?php

namespace App\Controller\BackOffice\Animal;

use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin/animal")]
#[IsGranted("ROLE_ADMIN")]
class ListController extends AbstractController
{
    #[Route("/list", name: "admin_animal_list")]
    public function list(AnimalRepository $animalRepository)
    {
        $animals = $animalRepository->findAll();

        return $this->render("back-office/animal/list.html.twig",[
            "animals" => $animals
        ]);
    }
}