<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $orders = $orderRepository->findOrdersByUserId($user->getId());

        return $this->render('order/index.html.twig', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    #[Route('/order/{id}',
        name: 'app_order_show',
        requirements: ['id' => '\d+']),]
    public function show(OrderItemRepository $orderItemRepository, int $id, OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $orderItems = $orderItemRepository->findOrderItemsByOrderId($id);
        $order = $orderRepository->find($id);
        $data = [];

        foreach ($orderItems as $item) {
            $data[] = [
                'quantity' => $item['quantity'],
                'medicine' => $item[0]->getIdBatchMedicine()->getIdMed(),
            ];
        }

        return $this->render('order/show.html.twig', [
            'orderItems' => $orderItems,
            'data' => $data,
            'order' => $order,
        ]);
    }
}
