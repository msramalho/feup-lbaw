<?php
namespace App\Facades;

use Illuminate\Support\Facades\Log;
use App\Facades\CustomAuth;

class betterLog extends Log
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
