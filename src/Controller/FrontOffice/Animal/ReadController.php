<?php

namespace App\Controller\FrontOffice\Animal;

use App\Repository\AnimalRepository;
use App\Services\SecureInputService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ReadController extends AbstractController
{
    #[Route("/animal/{slug}", name: "animal_read")]
    public function read($slug, SecureInputService $secureInputService, AnimalRepository $animalRepository)
    {
        $slug = $secureInputService->secureInput($slug);

        $animal = $animalRepository->findOneBy(['name' => $slug]);

        if(!$animal){
            return $this->redirectToRoute("animal_list");
        }

        return $this->render("front-office/animals/read/index.html.twig",[
            "animal" => $animal
        ]);

    }

}