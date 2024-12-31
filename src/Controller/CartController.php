<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        if (isset($cart[$id])) {
            ++$cart[$id];
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        dd($cart);
    }
}
