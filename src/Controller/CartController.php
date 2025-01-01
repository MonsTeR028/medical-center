<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        $panierWithData = $cartService->getCart();
        $total = 0;

        foreach ($panierWithData as $item) {
            $total += $item['quantity'] * $item['product']->getPriceUnit();
        }

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, CartService $cartService): Response
    {
        $cartService->add($id);

        return $this->redirectToRoute('app_medicine');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove($id, CartService $cartService): Response
    {
        $cartService->remove($id);

        return $this->redirectToRoute('app_cart');
    }
}
