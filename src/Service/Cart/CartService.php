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
    }

    public function getTotal(): int
    {
    }
}
