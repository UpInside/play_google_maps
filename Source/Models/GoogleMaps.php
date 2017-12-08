<?php

namespace Source\Models;

class GoogleMaps
{

    private $apiUrl;
    private $apiKey;
    private $params;
    private $callback;
    private $latLng;
    private $address;

    public function __construct()
    {
        $this->apiKey = "SUA_KEY_AQUI";
        $this->apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?key={$this->apiKey}&sensor=false&language=pt-BR";
    }

    public function setAddress($params)
    {
        $this->params = str_replace(" ", "+", $params);
        $this->get();
        return $this;
    }

    public function getAddress()
    {
        $this->address = $this->callback->results[0]->formatted_address;
        return $this->address;
    }

    public function getLatLng()
    {
        $this->latLng = $this->callback->results[0]->geometry->location;
        return $this->latLng;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    private function get()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->apiUrl}&address={$this->params}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->callback = json_decode(curl_exec($ch));
        curl_close($ch);
    }

}
