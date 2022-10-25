<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_front_home')]
    public function index(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('front/main/home.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/test', name: 'app_front_hssome')]
    public function base( UserRepository $userRepository, $postRepository, CategoryRepository $categories): Response
    {

        return $this->render('base.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll(),
            'email' => $email,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/aboutMe', name: 'app_aboutMe')]
    public function aboutMe(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('front/main/aboutMe.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('front/main/contact.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }


}
