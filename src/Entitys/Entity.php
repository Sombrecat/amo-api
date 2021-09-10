<?php

namespace Jarvis\AmoApi\Entitys;

use Jarvis\AmoApi\AmoClient;

class Entity
{

    protected AmoClient $client;
    protected static string $path;
    protected static string $entity_type;
    protected static string $req_url;
    protected string $access_token;

    public function __construct(AmoClient $client)
    {
        $this->client = $client;
        $this->access_token = $this->client->getUpdateToken();
        static::$req_url = AmoClient::$url . static::$path;
    }

    public function getById(int $id): array
    {
        $url = static::$req_url . '/' . $id;

        return AmoClient::sendRequest($url, 'GET', [], $this->access_token);
    }

    public function create(array $data = []): array
    {
        $response = AmoClient::sendRequest(static::$req_url, 'POST', [$data], $this->access_token);

        return $response['_embedded'][static::$entity_type][0];
    }

    public function update(array $data): array
    {
        $url = static::$req_url . '/' . $data['id'];

        return AmoClient::sendRequest($url, 'PATCH', [$data], $this->access_token);
    }
}