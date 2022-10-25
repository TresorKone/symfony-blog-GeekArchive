<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'app_display-by-category')]
    public function displayByCategory($slug, PostRepository $postRepository, CategoryRepository $categories): Response
    {

        $category = $categories->findOneBySlug($slug);

        $posts = [];
        if($category){
            $posts = $category->getPosts()->getValues();
        }

        //dd($posts);

        return $this->render('front/category/index.html.twig', [
            'postRepository'=> $postRepository,
            'posts' => $posts,
            'categories' => $categories->findAll(),
            'category' => $category
        ]);
    }
}
