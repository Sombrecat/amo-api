<?php

namespace Jarvis\AmoApi;

use Jarvis\AmoApi\Entitys\Company;
use Jarvis\AmoApi\Entitys\Contact;
use Jarvis\AmoApi\Entitys\Lead;
use Jarvis\AmoApi\Entitys\Note;
use Jarvis\AmoApi\Entitys\Task;

class AmoClient
{

    protected array $client_data;
    public static string $url;
    protected static string $file_path;

    public function __construct($client_data)
    {
        $this->client_data = $client_data;
        static::$url = 'https://' . $this->client_data['domain'] . '.amocrm.ru';
        static::$file_path = __DIR__ . '../../Storage/' . $this->client_data['client_id'] . '.json';
    }

    /**
     * Статический метод отправки запроса к AMO.
     *
     * @param string $url - адрес
     * @param string $method - метод запроса
     * @param array|null $data - передаваемые данные
     * @param string $access_token - токен для обращения к AMO.
     * @return array - раскодированный массив токенов
     */
    public static function sendRequest(string $url, string $method, array $data = null, string $access_token = ''): array
    {
        $headers = [
            'Content-Type:application/json',
            'Authorization: Bearer ' . $access_token
        ];

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);

        if ($method = 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            if ($code < 200 || $code > 204) {
                throw new \Exception($errors[$code] ?? 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return json_decode($out, true);
    }

    /**
     * Функция первичной авторизации по коду.
     * Кладет пришедший json ответ в файл
     *
     * @param string $code - код авторизации
     */
    public function authByCode(string $code)
    {
        $req_data = [];
        $req_url = static::$url . '/oauth2/access_token';

        foreach ($this->client_data as $key => $value) {
            $req_data[$key] = $value;
            $req_data['grant_type'] = 'authorization_code';
            $req_data['code'] = $code;
        }

        $response = static::sendRequest($req_url, 'POST', $req_data);
        $this->saveToken($response);
    }

    /**
     * Метод сохраняет токены в файл
     *
     * @param array $data - токены
     */
    public function saveToken(array $data)
    {
        $data['expires_in'] += time();

        file_put_contents(static::$file_path, json_encode($data));
    }

    /**
     * Метод проверяет актуальность токена
     * Если срок действия закончился, то функция его обновляет
     */
    public function getUpdateToken(): string
    {
        $token_data = json_decode(file_get_contents(static::$file_path), true);

        try {
            if (file_exists(static::$file_path) and empty($token_data)) {
                throw new \Exception('Повторите попытку авторизации');
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        if (time() > $token_data['expires_in']) {
            $req_data = [];
            $req_url = static::$url . '/oauth2/access_token';

            foreach ($this->client_data as $key => $value) {
                $req_data[$key] = $value;
                $req_data['grant_type'] = 'refresh_token';
                $req_data['refresh_token'] = $token_data['refresh_token'];
            }

            $response = static::sendRequest($req_url, 'POST', $req_data);
            $this->saveToken($response);

            return $response['access_token'];
        }

        return $token_data['access_token'];
    }

    public function contact(): Contact
    {
        return new Contact($this);
    }

    public function lead(): Lead
    {
        return new Lead($this);
    }

    public function company(): Company
    {
        return new Company($this);
    }

    public function task(): Task
    {
        return new Task($this);
    }

    public function note(): Note
    {
        return new Note($this);
    }

}