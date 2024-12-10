<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Repository\MedicineRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class MedicineController extends AbstractController
{
    #[Route('/medicine', name: 'app_medicine')]
    public function index(
        MedicineRepository $medicineRepository,
        #[MapQueryParameter] string $search = '',
    ): Response {
        $medicines = $medicineRepository->search($search);

        return $this->render('medicine/index.html.twig', [
            'medicines' => $medicines,
            'search' => $search,
        ]);
    }

    #[Route('/medicine/{id}',
        name: 'app_medicine_show',
        requirements: ['id' => '\d+']
    )]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Medicine $medicine
    ): Response
    {
        return $this->render('medicine/show.html.twig', [
            'medicine' => $medicine
        ]);
    }
}
