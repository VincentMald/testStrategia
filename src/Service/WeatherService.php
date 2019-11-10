<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Meteo;
use Symfony\Component\Config\Definition\Exception\Exception;

class WeatherService
{
    private $client;
    private $apiKey1;
    private $apiKey2;
    private $ville;
    private $lng;
    private $lat;

    public function __construct($ville)
    {
        $this->client = HttpClient::create();
        $this->apiKey1 = getenv('OPENCAGE_DATA_API_KEY');
        $this->apiKey2 = getenv('DARK_SKY_API_KEY');
        $this->ville = $ville;
    }
 
    public function setVille($ville){
        $this->ville = $ville;
    }

    //results -> 1er element du tableau geometry : lat, lng
    public function getGeo()
    {
            $response = $this->client->request('GET','https://api.opencagedata.com/geocode/v1/json?q='.$this->ville.'&key='.$this->apiKey1);
            $response_decoded = json_decode($response->getContent());
            if(count($response_decoded->{'results'})<1){
                throw new Exception('La ville '.$this->ville.' n\'existe pas!');
            }
            dump("throw");
            $geo = $response_decoded->{'results'}[0]->{'geometry'};
            $this->lat = $geo->{'lat'};
            $this->lng = $geo->{'lng'};
            return $this->getWeather();
    }
    
    /**
     * @return object 
     */
    public function getWeather()
    {
        $response = $this->client->request('GET', 'https://api.darksky.net/forecast/' . $this->apiKey2 .'/'. $this->lat.','.$this->lng);
        $response_decoded_currently = json_decode($response->getContent())->{'currently'};
        $meteo = new Meteo(
            $this->ville,
            $response_decoded_currently->{'time'},
            $response_decoded_currently->{'humidity'},
            $windSpeed = $response_decoded_currently->{'windSpeed'},
            $temperature = $response_decoded_currently->{'temperature'}
        ); 
        return $meteo;
    }

    
}
