<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require __DIR__ . '/twilio-php-6.7.0/src/Twilio/autoload.php';

use Twilio\Rest\Client;
/**
 * Description of EnvioSms
 *
 * @author marcos
 */
class EnvioSms {
    
    //variable que almacena obj para integrar con la sdk de twilio
    private $cliente;
    //variable que almacena numero de cell de origen
    private $desdeNumero;
            
    public function __construct($sid, $authtoken, $desdeNumero) {
        $this->cliente = new Client($sid, $authtoken);
        $this->desdeNumero = $desdeNumero;
    }
    
    public function enviar_sms($alNumero, $sms) {
        
        $respuesta = null;
        
        if (strlen($sms) == 0 || strlen($sms) > 120) {
            $respuesta = array(
                'status' => 'error',
                'message' => 'El sms no puede ser vacío o exceder a 120 caracteres'
            );
        }
        else if (strlen($alNumero) <= 7) {
            $respuesta = array(
                'status' => 'error',
                'message' => 'El numero debe ser válido'
            );
        }
        else{
                try {
                    $this->cliente->messages->create($alNumero, array(
                        'from' => $this->desdeNumero,
                        'body' => $sms
                    ));
                } catch (\Throwable $th) {
                    $respuesta = array(
                        'status' => 'error',
                        'message' => 'Vefifique los parametros de envio y cuenta',
                        'data' => $th
                    );
                    return $respuesta;
                }
                

                $respuesta = array(
                        'status' => 'success',
                        'message' => 'Se envió un sms al número'.' '.$alNumero.' '.'desde el'.' '.$this->desdeNumero.' '.'con el texto ('.' '.$sms.' '.')'
                );
        
            }

        return $respuesta;
    }
    

}
