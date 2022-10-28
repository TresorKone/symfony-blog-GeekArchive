<?php

namespace App\Controller\Front;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\CategoryRepository;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profileShow(CategoryRepository $categories): Response
    {

        /**
         * @var User $currentUser
         */
        $currentUser = $this->getUser();
        $profile = $currentUser->getProfile();

        return $this->render('front/profile/index.html.twig', [
            'categories' => $categories->findAll(),
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/profile-form', name: 'app_form_profile')]
    public function profileForm(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categories): Response
    {


        /**
         * @var User $user
         */
        $user = $this->getUser();
        $profile = $user->getProfile() ?? new Profile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {

            $profile = $form->getData();

            $user->setProfile($profile);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'changes saved.'
            );

            return $this->redirectToRoute('app_front_home');
        }

        return $this->render('front/profile/partials/_profile_form.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories->findAll(),
        ]);
    }

    #[Route('/profile-settings', name: 'app_settings_profile')]
    public function profileSettings(CategoryRepository $categories, Request $request, EntityManagerInterface $entityManager): Response
    {

        /**
         * @var User $user
         */
        $user = $this->getUser();
        $profile = $user->getProfile() ?? new Profile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {

            $profile = $form->getData();

            $user->setProfile($profile);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'changes saved.'
            );

            return $this->redirectToRoute('app_front_home');
        }

        return $this->render('front/profile/profile.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories->findAll(),

        ]);

    }
}
