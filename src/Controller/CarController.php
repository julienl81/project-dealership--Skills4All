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
    #[Route('/', name: 'app_car')]
    public function home(): Response
    {
        return $this->render('car/index.html.twig');
    }

    #[Route('/car/{carCategory}', name: 'app_car_category')]
    public function carCategory($carCategory, CarRepository $carRepository, CarCategoryRepository $carCategorieRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if ($carCategory != 'all') {
            $carCategoryId = $carCategorieRepository->findOneBy(['name' => $carCategory]);
            $cars = $carRepository->findByCarCategory($carCategoryId);
        } else {
            $cars = $carRepository->findAll();
        }
        
        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('car_category/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorieRepository->findAll(),
        ]);
    }
}
