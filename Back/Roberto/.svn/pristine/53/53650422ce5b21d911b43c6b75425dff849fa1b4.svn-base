<?php
class CryptographyHelper{
    
        public static function encrypt($str, $user) {
          if(Yii::app()->params['app']['crypt']){
              
            if($user!=false && $user->device==false)
                $user->loadDevice();
            
            if($user==false)
              $iv = Yii::app()->params['app']['iv'];
            else
              $iv = substr(bin2hex(($user->token)), 0, 16);
            if($user==false)
              $key = Yii::app()->params['app']['key']; 
            else
              $key = substr(bin2hex(($user->token.$user->device->imei)), 0, 16);

            $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

            mcrypt_generic_init($td, $key, $iv);
            $encrypted = mcrypt_generic($td, $str);

            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

            $encrypted = bin2hex($encrypted);
            
            //Errors::log('encrypted:','iv:'.$iv.' key:'.$key, $str);
            //Errors::log('with data:','token:'.$user->token,' imei:'.$user->device->imei);
            
            return $encrypted;
          }
          
          return $str;
        }
     
        public static function decryptPost($user) {
          if(Yii::app()->params['app']['crypt']){
              
            $token = 0;
            $imei=0;
            
            
            if($user!=false && $user->device==false)
                $user->loadDevice();
            
            if($user==false)
              $iv = Yii::app()->params['app']['iv'];
            else{
              $iv = substr(bin2hex($user->token), 0, 16);
              $token = $user->token;
            }

            if($user==false)
              $key = Yii::app()->params['app']['key']; 
            else{
              $key = substr(bin2hex($user->token.$user->device->imei), 0, 16);
              $imei = $user->device->imei;
            }

            $code = self::hex2bin($_POST['data']);  

            $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

            mcrypt_generic_init($td, $key, $iv);
            $decrypted = mdecrypt_generic($td, $code);     
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

            $jsonString = utf8_encode(trim($decrypted));
            $arrayString = json_decode($jsonString, true);

            $_POST = $arrayString;
            //Errors::log('token:'.$token,'imei:'.$imei,print_r($arrayString,true));
          }
        }
     
        public static function hex2bin($hexdata) {
          $bindata = '';
     
          for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
          }
   
          return $bindata;
        }
        
        public static function toBytes($string){
            $bytes = array();
            for($i = 0; $i < strlen($string); $i++){
                 $bytes[] = ord($string[$i]);
            }
            return ($bytes);
        }
}