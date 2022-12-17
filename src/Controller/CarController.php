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
        $apiUri = 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true&timezone=auto';
        $apiJson = json_decode(file_get_contents($apiUri));
        
        //dd($apiJson);
        return $this->render('home/index.html.twig', [
            'weather' => $apiJson,
        ]);
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
