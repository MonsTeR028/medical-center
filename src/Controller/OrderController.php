<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Form\AdresseUserType;
use App\Repository\AdresseRepository;
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
    public function index(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $orders = $user->getOrders();
        $data = [];

        foreach ($orders as $order) {
            $orderItems = $orderItemRepository->findOrderItemsByOrderId($order->getId());
            foreach ($orderItems as $item) {
                $data[$order->getId()][] = [
                    'quantity' => $item['quantity'],
                    'medicine' => $item[0]->getIdBatchMedicine()->getIdMed(),
                ];
            }
        }

        return $this->render('order/index.html.twig', [
            'user' => $user,
            'orders' => $orders,
            'data' => $data,
        ]);
    }

    #[Route('/order/new', name: 'app_order_new', methods: ['POST'])]
    public function new(Request $request,
        EntityManagerInterface $entityManager,
        CartService $cartService,
        BatchMedicineRepository $batchMedicineRepository,
        AdresseRepository $adresseRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        // Get Cart Items
        $cart = $cartService->getCart();
        if (empty($cart)) {
            $this->addFlash('error', 'Votre panier est vide.');

            return $this->redirectToRoute('app_cart');
        }

        // Create the Order
        $order = new Order();
        $order->setIdUser($user);
        $order->setStatus('CANCELED');
        $order->setOrderDate(new \DateTime());
        $amount = 0;

        $reponse = $request->request->all();
        dump($reponse);

        $adresses = $adresseRepository->findBy(['user' => $user]);
        // Formulaire à ajouter
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

        $orderId = $request->request->get('deliveryAdresse');
        if ($orderId) {
            $order->setDeliveryAdresse($adresseRepository->find($orderId));
        }
        // Mettre le contenu du formulaire adresse ici dasn le else

        // Persist and Flush
        $entityManager->persist($order);
        $entityManager->flush();

        $formAdress = $this->createForm(AdresseUserType::class);

        return $this->render('order/new.html.twig', [
            'user' => $user,
            'adresses' => $adresses,
            'formAdress' => $formAdress->createView(),
            'order' => $order,
        ]);
    }

    #[Route('/order/{id}', name: 'app_order_show', requirements: ['id' => '\d+']) ]
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
            'user' => $user,
        ]);
    }
}
