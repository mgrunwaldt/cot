<?php

class QrCodesHandler {
    
    public static function generate($userCode){
        
        Yii::import('application.extensions.*');
        include_once 'qrcodes/phpqrcode.php';
        
        $path = Yii::app()->basePath.'/../public_html/files/qrcodes/';
        $name=  HelperFunctions::genRandomString(20);
        
        QRcode::png($userCode,$path.$name.".png",QR_ECLEVEL_L, 14, 0); 
        
        $file=Files::create($name, $name, '/files/qrcodes/'.$name.".png", FileTypes::$IMAGE, 'qrCode');
        
        if(count($file->getErrors())==0)
            return $file;
        else
            return false;
        
    }
    
   
}
