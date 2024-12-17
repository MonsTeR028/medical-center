<?php

namespace App\Controller;

use App\Entity\Medicine;
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
        Request $request,
    ): Response {
        $search = $request->query->getString('search');
        $categoryFilter = $request->query->getInt('categoryFilter');
        $containerOnly = $request->query->getBoolean('containerOnly');
        $orderTarget = $request->query->getString('orderTarget');
        $orderBy = $request->query->getString('orderBy');

        $medicines = $medicineRepository->search($search, $categoryFilter, $orderTarget, $orderBy);

        if ($containerOnly) {
            return $this->render('medicine/_medicines.html.twig', [
                'medicines' => $medicines,
            ]);
        }

        $categories = $medicineCategoryRepository->findAllOrderedByName();

        return $this->render('medicine/index.html.twig', [
            'medicines' => $medicines,
            'search' => $search,
            'categories' => $categories,
        ]);
    }

    #[Route('/medicine/{id}',
        name: 'app_medicine_show',
        requirements: ['id' => '\d+']
    )]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Medicine $medicine,
    ): Response {
        return $this->render('medicine/show.html.twig', [
            'medicine' => $medicine,
        ]);
    }
}
