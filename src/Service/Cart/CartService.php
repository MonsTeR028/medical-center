<?php

namespace App\Service\Cart;

use App\Repository\MedicineRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected SessionInterface $session;
    protected MedicineRepository $medicineRepository;
    public function __construct(RequestStack $request, MedicineRepository $medicineRepository)
    {
        $this->session = $request->getSession();
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
        $cart = $this->session->get('cart', []);
        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->medicineRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        return $cartWithData;
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
