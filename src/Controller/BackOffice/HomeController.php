<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/admin")]
#[IsGranted("ROLE_ADMIN")]
class HomeController extends AbstractController
{
    #[Route("/", name: "admin_home")]
    public function index()
    {
        return $this->render("back-office/home.html.twig");
    }
}