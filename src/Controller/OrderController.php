<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\Cart\CartService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class OrderController extends AbstractController
{
    #[Route('/order/create', name: 'app_order_index')]
    public function index(LoggerInterface $logger): Response
    {
        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        return $this->render('order/index.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/order/prepare', name: 'app_order_prepare', methods: ['POST'])]
    public function prepareOrder(Request $request, CartService $cartService, LoggerInterface $logger): Response
    {
        $logger->info('tesy');
        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);
        $form->handleRequest($request);
        dd($form);
        /*
        if ($form->isSubmitted() && $form->isValid()) {
            $dateTime = new \DateTime();
            $transporter = $form->get('transporters')->getData();
            $order = new Order();
            $order->setIdUser($this->getUser()->getId());
            $order->setOrderDate($dateTime);
            $order->setStatus('IN PROGRESS');
            $order->setTotalAmount($cartService->getTotal() + $transporter->getPrice());
        }
        */
        return $this->render('order/prepare.html.twig', []);

    }
}
