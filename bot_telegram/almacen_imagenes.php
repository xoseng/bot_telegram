<?php
$mi_token=' ';//INTRODUCE AQUÍ TU TOKEN
$foto_id='';
foreach($peticion->message->photo as $mifotoid){
  $foto_id=$mifotoid->file_id;
}

//si foto_id existe entonces subo la foto, si no existe es que no se subieron fotos!
if (isset($foto_id) && $foto_id!=''){
  $link1="https://api.telegram.org/bot".$mi_token."/getFile?file_id=".$foto_id;
  $json_link1 = file_get_contents($link1);
  $vars1 = json_decode($json_link1);
  $foto_ruta=($vars1->result->file_path);
  $foto_link='https://api.telegram.org/file/bot'.$mi_token.'/'.$foto_ruta;
  $foto_descarga=file_get_contents($foto_link);
  //obtener el nombre.extension de la foto
  $foto_tipo = explode("/", $foto_ruta); //separo photos/foto.extension y obtendré foto.extension
  $prefijo=date('Y-m-d-H:i').'_';
  $foto_nombrefinal=$prefijo.$foto_tipo[1];
  file_put_contents($foto_nombrefinal,$foto_descarga);
  //mover la imagen a la carpeta, de upload_imagen es propietario www-data y uso la funcion porque el move_uploaded_file no sirve para files ya subidos!
  function move_to($origen,$destino){
    copy($origen,$destino);
    unlink($origen);
  }
  //introduce el path que corresponda
  $origen_foto = '/var/dominios/misitio/public/bot_telegram/'.$foto_nombrefinal;
  $destino_foto = '/var/dominios/misitio/public/bot_telegram/upload_imagen/'.$foto_nombrefinal;
  move_to($origen_foto,$destino_foto);
  enviarMensajeTexto($chat_id,'Imagen guardada correctamente en el servidor!');

}

?>