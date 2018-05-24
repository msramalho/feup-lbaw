<?php
namespace App\Facades;
use App\Facades\CustomAuth;

class Log extends \Illuminate\Support\Facades\Log
{

    public static function getUserStr(){

        $user = CustomAuth::user();

        if($user == NULL){
            $uStr = "(-1: n/a)";
        }else{
            $uStr = "(".$user->id . ": ".  $user->username.") ";
        }

        return $uStr; 
    }

    static public function __callStatic($method, $args) {
        if(in_array($method, ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'])){

            return parent::$method(self::getUserStr().$args[0]);

        }
    }
}
