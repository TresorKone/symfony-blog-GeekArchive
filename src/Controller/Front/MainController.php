<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_front_home')]
    public function index(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('front/main/index.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }


    public function base(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('base.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }
}
