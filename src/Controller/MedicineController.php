<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Entity\User;
use App\Form\PurchaseQuantityType;
use App\Repository\BatchMedicineRepository;
use App\Repository\MedicineCategoryRepository;
use App\Repository\MedicineRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MedicineController extends AbstractController
{
    #[Route('/medicines', name: 'app_medicine')]
    public function index(
        MedicineRepository $medicineRepository,
        MedicineCategoryRepository $medicineCategoryRepository,
        BatchMedicineRepository $batchMedicineRepository,
        Request $request,
    ): Response {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $search = $request->query->getString('search');
        $categoryFilter = $request->query->getInt('categoryFilter');
        $containerOnly = $request->query->getBoolean('containerOnly');
        $orderTarget = $request->query->getString('orderTarget');
        $orderBy = $request->query->getString('orderBy');

        $medicines = $medicineRepository->search($search, $categoryFilter, $orderTarget, $orderBy);

        $batchMedicines = [];
        $batchMedicinesArrival = [];
        foreach ($medicines as $medicine) {
            $batchMedicines[$medicine->getId()] = $batchMedicineRepository->findAllQuantityById($medicine->getId());
            $date = strtotime($batchMedicineRepository->findArrivalDateById($medicine->getId()));
            $batchMedicinesArrival[$medicine->getId()] = date('Y-m-d', $date);
        }

        if ($containerOnly) {
            return $this->render('medicine/_medicines.html.twig', [
                'medicines' => $medicines,
                'batchMedecines' => $batchMedicines,
            ]);
        }

        $categories = $medicineCategoryRepository->findAllOrderedByName();

        $formOrderQuantity = $this->createForm(PurchaseQuantityType::class);
        $formOrderQuantity->handleRequest($request);
        if ($formOrderQuantity->isSubmitted() && $formOrderQuantity->isValid()) {
            dump($formOrderQuantity->get('id')->getData());

            return $formOrderQuantity->get('cart')->isClicked()
            ? $this->redirectToRoute(
                'app_cart_add_quantity', [
                    'id' => $formOrderQuantity->get('id')->getData(),
                    'nb' => $formOrderQuantity->get('quantity')->getData(),
                ]
            )
            : $this->redirectToRoute('app_order');
        }

        return $this->render('medicine/index.html.twig', [
            'user' => $user,
            'medicines' => $medicines,
            'search' => $search,
            'categories' => $categories,
            'batchMedecines' => $batchMedicines,
            'arrivalDate' => $batchMedicinesArrival,
            'currentDate' => date('Y-m-d', strtotime('-2 week', time())),
            'formQuantity' => $formOrderQuantity->createView(),
        ]);
    }

    #[Route('/medicine/{id}',
        name: 'app_medicine_show',
        requirements: ['id' => '\d+']
    )]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Medicine $medicine,
        BatchMedicineRepository $batchMedicineRepository,
        Request $request,
    ): Response {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $formOrderQuantity = $this->createForm(PurchaseQuantityType::class);
        $formOrderQuantity->handleRequest($request);
        if ($formOrderQuantity->isSubmitted() && $formOrderQuantity->isValid()) {
            dump($formOrderQuantity->get('id')->getData());

            return $formOrderQuantity->get('cart')->isClicked()
                ? $this->redirectToRoute(
                    'app_cart_add_quantity', [
                        'id' => $formOrderQuantity->get('id')->getData(),
                        'nb' => $formOrderQuantity->get('quantity')->getData(),
                    ]
                )
                : $this->redirectToRoute('app_order');
        }

        return $this->render('medicine/show.html.twig', [
            'user' => $user,
            'medicine' => $medicine,
            'stock' => $batchMedicineRepository->findAllQuantityById($medicine->getId()),
            'formQuantity' => $formOrderQuantity->createView(),
        ]);
    }
}
