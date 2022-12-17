<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function getWeather(): Response
    {
        $apiUri = 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true&timezone=auto';
        $apiJson = json_decode(file_get_contents($apiUri));
        
        //dd($apiJson);
        return $this->render('home/index.html.twig', [
            'weather' => $apiJson,
        ]);
    }
    
}
