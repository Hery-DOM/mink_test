<?php

namespace App\Controller\BackOffice\Animal;

use App\Entity\Animal;
use App\Entity\Pictures;
use App\Repository\AnimalRepository;
use App\Repository\PicturesRepository;
use App\Services\FileService;
use App\Services\SecureInputService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin")]
#[IsGranted("ROLE_ADMIN")]
class PicturesController extends AbstractController
{
    #[Route("/{id}/pictures", name: "admin_animal_pictures_list")]
    public function index($id, AnimalRepository $animalRepository,SecureInputService $secureInputService)
    {
        /**
         * @var Animal $animal
         */
        [$id,$animal] = $secureInputService->secureAndFind($id,$animalRepository);

        return $this->render("back-office/animal/pictures_list.html.twig",[
            "animal" => $animal
        ]);
    }


    #[Route("/{id}/pictures/add", name: "admin_animal_pictures_add")]
    public function savePictures($id, AnimalRepository $animalRepository,SecureInputService $secureInputService,FileService $fileService,
    EntityManagerInterface $entityManager)
    {
        /**
         * @var Animal $animal
         */
        [$id,$animal] = $secureInputService->secureAndFind($id,$animalRepository);

        /** Save pictures **/
        $result = $fileService->saveFile($animal);

        if(!$result[0]){
            $this->addFlash("error",$result[1]);
        }

        /** Add entities Pictures **/
        $this->createEntitiesPictures($animal,$entityManager,$result[1]);
        $this->addFlash("success","Les images ont été enregistrées");

        return $this->redirectToRoute("admin_animal_pictures_list",[
            "id" => $id
        ]);


    }



    #[Route("/{idPicture}/picture/remove", name: "admin_animal_pictures_remove")]
    public function removePicture($idPicture,PicturesRepository $picturesRepository, FileService $fileService, SecureInputService $secureInputService, EntityManagerInterface $entityManager)
    {
        /**
         * @var Pictures $picture
         */
        [$idPicture,$picture] = $secureInputService->secureAndFind($idPicture,$picturesRepository);
        $id = $picture->getAnimal()->getId();

        $dir = $this->getParameter("animal_media")."/animal-".$id;
        $fileService->removeFile($dir."/".$picture->getName());
        $fileService->removeFile($dir."/mini-".$picture->getName());
        $fileService->removeFile($dir."/".$picture->getNameWebp());
        $fileService->removeFile($dir."/mini-".$picture->getNameWebp());

        $entityManager->remove($picture);
        $entityManager->flush();

        $this->addFlash("success","Image supprimée");

        return $this->redirectToRoute("admin_animal_pictures_list",[
            "id" => $id
        ]);

    }




    private function createEntitiesPictures(Animal $animal, EntityManagerInterface $entityManager,array $newNames): void
    {

        foreach($newNames as $n){
            $picture = (new Pictures())
                ->setAnimal($animal)
                ->setName($n)
                ->setAlt($animal->getName())
            ;
            $entityManager->persist($picture);
        }
        $entityManager->flush();

    }
}