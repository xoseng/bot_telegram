<?php
function shell_exec_Asincronous($comando){
    if (!$comando){
        throw new Exception("No se ha pasado un comando!");
    }
    if (strtoupper(substr(PHP_OS,0,3)) === 'WIN'){
        system($comando." >NUL");
    }
    else{
        shell_exec("/usr/bin/nohup bash ".$comando." >/dev/null 2>&1 &");
    }
}

function alarmaTelegram($chatid,$msg){
  $msg_contenido = explode(" ", $msg);
  $hora=$msg_contenido[1];
  $aviso='';
  //ESTO NO VA BIEN
  for ($i = 2; $i < count($msg_contenido); $i++) {
      //hay que concatenarle _ porque con espacios no va funcionar el paso de variables, luego se quitan...
      $aviso=$aviso.'_'.$msg_contenido[$i];
  }
 //echo $aviso;
  //COMPROBAR QUE LA HORA ES UNA HORA Y QUE EXISTE UN MENSAJE, SI NO VOLVER A PEDIR LOS DATOS...
  //validar campos 
  $pattern_hora="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
  if(preg_match($pattern_hora,$hora)){
    $comprobar_hora=1;
  }else{
    $comprobar_hora=0;
  }
  echo $comprobar_hora; 
  //Comprobar que existe texto
  if ($aviso !='' && isset($aviso)){
    $comprobar_aviso=1;
  }else{
    $comprobar_aviso=0;
  }
  //echo $comprobar_aviso; 
  /////////////////////////////////
  //AHORA QUE SE COMPROBO Y SE EXTRAJO LO SOLICITADO SI SE CUMPLE LO ENVIADO SE PROGRAMA LA TAREA QUE ENVÍE EL MENSAJE, SI NO PIDES QUE ENVIE BIEN EL MENSAJE
  if ($comprobar_aviso == 0 || $comprobar_hora == 0){ //si no está validado alguno de los campos...
     enviarMensajeTexto($chatid,'Sintaxis incorrecta!');
     enviarMensajeTexto($chatid,'Ejemplo: /alarma 07:00 despertador');
  }else{
    enviarMensajeTexto($chatid,'Alarma fijada!');
    $comando_at=realpath("./at_alarma.sh")." $aviso $chatid $hora";
    shell_exec_Asincronous($comando_at);
  }
}
?>