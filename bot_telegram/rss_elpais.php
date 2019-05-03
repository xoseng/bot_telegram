<?php
    function miRss($chatid,$urlrss){
      $i = 0;
      $rss = simplexml_load_file($urlrss);
      $devolver='';
      $cantidad=5;
          foreach($rss->channel->item as $item) {
            $link = $item->link;  //extrae el link
            $title = $item->title;  //extrae el titulo
            $date = $item->pubDate;  //extrae la fecha
            $guid = $item->guid;  //extrae el link de la imagen
            $description = strip_tags($item->description);  //extrae la descripcion
            if (strlen($description) > 400) { //limita la descripcion a 400 caracteres
                $stringCut = substr($description, 0, 200);                   
                $description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
            }
            if ($i < $cantidad) { // extrae  x cantidad de anuncios
               $devolver[$i]=$title.': '.$link;
               enviarMensajeTexto($chatid,$devolver[$i]);
            }
            $i++;
          } 
     }
 ?>	
