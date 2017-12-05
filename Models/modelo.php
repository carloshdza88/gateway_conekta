<?php

  require_once '../Configuration/config.php';
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

//--------------------------------------------------

class Account{
   private $id;
   private $numtarjeta;
   private $tipotarjeta;
   private $saldo;

   public function __GET($k) { return $this->$k; }
   public function __SET($k,$v) { return $this->$k = $v; }
}

class AccountModel{

  private $con;
  public $campos;

  public function __construct(){
    $this->con = mysqli_connect(SERVIDOR, USUARIO, CONTRASENA,BASEDATOS);


  }

  public function obtenerCuentasWS(){
      $rs_accounts = null;
      $query_select = "select * from accounts;";
      $this->con->query("SET NAMES 'utf8'");
      $stm = $this->con->query($query_select);

      while($row = $stm->fetch_assoc())
          $rs_accounts[] = $row;

    return ($rs_accounts);
  }

  public function retiroDeTarjetaWS($numeroTarjeta,$monto,$tipotarjeta){

    $respuesta_json = array();
    // Si no existe la tarjeta , crearla y generar un saldo aleatorio
    // Si existe solo retirar el monto.
    $res = "";

    $query_select = "select id,saldo,numtarjeta from accounts where numtarjeta='" . $numeroTarjeta . "'";

    $this->con->query("SET NAMES 'utf8'");

    $stm = $this->con->query($query_select);

    if($stm->num_rows > 0){
      $row = $stm->fetch_assoc();
      // Verificar saldo
      $saldo_actual = $row['saldo'];

      $res = $res . $saldo_actual;

      if($monto <= $saldo_actual){
        $res = $res . "Si hay saldo";

        // restar el saldo_actual
        $respuesta_json = array('status' => 'succes' ,
                                'message' => 'El monto ha sido retirado de la tarejta ****0009' ,
                                'saldo' => $saldo_actual - $monto , 'monto' => $monto);

      }
      else {
        $res = $res . "No hay saldo sufuciente";
        $respuesta_json = array('status' => 'denied' ,
                                'message' => 'No hay saldo suficiente en la tarjeta ****0009' ,
                                'saldo' => $saldo_actual , 'monto' => $monto);
      }

      $res = $res . "saldo acutal". $saldo_actual;

    }
    else{
      // Crear la tarjeta
      $saldo = rand(5000,70000);

      $query_insert = "insert into accounts(numtarjeta,tipotarjeta,saldo)
                       values('" . $numeroTarjeta . "'," . $tipotarjeta . "," . $saldo . ");";

      $stm = $this->con->query($query_insert);

      $respuesta_json = array('status' => 'succes' ,
                              'message' => 'Se agrego la tarjeta ****0009',
                              'saldo' => $saldo_actual , 'monto' => $monto);


      $res = $res . "Tarjeta agregada";

    }


    return $respuesta_json;

  }

}

 ?>
