<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\User;
use App\Form\AdresseUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdresseController extends AbstractController
{
    #[Route('/adresse', name: 'app_adresse')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('adresse/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/adresse/create', name: 'app_adresse_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $address = new Adresse();
        $address->setUser($user);

        $form = $this->createForm(AdresseUserType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($address);
            $entityManager->flush();

            $this->addFlash('success', 'Adresse ajoutée avec succès.');

            return $this->redirectToRoute('app_adresse');
        }

        return $this->render('adresse/_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/adresse/{id}/delete', name: 'app_adresse_delete')]
    public function delete(Adresse $adresse, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $entityManager->remove($adresse);
        $entityManager->flush();

        $this->addFlash('success', 'Adresse supprimée avec succès.');

        return $this->render('adresse/index.html.twig', [
            'user' => $user,
        ]);
    }
}
