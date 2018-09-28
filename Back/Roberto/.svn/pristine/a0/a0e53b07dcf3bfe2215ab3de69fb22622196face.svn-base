<?php

class BarCodesHandler {
    
    public static function generate($userCode){
        
        require_once Yii::app()->basePath.'/extensions/barcodegen/class/BCGcode128.barcode.php';    
        require_once Yii::app()->basePath.'/extensions/barcodegen/class/BCGFontFile.php';    
        require_once Yii::app()->basePath.'/extensions/barcodegen/class/BCGColor.php';    
        require_once Yii::app()->basePath.'/extensions/barcodegen/class/BCGDrawing.php';  
        
        
        // Barcode Part
        $code = new BCGcode128();
        $code->setScale(2);
        $code->setThickness(80);
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $code->setForegroundColor($color_black);
        $code->setBackgroundColor($color_white);
        $code->parse($userCode);

        $name=  HelperFunctions::genRandomString(20);
        $imagePath = 'files/barcodes/'.$name.'.jpg';
        // Drawing Part
        $drawing = new BCGDrawing($imagePath, $color_white);
        $drawing->setBarcode($code);
        $drawing->setDPI(300);
        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
        
        $file=Files::create($name, $name, '/files/barcodes/'.$name.".jpg", FileTypes::$IMAGE, 'barCode');
        
        if(count($file->getErrors())==0)
            return $file;
        else
            return false;
    }
    
   
}
