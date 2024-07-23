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
        \Log::info('Using API Key: ' . config('services.rajaongkir.key'));
        $response = $this->client->get('province');
        $data = json_decode($response->getBody(), true);
        \Log::info('Provinces Data: ' . print_r($data, true));
        return $data;
    }
    
    

    public function getCities($provinceId)
    {
        $response = $this->client->get('city', [
            'query' => ['province' => $provinceId],
        ]);
        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }

    public function getSubdistricts($cityId)
    {
        $response = $this->client->get('subdistrict', [
            'query' => ['city' => $cityId],
        ]);
        $data = json_decode($response->getBody(), true);
        \Log::info('Subdistrict Data: ' . print_r($data, true));
        return $data['rajaongkir']['results'];
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