<?php
    $i = 0;
    $url = 'https://www.chollometro.com/rss'; 
    $rss = simplexml_load_file($url);
    $devolver='';
    $cantidad=10;
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
            $devolver[$i]=$devolver.$title.': '.$link;
          }
          $i++;
        }
        $anuncio_random=substr($devolver[rand(0, $cantidad - 1)], 5);
 ?>	
