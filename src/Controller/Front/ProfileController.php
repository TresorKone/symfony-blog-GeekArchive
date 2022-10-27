<?php

namespace App\Controller\Front;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_front_profile')]
    public function profileShow(): Response
    {
        return $this->render('front/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profile-form', name: 'app_front_profile')]
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
            $userProfile = $form->getData();
            $profile->setBirthDate(
                $form->get('birthDate')->getData()
            );
            $user->$profile($profile);

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
}
