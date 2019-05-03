<?php
// TRUE O FALSE EN LA OPCIÓN QUE QUIERAS AÑADIR
$opc_letras = TRUE; //  FALSE para quitar las letras
$opc_numeros = TRUE; // FALSE para quitar los números
$opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
$opc_especiales = FALSE; // FALSE para quitar los caracteres especiales
$longitud = 8;
$password = "";

$letras ="abcdefghijklmnopqrstuvwxyz";
$numeros = "1234567890";
$letrasMayus = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$especiales ="|@#~$%()=^*+[]{}-_";
$listado = "";

if ($opc_letras == TRUE) {
    $listado .= $letras; 
}

if ($opc_numeros == TRUE) {
    $listado .= $numeros; 
}

if($opc_letrasMayus == TRUE) {
    $listado .= $letrasMayus; 
}

if($opc_especiales == TRUE) {
    $listado .= $especiales; 
}

str_shuffle($listado);

for( $i=1; $i<=$longitud; $i++) {
  $password[$i] = $listado[rand(0,strlen($listado))];
  str_shuffle($listado);
}
$passwd='';
foreach ($password as $dato_password) {
    $passwd=$passwd.$dato_password;
}
$passwd=''.$passwd;

?>