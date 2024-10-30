<?php

namespace App\Controller\BackOffice\Animal;

use App\Repository\AnimalRepository;
use App\Services\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin")]
#[IsGranted("ROLE_ADMIN")]
class DeleteController extends AbstractController
{
    #[Route("/{id}/delete", name: "admin_animal_delete", methods: ["POST"])]
    public function delete($id,AnimalRepository $animalRepository,EntityManagerInterface $entityManager,FileService $fileService)
    {
        $entityManager->remove($animalRepository->find($id));
        $fileService->removeFile($this->getParameter("animal_media")."/animal-".$id);
        $entityManager->flush();

        $this->addFlash("success","Animal supprimé");
        return $this->redirectToRoute("admin_animal_list");
    }
}