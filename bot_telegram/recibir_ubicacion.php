<?php

$latitud=$peticion->message->location->latitude;
$longitud=$peticion->message->location->longitude;

if (isset($latitud) && $latitud!=''){
      $google_apikey=' ';
      $latlng=$latitud.','.$longitud;
      $url_map='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng.'&key='.$google_apikey;
      $json_file = file_get_contents($url_map);
      $vars = json_decode($json_file);
      $direccion='';
      $contador=1;
      foreach($vars->results as $resultados){
        while ($contador < 2){ //sólo el primer resultado
          $direccion=$resultados->formatted_address;
          $contador++;
        }
      }
      //devolver mensaje
      enviarMensajeTexto($chat_id,'Hola '.$nombre.', las coordenadas introducidas corresponden a la siguiente dirección:');
      enviarMensajeTexto($chat_id,$direccion);
}
?>