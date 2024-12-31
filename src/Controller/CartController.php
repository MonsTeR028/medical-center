<?php

namespace App\Controller;

use App\Repository\MedicineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, MedicineRepository $medicineRepository): Response
    {
        $panier = $session->get('cart', []);
        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $medicineRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        $total = 0;

        foreach ($panierWithData as $item) {
            $total += $item['quantity'] * $item['product']['price'];
        }

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, SessionInterface $session): Response
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
