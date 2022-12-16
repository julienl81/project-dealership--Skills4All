<?php

namespace App\Controller;

use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $carRepository, CarCategoryRepository $carCategorie): Response
    {
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findAll(),
            'carCategories' => $carCategorie->findAll(),
        ]);
    }
}
