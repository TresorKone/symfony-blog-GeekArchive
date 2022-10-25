<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_front_login')]
    public function login(AuthenticationUtils $utils, CategoryRepository $categories): Response
    {

        $lastUsername = $utils->getLastUsername();
        $error = $utils -> getLastAuthenticationError();

        return $this->render('front/login/index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/logout', name: 'app_front_logout')]
    public function logout()
    {

    }
}
