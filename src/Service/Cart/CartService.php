<?php

namespace App\Service\Cart;

use App\Repository\BatchMedicineRepository;
use App\Repository\MedicineRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected SessionInterface $session;
    protected MedicineRepository $medicineRepository;
    protected BatchMedicineRepository $batchMedicineRepository;

    public function __construct(RequestStack $request,
        MedicineRepository $medicineRepository,
        BatchMedicineRepository $batchMedicineRepository
    )
    {
        $this->session = $request->getSession();
        $this->medicineRepository = $medicineRepository;
        $this->batchMedicineRepository = $batchMedicineRepository;
    }

    public function add(int $id): void
    {
        $cart = $this->session->get('cart', []);
        $stock = $this->batchMedicineRepository->findAllQuantityById($this->medicineRepository->find($id));
        if (isset($cart[$id])) {
            if ($cart[$id] < $stock) {
                ++$cart[$id];
            }
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

    public function decrease(int $id): void
    {
        $cart = $this->session->get('cart', []);
        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                --$cart[$id];
                $this->session->set('cart', $cart);
            } else {
                $this->remove($id);
            }
        }
    }

    public function increase(int $id): void
    {
        $this->add($id);
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

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getCart() as $item) {
            $total += $item['quantity'] * $item['product']->getPriceUnit();
        }

        return $total;
    }
}
