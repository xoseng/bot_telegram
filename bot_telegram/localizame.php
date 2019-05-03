<?php
function localizame ($chatid, $usuario, $coordenadas){
  //comprobar que son coordenadas
  $msg_coordenadas = explode(" ", $coordenadas);
  $coords=$msg_coordenadas[1].' '.$msg_coordenadas[2];
  $pattern_coords="/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/";
  if(preg_match($pattern_coords,$coords)){
    $comprobar_coords=1;
  }else{
    $comprobar_coords=0;
  }
  //si no son coordenas pedir unas coordenas correctas
  if ($comprobar_coords == 0){ 
     enviarMensajeTexto($chatid,'Formato incorrecto...');
     enviarMensajeTexto($chatid,'Ejemplo: /localizame 40.714224, -73.961452');
  }else{
    //si es una coord válida
    $google_apikey='AIzaSyCGzG6BaWJiwYdgrftLGQUS1Sj8cr_bDNs';
    $latlng=$msg_coordenadas[1].$msg_coordenadas[2];
    $url_map='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng.'&key='.$google_apikey;
    $json_file = file_get_contents($url_map);
    $vars = json_decode($json_file);
    //results->formatted_address
    $direccion='';
    $contador=1;
    foreach($vars->results as $resultados){
      while ($contador < 2){ //cojo sólo el primer resultado
        $direccion=$resultados->formatted_address;
        $contador++;
      }
    }
    //devolver mensaje
    enviarMensajeTexto($chatid,'Hola '.$usuario.', las coordenadas introducidas corresponden a la siguiente dirección:');
    enviarMensajeTexto($chatid,$direccion);
  }
}
?>