<?php

namespace App\Controller\Front;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_front_home')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('front/main/index.html.twig', [
            'postRepository' => $postRepository->findAll(),
        ]);
    }
}
