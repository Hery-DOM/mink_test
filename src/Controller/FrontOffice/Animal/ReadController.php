<?php

namespace App\Controller\FrontOffice\Animal;

use App\Repository\AnimalRepository;
use App\Services\SecureInputService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ReadController extends AbstractController
{
    #[Route("/animal/{id}/{slug}", name: "animal_read")]
    public function read($id, SecureInputService $secureInputService, AnimalRepository $animalRepository)
    {
        [$id,$animal] = $secureInputService->secureAndFind($id,$animalRepository);

        if(!$animal){
            return $this->redirectToRoute("animal_list");
        }

        return $this->render("front-office/animals/read/index.html.twig",[
            "animal" => $animal
        ]);

    }

}