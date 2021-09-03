<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

use Jarvis\AmoApi\AmoClient;

$client_data = [
    'domain'        => 'dlatestov',
    'client_id'     => '3a36eef8-28c7-41f0-838c-84fbd4687c81',
    'client_secret' => 'Z4tW7gnGuB3ivA5otMcPhNraYabTxt4zliZrtTLohrfaxWVPX2vBVmiYxEZI7jVY',
    'redirect_uri'  => 'https://example.com'
];

$client = new AmoClient($client_data);
//$client->authByCode('def50200eed884ee34ecedf056a7350013598dbeff00a3a09667488eb5f69f388607af9b2b9c622feaa508a6a7270c4cecdd1cb8306fa5a6fc6b2890e6ded81bcb3b14b9fd8c79e2a1a43a5bb1d7decc86f5aaef18ac0da3b329ff92889479e91d4e19806695a4c7e3dc2e6116d7c14edf6cf638dfd4a589a30744f426c4b1ca425edd72e327a782839563f844172d6d6b03eeea152719e7a63baa9aba2f2bc018ce9138b56b0b88f75080cb41ecccba0d219f3e0f1c823bbb841b4116ee5753eb3cf615f269d6dd5c5d659acc4e12f591e75d4a6be5e6ae9f1cffcac0862d357b92609874c3ace7691d70ae54572fc99dabcb26436ff585df319b93bba10f6856df11608bbe05c650b232750c395d842c93da5f1fe499499ce6778a89346d71cb29746b23c977a9e3b47aa1f79fcfb360488c6cb3de21d99f8ab5199013c82f61b737a5a2e581378235669f9a83963481b43bc6354fca049fa44b9cf536532dee409387ac0c20f6c020de8cac058678fe82601989de783cb750a0532aa47de7711b90bce55fea622e1980c840afa10411165d1ab6cd5fb2ec1e60e098da6f85a8065d2619a7cdf8804d7f8cd920cd34481619d4f450042ba1d32f');
//$client->getUpdateToken();

$contact = $client->contacts();
$new_contacts = $contact->getById(45697165);
