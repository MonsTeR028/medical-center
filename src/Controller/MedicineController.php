<?php

namespace App\Controller;

use App\Entity\Medicine;
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
        MedicineRepository         $medicineRepository,
        MedicineCategoryRepository $medicineCategoryRepository,
        BatchMedicineRepository    $batchMedicineRepository,
        Request                    $request,
    ): Response
    {
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

        return $this->render('medicine/index.html.twig', [
            'medicines' => $medicines,
            'search' => $search,
            'categories' => $categories,
            'batchMedecines' => $batchMedicines,
            'arrivalDate' => $batchMedicinesArrival,
            'currentDate' => date('Y-m-d', strtotime('-2 week', time())),
        ]);
    }

    #[Route('/medicine/{id}',
        name: 'app_medicine_show',
        requirements: ['id' => '\d+']
    )]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Medicine                $medicine,
        BatchMedicineRepository $batchMedicineRepository,
    ): Response
    {
        return $this->render('medicine/show.html.twig', [
            'medicine' => $medicine,
            'stock' => $batchMedicineRepository->findAllQuantityById($medicine->getId()),
        ]);
    }
}
