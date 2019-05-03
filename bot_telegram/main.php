<?php

if (isset($mensaje) && $mensaje!=''){
  
  switch (strtolower($mensaje)) {
    case "/start":
        $bot_nombre='tu bot';
        enviarMensajeTexto($chat_id,"Hola soy ".$bot_nombre.", escribe /help para más información.");
    break;
    case "/hola":
        enviarMensajeTexto($chat_id,"Kon'nichiwa ".$nombre."!");
        break;
    case "/fecha":
        $dias_semana = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
        $dia_actual=$dias_semana[date('w')];
        $fecha=date('d-m-Y'); 
        $hora=date('H:i');
        enviarMensajeTexto($chat_id,"Hoy es ".$dia_actual." ".$fecha." y son las ".$hora.".");
        break;
     case "/random":
        $num_random=rand(1, 10);
        enviarMensajeTexto($chat_id,"".$num_random);
        break;
    case "/passwd":
         require 'passwd_gen.php';
         enviarMensajeTexto($chat_id,$passwd);
        break;
    case "/chollo":
         require 'rss_chollometro.php';
         enviarMensajeTexto($chat_id,$anuncio_random);
        break;
   case "/meteogal":
        require 'meteo.php';
        enviarMensajeTexto($chat_id,"Hola ".$nombre." la predicción para el día de hoy es: ");
        enviarFotografia($chat_id,'foto.jpg');
        break;
  case "/descargaraudio":
         enviarMensajeTexto($chat_id,'Pega aqui la URL de Youtube:');
         file_put_contents("comandos_{$chat_id}.txt",'youtubeurl');
         //Ejemplo URL: https://www.youtube.com/watch?v=7bq4Gp4-IBg
         break;
  case "/noticias":
         require 'rss_elpais.php';
         $url='https://ep00.epimg.net/rss/tags/ultimas_noticias.xml';
         miRss($chat_id,$url);
         break;
  case (preg_match('/alarma.*/', $mensaje) == true) :
        require 'alarma.php';
        alarmaTelegram($chat_id,$mensaje);
        break;
  case (preg_match('/imgdownload.*/', $mensaje) == true) :
        require 'img_download.php';
        imgDownload($chat_id,$mensaje);
        break;
  case (preg_match('/localizame.*/', $mensaje) == true) :
        require 'localizame.php';
        localizame($chat_id,$nombre,$mensaje);
        break;
  case "/help":
        $ayuda="/hola -> Te saluda en Japonés.\n";
        $ayuda=$ayuda."/fecha -> Muestra fecha actual.\n";
        $ayuda=$ayuda."/random -> Muestra número aletorio del 1 al 10.\n";
        $ayuda=$ayuda."/passwd -> Genera una contraseña.\n";
        $ayuda=$ayuda."/chollo -> Muestra un chollo.\n";
        $ayuda=$ayuda."/meteogal -> Muestra mapa del tiempo en Galicia, dependiendo de la hora actual.\n";
        $ayuda=$ayuda."/descargaraudio -> Descarga audio mp3 de un enlace de Youtube.\n";
        $ayuda=$ayuda."/noticias -> Muestra las últimas noticias de El País.\n";
        $ayuda=$ayuda."/alarma hh:mm Mensaje -> A esa hora el bot te envía el mensaje que has escrito.\n";
        $ayuda=$ayuda."/imgdownload nombreimagen -> Te envía la imagen alojada en el servidor.\n";
        $ayuda=$ayuda."/localizame latitud, longitud -> Te envía la dirección de las coordenadas.\n";
        enviarMensajeTexto($chat_id,$ayuda);
        break;
    default:
        if (file_exists("comandos_$chat_id.txt")){
            $lectura=file_get_contents("comandos_$chat_id.txt");
            if ($lectura=='youtubeurl'){
                enviarMensajeTexto($chat_id,'Por favor espere unos minutos y le mandaremos el MP3...');
                descargarAudioYoutubeEnviar($comando,$chat_id);
            }
        }
      break;
    }
  
}

?>