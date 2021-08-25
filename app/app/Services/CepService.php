<?php

namespace App\Services;

use App\Models\Address;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class CepService
{
    public static function fetchAddress(string $cep): Address
    {
        $client = new Client();
        $response = $client->request('GET', "https://viacep.com.br/ws/$cep/json/");
        $data = json_decode($response->getBody());

        return new Address([
            'state' => $data->uf,
            'city' => $data->localidade,
            'neighborhood' => $data->bairro,
            'street' => $data->logradouro,
            'postal_code' => $data->cep,
        ]);
    }
}
