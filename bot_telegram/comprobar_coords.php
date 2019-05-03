<?php
function coordenadasbot($chatid, $mensaje, $usuario){
    $pattern_coordenadas="/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/";
    if(preg_match($pattern_coordenadas,$mensaje)){
         $comprobar_coords=1;
    }else{
         $comprobar_coords=0;
    }
    if ($comprobar_coords == 1){ 
      $google_apikey=' ';
      $msg_coordenadas = explode(" ", $mensaje);
      $latlng=$msg_coordenadas[0].$msg_coordenadas[1];
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
      enviarMensajeTexto($chatid,'Hola '.$usuario.', las coordenadas introducidas corresponden a la siguiente dirección:');
      enviarMensajeTexto($chatid,$direccion);
    }
}
?>