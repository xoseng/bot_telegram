<?php
// Definimos el Bot_token  y la API URL.
define ('BOT_TOKEN',' ');
define ('API_URL','https://api.telegram.org/bot'.BOT_TOKEN);
//echo $argv[1];

$ficheroaudio=$argv[1];
$idchat=explode('.',$argv[1])[0];

$datos = array(
    "chat_id"=>$idchat,
    "audio"=> new CURLFile(realpath('./'.$ficheroaudio))
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
curl_setopt($ch, CURLOPT_URL, API_URL."/sendaudio");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
curl_exec($ch);
curl_close($ch);