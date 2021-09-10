<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

use Jarvis\AmoApi\AmoClient;

$client_data = [
    'domain'        => 'dlatestov',
    'client_id'     => '3a36eef8-28c7-41f0-838c-84fbd4687c81',
    'client_secret' => 'UncxD8W9ALM6Lr2KjHhGjpWG5jZyjnpGd8pKJOtmicbdmFH5muOKER4HS0hdFFZi',
    'redirect_uri'  => 'https://example.com'
];

$client = new AmoClient($client_data);
//$client->authByCode('def50200d91b0fd0cf5fca114ac4d45af6c087ee29405f3307ebeff83819d3ea97acb52759aa3eee8502e76ccdd20c9a7d5846149b044f9976f0584937f588e72e113af180461159c1c20a22a0e4ccc0ff2f50788c5a635e00a35d7ecbb8a61fad7521e95eaf1593481f728db2cf115024ee354b9a420a30a7039de4d8ebe24946a71852e459ddaa333c5aefc03ba5441049f3689d677079b82582b23ee281c23d5314a6a864ca39a50254adaca529dbd298f32eca6bc57930acde452fcf347671af9e8dae6da43ebf8f9d8bc42e52af95b5ae4e5be23125e30bd71b2479139bb542e6fadc3b2c7723d2926ebf2537b700899974fc0d1d2956728b0114b8c1e15d770b417e6a8a7bc54a30d01b9f80829760db9ad8e6b1fac53813bc8e750442a6653aa5c1626c07213c350da16687bac41f5ec9f98a469187dcc6a4ab49c76afe5340d0a99a38fb93499a23fcb20f87684c05b429a6c8772bc765a7d747799451e26ee3ec3e326e485d2ffdf4fdbc87c223a0a973aa63312ea1801e2eb670d9a1f36ed7cfdc5e5d908a373303762610b0a44ffd8c8e1cf4e4c5fbcafde451b7133dc460e89b91fe99ae4de2c18c74aae944954651bdff01873bb3');
//$client->getUpdateToken();

//$lead = $client->contact();
//$new_lead = $lead->getById(45708301);
//print_r($new_lead) . '<br>';

$contact = $client->contact();

//$entity = $contact->create(['name' => 'NAME']);
//$contact->update($entity);