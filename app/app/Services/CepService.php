<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class CepService
{
    public static function fetchAddress(string $cep)
    {
        $client = new Client();
        $response = $client->request('GET', "https://viacep.com.br/ws/$cep/json/");
        $address = self::formatterResponseViaCep(json_decode($response->getBody()));
        return $address;
    }

    private static function formatterResponseViaCep($response)
    {
        return [
            'state' => $response->uf,
            'city' => $response->localidade,
            'neighborhood' => $response->bairro,
            'street' => $response->logradouro,
            'postal_code' => $response->cep,
        ];
    }
}
