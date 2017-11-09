<?php

namespace App\Http\Controllers;

class ApiController
{
    const API_ADDRESS = 'https://api.thescore.com/nhl';

    /**
     * @return array
     */
    public function standings()
    {
        return json_decode(file_get_contents($this->buildUri('/standings')));
    }

    /**
     * @param string $endpoint
     * @return string
     */
    private function buildUri($endpoint)
    {
        return self::API_ADDRESS . $endpoint;
    }
}