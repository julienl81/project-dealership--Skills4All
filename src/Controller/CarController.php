<?php

namespace App\Controller;

use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $carRepository, CarCategoryRepository $carCategorie, PaginatorInterface $paginator, Request $request): Response
    {

        $cars = $carRepository->findAll();
        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorie->findAll(),
        ]);
    }
}
