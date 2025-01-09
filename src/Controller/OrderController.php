<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Repository\BatchMedicineRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/order/new', name: 'app_order_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CartService $cartService, BatchMedicineRepository $batchMedicineRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        // Create the Order
        $order = new Order();
        $order->setIdUser($user);
        $order->setStatus('RECEIVED');
        $order->setOrderDate(new \DateTime());

        // Get Cart Items
        $cart = $cartService->getCart();
        if (empty($cart)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_cart');
        }

        $amount = 0;

        // Add Order Items
        foreach ($cart as $item) {
            $productId = $item['product']->getId();
            if (!$request->request->has("item-$productId")) {
                continue;
            }
            $orderItem = new OrderItem();
            $batchMedicine = $batchMedicineRepository->findOneBy(['idMed' => $item['product']]);
            $orderItem->setIdBatchMedicine($batchMedicine);
            $orderItem->setQuantity($item['quantity']);

            $amount += $item['product']->getPriceUnit() * $item['quantity'];
            $order->addOrderItem($orderItem);
            $cartService->remove($productId);
        }

        $order->setTotalAmount($amount);

        // Persist and Flush
        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash('success', 'Votre commande a été passée avec succès.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/order/{id}',
        name: 'app_order_show',
        requirements: ['id' => '\d+']), ]
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
