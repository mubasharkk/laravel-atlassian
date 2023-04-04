<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Mubasharkk\Atlassian\Exceptions\BadRequest;
use Psr\Http\Message\ResponseInterface;

class AtlassianService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://marketplace.atlassian.com/rest/2/',
        ]);
    }

    public function getAddonsList(array $queryParams = [])
    {
        try {
            return $this->prepareResponse(
                $this->client->get('addons', [
                    'query' => $queryParams
                ])
            );
        } catch (ClientException $ex) {
            throw new BadRequestException(
                $ex->getResponse()->getBody()->getContents(),
                $ex->getCode()
            );
        }
    }

    public function getAppsList(array $queryParams = []): array
    {
        return $this->prepareResponse(
            $this->client->get('applications', [
                'query' => $queryParams
            ])
        );
    }

    private function prepareResponse(ResponseInterface $response)
    {
        $data = $response->getBody()->getContents();
        return \json_decode($data);
    }
}
