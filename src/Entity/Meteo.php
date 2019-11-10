<?php 

namespace App\Entity;


//Classe Méteo permettant de transformer les données reçues de l'api Weather en objet de type Meteo.php
class Meteo {
    
    private $city;

    private $time;

    private $humidity;

    private $windSpeed;

    private $temperature;


    public function __construct($city, $time, $humidity, $windSpeed, $temperature){
        $this->city = $city;
        $this->time = $time;
        $this->humidity = $humidity;
        $this->windSpeed = $windSpeed;
        $this->temperature = $temperature;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getTimeDay()
    {
        $timeDay = date('d/m/y',$this->time);
        return $timeDay;
    }

    public function getHumidity()
    {
        return round($this->humidity,2);
    }

    public function getWindSpeed()
    {
        return round($this->windSpeed,2);
    }

    public function getTemperatureDegree()
    {
        $temperatureDegree = ($this->temperature-32)/1.8;
        return round($temperatureDegree,2);
    }
}