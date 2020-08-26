<?php

include('EnvioSms.php');



$sid = $_POST["sid"];
$token = $_POST["token"];
$from = $_POST["origen"];
$to = $_POST["destino"];
$sms =  $_POST["sms"];

$envio = new EnvioSms($sid,$token,$from);
try {
    $resultado = $envio->enviar_sms($to,$sms);
    
    echo $resultado["message"];
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
