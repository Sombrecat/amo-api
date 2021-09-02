<?php

namespace Jarvis\AmoApi;

class AmoClient
{

    protected array $client_data;
    protected static string $url;
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
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
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
        $response['expires_in'] += time();

        file_put_contents(static::$file_path, json_encode($response));
    }

}