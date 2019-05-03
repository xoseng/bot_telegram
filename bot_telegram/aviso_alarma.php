<?php
define ('BOT_TOKEN',' ');
define ('API_URL','https://api.telegram.org/bot'.BOT_TOKEN);

setlocale(LC_ALL,'es_ES.UTF8');
date_default_timezone_get("Europe/Madrid");

$idchat=explode('.',$argv[1])[1];
$texto=explode('.',$argv[1])[0];
//ahora hay que transforma los _ del texto en espacios
$texto_contenido = explode("_", $texto);
$longitud_texto=count($texto_contenido);
$mensaje='';
for ($i = 1; $i < $longitud_texto; $i++) {
  $mensaje=$mensaje.' '.$texto_contenido[$i];
}

function enviarMensajeTexto ($idchat, $texto){
  $post=array(
    'chat_id' => $idchat,
    'text' => $texto,
    'parse_mode' => 'HTML'
  );
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL,API_URL.'/sendMessage');
  curl_setopt($ch,CURLOPT_POST,1);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  $result=curl_exec($ch);
  curl_close($ch);
}

enviarMensajeTexto($idchat,$mensaje);

?>