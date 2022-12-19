<?php

namespace App\Controller;

use App\Models\WeatherApi;
use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/', name: 'app_car_list')]
    public function carList(CarRepository $carRepository, CarCategoryRepository $carCategorieRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //get all cars from repository
        $cars = $carRepository->findAll();

        // give all cars to the paginator, and paginate them by 20 per page
        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        // Send cars paginated, car categories and weather to the view
        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }

    #[Route('/{carCategory}', name: 'app_car_category')]
    public function carCategory($carCategory, CarRepository $carRepository, CarCategoryRepository $carCategorieRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // I get the car category id from the car category name receive in GET
        $carCategoryId = $carCategorieRepository->findOneBy(['name' => $carCategory]);
        // Search car by car category id
        $cars = $carRepository->findByCarCategory($carCategoryId);

        // give cars filtered to the paginator, and paginate them by 20 per page
        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        // Send cars paginated, car categories and weather to the view
        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }

    #[Route('/car/all/search', name: 'app_car_search')]
    public function search(Request $request, CarRepository $carRepository, CarCategoryRepository $carCategorieRepository): Response
    {
        // Search car with the name from search box receive in GET
        $carSearch = $carRepository->findBy(['name' => $request->query->get('search')]);

        // Send cars results, car categories and weather to the view
        return $this->render('car/search.html.twig', [
            'cars' => $carSearch,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }
}
