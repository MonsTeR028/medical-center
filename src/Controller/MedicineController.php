<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MedicineController extends AbstractController
{
    #[Route('/medicine', name: 'app_medicine')]
    public function index(): Response
    {
        // TODO: Implement index() method. List all medicines, pagination, search, filter by category, sort by, ...
        return $this->render('medicine/index.html.twig');
    }

    #[Route('/medicine/{id}',
        name: 'app_medicine_show',
        requirements: ['id' => '\d+']
    )]
    public function show(): Response
    {
        // TODO: Implement show() method. Show detail of a specific medicine by ID
        return $this->render('medicine/show.html.twig');
    }
}
