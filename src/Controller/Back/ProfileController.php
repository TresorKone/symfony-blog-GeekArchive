<?php

namespace App\Controller\Back;

use App\Entity\Profile;
use App\Form\Profile1Type;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_back_profile_index', methods: ['GET'])]
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('back/profile/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_profile_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProfileRepository $profileRepository): Response
    {
        $profile = new Profile();
        $form = $this->createForm(Profile1Type::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileRepository->save($profile, true);

            return $this->redirectToRoute('app_back_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_profile_show', methods: ['GET'])]
    public function show(Profile $profile): Response
    {
        return $this->render('back/profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Profile $profile, ProfileRepository $profileRepository): Response
    {
        $form = $this->createForm(Profile1Type::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profile->setUpdatedAt(new \DateTimeImmutable());
            $profileRepository->save($profile, true);

            return $this->redirectToRoute('app_back_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_profile_delete', methods: ['POST'])]
    public function delete(Request $request, Profile $profile, ProfileRepository $profileRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {
            $profileRepository->remove($profile, true);
        }

        return $this->redirectToRoute('app_back_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
