<?php
#cambiar por rutas deseadas
function enviarFotografiaAlojada($idchat, $nombrefichero){
  $rutaRealFichero=realpath('/var/dominios/midominio/public/bot_telegram/upload_imagen/'.$nombrefichero);
    $post=array(
    'chat_id' => $idchat,
    'photo' => new CURLFile($rutaRealFichero)
  );
  $ch=curl_init();
  curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
  curl_setopt($ch,CURLOPT_URL,API_URL.'/sendPhoto');
  curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  $result=curl_exec($ch);
  curl_close($ch);
  
}

function imgDownload($chatid,$msg){
  //obtener variables
  $msg_contenido = explode(" ", $msg);
  $nombre_imagen=$msg_contenido[1];
  ///si se pasa una imagen, se comprueba que existe en el servidor
  $lista_img= shell_exec('ls /var/dominios/midominio/public/bot_telegram/upload_imagen/');
  if ($nombre_imagen != ''){
    $nombre_fichero = '/var/dominios/midominio/public/bot_telegram/upload_imagen/'.$nombre_imagen;
    if (file_exists($nombre_fichero)){ //si existe la imagen la enviamos
      enviarFotografiaAlojada($chatid, $nombre_imagen);
    }else{
      enviarMensajeTexto($chatid,'Esta imagen no existe, prueba con alguna de las siguientes imágenes:');
      enviarMensajeTexto($chatid,$lista_img);
    }
    
  }else{
    enviarMensajeTexto($chatid,'Introduzca /imgdownload seguido del nombre de una imagen alojada en el servidor!');
    enviarMensajeTexto($chatid,$lista_img);
  }
}
?>