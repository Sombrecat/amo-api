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
//$client->authByCode('def502007475ee7c4ddf74334dceb2a165f3444ba5b51f39939db5026932f058ac878a0606591688deaccc9ecbd35a648b5b9c208c788591c99a3a4bdd9c715b1cadc6a1ecae90b0af39332b98dd85428bef226867b8480144cf2af7d00f2ff31955e4bdb1be814cf92d73c81d15de145949661be0a94a1e769416966aac474f779e32074a24935e0a6dd49fa3b5507e489a78f534556d69f92d34288399e2ce6ee08d94a8b97606e438842ebdcc85b0b58dd2fe54c30309e2f2c80b03a0b70ec675fb5338a1a9473dbcc4af0424b8930cfb60c3d85a40483b7f74994b91ea4975e8b9378947cc3769f27fdb41f846b68f9b2987aba6e99532ece548b4e4848ce2017e7cffee26eaea7c4ebcc95a034444e4caedff7ed39f7057f748134b2d2d730ccabe7e9b0c8d5d9d91e553086519f258f0d01a6e4758f5aa13d0d22bf0c1bb8502f84944159a0b28081da7a283fccd7db0a52b4a7bb0b686ededbd3a990c0723ee1b0becb3f6ec3c65e349d3c5728fda93c87cb69f030115461d3f6fb56abc2c5fcaa31efd0dc9fa1058f25f6102495cbdfc9ce752de982023914ef67ddfa07780938ffde9f2b98ae92ffbaef133b221636974867ff654a0a1');
