<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService, AdresseRepository $adresseRepository): Response
    {
        $adresses = $adresseRepository->findBy(['user' => $this->getUser()]);

        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
            'adresses' => $adresses,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', requirements: ['id' => '\d+'])]
    public function add($id, CartService $cartService): Response
    {
        $cartService->add($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', requirements: ['id' => '\d+'])]
    public function remove($id, CartService $cartService): Response
    {
        $cartService->remove($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/increase/{id}', name: 'app_cart_increase', requirements: ['id' => '\d+'])]
    public function increase($id, CartService $cartService): Response
    {
        $cartService->increase($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease', requirements: ['id' => '\d+'])]
    public function decrease($id, CartService $cartService): Response
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/quantity/{id}/{nb}', name: 'app_cart_add_quantity', requirements: ['id' => '\d+', 'nb' => '\d+'])]
    public function addQuantity(int $id, int $nb, CartService $cartService): Response
    {
        $cartService->addQuantity($id, $nb);

        return $this->redirectToRoute('app_cart');
    }
}
