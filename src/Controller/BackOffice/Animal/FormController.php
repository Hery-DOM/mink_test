<?php

namespace App\Controller\BackOffice\Animal;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use App\Services\SecureInputService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin/animal")]
#[IsGranted("ROLE_ADMIN")]
class FormController extends AbstractController
{
    #[Route("/create", name: "admin_animal_create")]
    #[Route("/update/{id}", name: "admin_animal_update")]
    public function create(
        SecureInputService $secureInputService,
        AnimalRepository $animalRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        $id=null
    )
    {
        if(is_null($id)){
            $h1 = "Ajout d'un animal";
            $animal = new Animal();
            $backError = $this->redirectToRoute("admin_animal_create");
        }else{
            $h1 = "Mise à jour d'un animal";
            /**
             * @var Animal $animal
             */
            [$id,$animal] = $secureInputService->secureAndFind($id,$animalRepository);
            $backError = $this->redirectToRoute("admin_animal_update",[
                "id" => $id
            ]);
        }

        $form = $this->createForm(AnimalType::class,$animal);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->addFlash("success","Animal enregistré");
                $entityManager->persist($animal);
                $entityManager->flush();
                return $this->redirectToRoute("admin_animal_list");
            }else{
                $this->addFlash("error","Erreur : veuillez recommencer");
                return $backError;
            }
        }

        return $this->render("back-office/animal/form.html.twig",[
            "form" => $form->createView(),
            "h1" => $h1
        ]);

    }
}