<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/back/login', name: 'app_back_login')]
    public function index(AuthenticationUtils $utils): Response
    {

        $lastUsername = $utils->getLastUsername();
        $error = $utils -> getLastAuthenticationError();

        return $this->render('back/login/index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }
}
