<?php
require_once '../Models/modelo.php';

if(isset($_GET['metodo']))
$metodo = htmlspecialchars($_GET["metodo"]);

if(isset($_GET['usuario']))
$usuario = htmlspecialchars($_GET["usuario"]);

if(isset($_GET['numerotarjeta']))
$numeroTarjeta = htmlspecialchars($_GET["numerotarjeta"]);

if(isset($_GET['monto']))
$monto = htmlspecialchars($_GET["monto"]);

if(isset($_GET['tipotarjeta']))
$tipotarjeta = htmlspecialchars($_GET["tipotarjeta"]);


switch ($metodo) {
  case 'obtenerCuentas':

     obtenerCuentas();

    break;

    case 'retirarSaldo':

       retiroDeTarjeta($numeroTarjeta,$monto,$tipotarjeta);

      break;



  default:

    break;
}

function obtenerCuentas(){
     $obj_ModeloCuentas = new AccountModel();
     $a = $obj_ModeloCuentas->obtenerCuentasWS();

     echo json_encode($a);
}

function retiroDeTarjeta($numeroTarjeta,$monto,$tipotarjeta){
     $obj_ModeloCuentas = new AccountModel();

     $a = $obj_ModeloCuentas->retiroDeTarjetaWS($numeroTarjeta,$monto,$tipotarjeta);

     echo json_encode($a);
}

function depositoATarjeta($numeroTarjeta,$monto){
     $obj_ModeloCuentas = new AccountModel();
     $a = $obj_ModeloCuentas->obtenerCuentasWS();

     echo json_encode($a);
}




?>
