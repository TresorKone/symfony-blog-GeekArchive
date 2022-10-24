<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTimeImmutable;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    #[Route('/posts/add-post', name: 'app_post_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addForm(Request $request, PostRepository $postRepository, EntityManagerInterface $manager): Response
    {


        $form = $this->createForm(PostType::class, new Post());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreatedAt(new DateTimeImmutable());
            $post->setOwner($this->getUser());
            $manager->persist($post);
            $manager->flush();

            //dd($post);

            //flash message(user friendly xD)
            $this->addFlash('success', 'The world might see your post now');

            //Redirect
            return $this->redirectToRoute('app_front_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'front/post/add-post-form.html.twig', [
                'form' => $form,
            ]
        );

    }

    #[Route('/posts/{id}/edit-post', name: 'app_post_edit')]
    //#[Entity('Post', options: ['id' => 'id'])]
    public function editForm(Post $post, Request $request, PostRepository $postRepository, EntityManagerInterface $manager): Response
    {



        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $manager->persist($post);
            $manager->flush();

            //flash message(user friendly xD)
            $this->addFlash('success', 'your post have been updated now');

            //Redirect
            return $this->redirectToRoute('app_front_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'front/post/edit-post-form.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );

    }

}
