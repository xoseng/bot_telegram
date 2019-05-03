<?php
#introduce tl token de tu bot
define ('BOT_TOKEN',' ');
define ('API_URL','https://api.telegram.org/bot'.BOT_TOKEN);

setlocale(LC_ALL,'es_ES.UTF8');
date_default_timezone_get("Europe/Madrid");


$peticion=json_decode(file_get_contents('php://input'));

$fichero='debug.txt';
file_put_contents($fichero, file_get_contents('php://input'));

///volcar la id del mensaje enviado al bot
$fichero2='info.txt';
file_put_contents($fichero2, $peticion->update_id);

//ejemplo de acceso a variables
$nombre=$peticion->message->from->first_name;
$chat_id=$peticion->message->chat->id;
$comando=$peticion->message->text;
//funcion para devolver o enviar un mensaje de texto
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
//funcion enviar fotografía
function enviarFotografia($idchat, $nombrefichero){
  $rutaRealFichero=realpath('./'.$nombrefichero);
    $post=array(
    'chat_id' => $idchat,
    'photo' => new CURLFile($rutaRealFichero)
  );
  //crear la conexión con curl para enviar el fichero
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
  curl_setopt($ch,CURLOPT_URL,API_URL.'/sendPhoto');
  curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  $result=curl_exec($ch);
  curl_close($ch);
  
}

function enviarAudio($idchat,$ficheroaudio){
    $datos = array(
        "chat_id"=>$idchat,
        "audio"=> new CURLFile(realpath($ficheroaudio))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
    curl_setopt($ch, CURLOPT_URL, API_URL."/sendaudio");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_exec($ch);
    curl_close($ch);
}

function enviarVideo($idchat,$ficherovideo){
    $datos = array(
        "chat_id"=>$idchat,
        "video"=> new CURLFile(realpath($ficherovideo))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
    curl_setopt($ch, CURLOPT_URL, $this->url."/sendvideo");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_exec($ch);
    curl_close($ch);
}

function enviarlocalizacion($idchat,$latitud,$longitud){
  file_get_contents(API_URL."/sendLocation?chat_id=$idchat&latitude=$latitud&longitude=$longitud");
}

function shell_exec_Asincrono($comando){
    if (!$comando){
        throw new Exception("No se ha pasado un comando");
    }
    // Si es un PHP en Windows...
    if (strtoupper(substr(PHP_OS,0,3)) === 'WIN'){
        system($comando." >NUL");
    }
    else{
        shell_exec("/usr/bin/nohup bash ".$comando." >/dev/null 2>&1 &");
    }
}

function descargarAudioYoutubeEnviar($urlYoutube,$idchat){
    $comandoEjecutar=realpath("./descargar.sh")." $urlYoutube $idchat";
    shell_exec_Asincrono($comandoEjecutar);
}

require 'almacen_imagenes.php';

require 'recibir_ubicacion.php';

////DEVOLVER MENSAJES///
$mensaje=$peticion->message->text;

//////COMPROBAR COORDS
require 'comprobar_coords.php';
coordenadasbot($chat_id,$mensaje,$nombre);

////////////////////MAIN

require 'main.php';
              
?>