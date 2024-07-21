<?php
namespace App\Services;

use GuzzleHttp\Client;

class RajaOngkirService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.rajaongkir.com/starter/',
            'headers' => [
                'key' => env('RAJAONGKIR_API_KEY'),
            ],
        ]);
    }

    public function getProvinces()
    {
        $response = $this->client->get('province');
        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }

    public function getCities($provinceId)
    {
        $response = $this->client->get('city', [
            'query' => ['province' => $provinceId],
        ]);
        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = $this->client->post('cost', [
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ],
        ]);
        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }
}
