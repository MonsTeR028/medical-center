<?php

namespace App\Controller;

use App\Entity\Adresse;
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
        OrderItemRepository $orderItemRepository,
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

        $order = '';
        if ($request->request->get('tour')) {
            $tour = $request->request->get('tour');
        } else {
            $tour = 0;
        }
        $itemInfos = [];
        $itemsData = [];
        $allRequest = $request->request->all();
        dump($allRequest);

        foreach ($cart as $item) {
            $productId = $item['product']->getId();
            if (!$request->request->has("item-$productId")) {
                continue;
            }
            $itemInfos[] = [
                'id' => "item-{$productId}",
                'data' => $request->request->get("item-{$productId}"),
            ];
        }

        if ($request->request->get('adresse') || $request->request->get('adresse_user')) {
            $order = new Order();
            $order->setIdUser($user);
            $order->setStatus('DELIVERED');
            $order->setOrderDate(new \DateTime());
            $amount = 0;
            if (1 == $tour) {
                ++$tour;
            }
            ++$tour;

            foreach ($cart as $item) {
                $productId = $item['product']->getId();
                if (!$request->request->has("item-$productId")) {
                    continue;
                }
                $quantity = $item['quantity'];
                $orderItem = new OrderItem();
                $batchMedicine = $batchMedicineRepository->findOneBy(['idMed' => $productId]);
                $orderItem->setIdBatchMedicine($batchMedicine);
                $orderItem->setIdOrder($order->getId());
                $orderItem->setQuantity($quantity);
                $newAdresseInfos = $request->request->get('adresse_user');
                $amount += $item['product']->getPriceUnit() * $quantity;
                $order->addOrderItem($orderItem);
                $itemsData[] = [
                    'name' => $item['product']->getName(),
                    'quantity' => $quantity,
                ];
                /*
                $cartService->remove($productId);
                */
                if ($request->request->get('adresse')) {
                    $order->setDeliveryAdresse($adresseRepository->find($request->request->get('adresse')));
                } else {
                    if ($adresseRepository->find(true === $newAdresseInfos['id'])) {
                        $order->setDeliveryAdresse($adresseRepository->find($newAdresseInfos['id']));
                    } else {
                        dump($newAdresseInfos);
                        $newAdresse = new Adresse();
                        $newAdresse->setId($newAdresseInfos['id']);
                        $newAdresse->setAdresse($newAdresseInfos['adresse']);
                        $newAdresse->setZipcode($newAdresseInfos['zipcode']);
                        $newAdresse->setCity($newAdresseInfos['city']);
                        if ($newAdresseInfos['firstname'] && $newAdresseInfos['lastname']) {
                            $newAdresse->setFirstname($newAdresseInfos['firstname']);
                            $newAdresse->setLastname($newAdresseInfos['lastname']);
                        }
                        if ($newAdresseInfos['tel']) {
                            $newAdresse->setTel($newAdresseInfos['tel']);
                        }
                        $newAdresse->setUser($user);
                        $order->setDeliveryAdresse($newAdresse);
                        if (3 == $tour) {
                            $entityManager->persist($newAdresse);
                        }
                    }
                }
                $order->setTotalAmount($amount);
            }
            if (3 == $tour) {
                $entityManager->persist($order);
                $entityManager->flush();
            }
        }
        dump($tour);
        $adresses = $adresseRepository->findBy(['user' => $user]);
        $formAdress = $this->createForm(AdresseUserType::class);

        return $this->render('order/new.html.twig', [
            'user' => $user,
            'adresses' => $adresses,
            'formAdress' => $formAdress->createView(),
            'order' => $order,
            'itemInfo' => $itemInfos,
            'itemData' => $itemsData,
            'tour' => $tour,
            'choiceAdresse' => $request->request->get('adresse'),
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
