<?php

namespace Jarvis\AmoApi\Entitys;

use Jarvis\AmoApi\AmoClient;

class Entity
{

    public AmoClient $client;
    public static $entity_type;
    public static string $path;
    public array $simple_field;

    public function __construct(AmoClient $client, array $simple_field = [])
    {
        $this->client = $client;
        $this->simple_field = $simple_field;
    }

    /**
     * Создаем поля и присваиваем им значения
     *
     * @param string $name - ключ массива
     * @param mixed $value - значение ключа
     */
    public function __set(string $name, mixed $value)
    {
        $this->simple_field[$name] = $value;
    }

    /**
     * Метод обращается к сущности по id
     *
     * @param int $id - id сущности
     * @return array - массив с данными сущности
     */
    public function getById(int $id): array
    {
        $req_url = AmoClient::$url . static::$path . '/' . $id;
        $access_token = $this->client->getUpdateToken();

        return AmoClient::sendRequest($req_url, 'GET', null, $access_token);
    }

}