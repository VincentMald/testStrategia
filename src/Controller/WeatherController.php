<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;

class WeatherController extends AbstractController
{
    private $wheatherService;
    private $ville = 'TOULOUSE';

    public function __construct(WeatherService $wheatherService)
    {
        $this->wheatherService = new $wheatherService($this->ville);
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if(isset($_GET['ville'])){
            $this->wheatherService->setVille($_GET['ville']);
        }

        try {
            $meteo = $this->wheatherService->getGeo();
            $render = $this->render('weather/index.html.twig', array(
                'meteo' => $meteo
            ));
        } catch (\Exception $e) {
            $render = $this->render('weather/index.html.twig', array(
                'error' => $e->getMessage()
            ));
        }
        return $render;
    }

    /**
     * @Route("/apropos", name="apropos")
     */
    public function apropos()
    {
        return $this->render('weather/apropos.html.twig');
    }

    /**
     * @Route("/recherches", name="recherches")
     */
    public function recherches()
    {
        return $this->render('weather/recherches.html.twig', array(
            'title' => 'test'
        ));
    }

}
