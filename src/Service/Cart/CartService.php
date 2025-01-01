<?php

namespace App\Service\Cart;

use App\Repository\MedicineRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected SessionInterface $session;
    protected MedicineRepository $medicineRepository;
    public function __construct(SessionInterface $session, MedicineRepository $medicineRepository)
    {
        $this->session = $session;
        $this->medicineRepository = $medicineRepository;
    }
    public function add(int $id): void
    {
        $cart = $this->session->get('cart', []);
        if (isset($cart[$id])) {
            ++$cart[$id];
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function remove(int $id): void
    {
        $cart = $this->session->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }

    public function getCart(): array
    {
        $panier = $this->session->get('cart', []);
        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->medicineRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        return $panierWithData;
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->getCart() as $item) {
            $total += $item['quantity'] * $item['product']->getPriceUnit();
        }
        return $total;
    }
}
