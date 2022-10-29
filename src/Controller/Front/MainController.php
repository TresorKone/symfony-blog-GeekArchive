<?php

namespace App\Controller\Front;

use App\Entity\Contact;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_front_home')]
    public function index(PostRepository $postRepository, CategoryRepository $categories): Response
    {
        return $this->render('front/main/home.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll(),
        ]);
    }


    public function base($postRepository, CategoryRepository $categories,): Response
    {

        return $this->render('base.html.twig', [
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll(),

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
    public function contact(PostRepository $postRepository, CategoryRepository $categories, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ContactType::class, new Contact());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $contact->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Thanks for your message');

            return $this->redirectToRoute('app_front_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/main/contact.html.twig', [
            'form' => $form->createView(),
            'postRepository' => $postRepository->findAll(),
            'categories' => $categories->findAll()
        ]);
    }


}
