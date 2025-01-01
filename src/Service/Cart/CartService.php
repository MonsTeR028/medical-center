<?php

namespace App\Service\Cart;

class CartService
{
    public function add(int $id): void
    {
        $cart = $session->get('cart', []);
        if (isset($cart[$id])) {
            ++$cart[$id];
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
    }

    public function remove(int $id): void
    {
    }

    public function getCart(): array
    {
    }

    public function getTotal(): int
    {
    }
}
