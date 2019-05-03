<?php        
  //Dependiendo de la hora bajar una u otra:
  $hora_sistema=date('H');
  $letra='';
  if ($hora_sistema >= 7 && $hora_sistema < 14){
    $letra='M';
  }
  if ($hora_sistema >= 14 && $hora_sistema <= 20){
    $letra='T';
  }
  if ($hora_sistema < 7 || $hora_sistema > 20){
    $letra='N';
  }
  //echo $hora_sistema;
  //conseguir foto
  $url="http://www.meteogalicia.gal/web/predicion/cprazo/getImaxe{$letra}.action";
  $foto=file_get_contents($url);
  //Guardamos la foto que esta en memoria
  file_put_contents('foto.jpg',$foto);
?>