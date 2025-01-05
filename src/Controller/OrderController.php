<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class OrderController extends AbstractController
{
    #[Route('/order/create', name: 'app_order_index')]
    public function index(CartService $cartService): Response
    {
        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        return $this->render('order/index.html.twig', [
            'form' => $form,
            'cartRecap' => $cartService->getTotal(),
        ]);
    }
}
