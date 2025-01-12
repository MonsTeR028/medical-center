<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserType;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $orders = $orderRepository->findActiveOrdersByUserId($user->getId());
        $data = [];

        foreach ($orders as $order) {
            $orderItems = $orderItemRepository->findOrderItemsByOrderId($order->getId());
            foreach ($orderItems as $item) {
                $data[$order->getId()][] = [
                    'quantity' => $item['quantity'],
                    'medicine' => $item[0]->getIdBatchMedicine()->getIdMed(),
                ];
            }
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'orders' => $orders,
            'data' => $data,
        ]);
    }

    #[Route('user/register', name: 'app_user_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userRepository->findOneBy(['email' => $user->getEmail()])) {
                $this->addFlash('error', 'Cet email est déjà utilisé.');

                return $this->redirectToRoute('app_user_register');
            }

            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', ['id' => $user->getId()]);
        }

        return $this->render('user/register.html.twig', ['form' => $form]);
    }

    #[Route('/user/change_password', name: 'app_user_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('warning', 'Le mot de passe actuel est incorrect.');

                return $this->redirectToRoute('app_user_change_password');
            }

            $newPassword = $form->get('newPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');

            return $this->redirectToRoute('app_user',
                ['popup' => ['message' => 'Votre mot de passe a été changé avec succès.']]);
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
