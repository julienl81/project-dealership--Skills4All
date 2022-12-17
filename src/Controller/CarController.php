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
        $cars = $carRepository->findAll();

        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }

    #[Route('/{carCategory}', name: 'app_car_category')]
    public function carCategory($carCategory, CarRepository $carRepository, CarCategoryRepository $carCategorieRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $carCategoryId = $carCategorieRepository->findOneBy(['name' => $carCategory]);
        $cars = $carRepository->findByCarCategory($carCategoryId);


        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }

    #[Route('/car/all/search', name: 'app_car_search')]
    public function search(Request $request, CarRepository $carRepository, CarCategoryRepository $carCategorieRepository): Response
    {
        //dd($request->query->get('search'));

        $carSearch = $carRepository->findBy(['name' => $request->query->get('search')]);
        //dd($carSearch);

        return $this->render('car/search.html.twig', [
            'cars' => $carSearch,
            'carCategories' => $carCategorieRepository->findAll(),
            'weather' => WeatherApi::getWeather(),
        ]);
    }
}
