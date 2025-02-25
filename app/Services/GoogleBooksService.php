<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleBooksService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.googleapis.com/books/v1/',
        ]);
        $this->apiKey = env('GOOGLE_BOOKS_API_KEY'); 
    }

    public function searchBooks($query, $maxResults = 10)
    {
        $params = [
            'q' => $query,
            'maxResults' => $maxResults,
        ];
        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        }

        $response = $this->client->get('volumes', [
            'query' => $params,
        ]);

    //     $responseBody = $response->getBody()->getContents();
    // $data = json_decode($responseBody, true);

    // dd($data); // Inspect the decoded JSON response

    // return $data;

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getBook($volumeId)
    {
        $params = [];
        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        }
        $response = $this->client->get('volumes/' . $volumeId, [
            'query' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}