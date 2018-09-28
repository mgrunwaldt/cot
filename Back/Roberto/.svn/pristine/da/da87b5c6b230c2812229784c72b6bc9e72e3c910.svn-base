<?php

    class ImageHelper{

        
        
        public static function getFont($fontId,$isBold,$isItalic){
            switch ($fontId){
                case 0:
                    if($isBold && $isItalic)
                        return "fonts/Arial_Bold_Italic.ttf";
                    else if($isBold)
                        return "fonts/Arial_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Arial_Italic.ttf";
                    else
                        return "fonts/Arial.ttf";
                    break;
                case 1:
                    if($isBold && $isItalic)
                        return "fonts/Comic_Sans_MS.ttf";
                    else if($isBold)
                        return "fonts/Comic_Sans_MS_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Comic_Sans_MS.ttf";
                    else
                        return "fonts/Comic_Sans_MS.ttf";
                    break;
                case 2:
                    if($isBold && $isItalic)
                        return "fonts/Georgia_Bold_Italic.ttf";
                    else if($isBold)
                        return "fonts/Georgia_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Georgia_Italic.ttf";
                    else
                        return "fonts/Georgia.ttf";
                    break;
                case 3:
                    if($isBold && $isItalic)
                        return "fonts/Tahoma_Bold_Italic.ttf";
                    else if($isBold)
                        return "fonts/Tahoma_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Tahoma_Italic.ttf";
                    else
                        return "fonts/Tahoma.ttf";
                    break;
                case 4:
                    if($isBold && $isItalic)
                        return "fonts/Times_New_Roman_Bold_Italic.ttf";
                    else if($isBold)
                        return "fonts/Times_New_Roman_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Times_New_Roman_Italic.ttf";
                    else
                        return "fonts/Times_New_Roman.ttf";
                    break;
                case 5:
                    if($isBold && $isItalic)
                        return "fonts/Verdana_Bold_Italic.ttf";
                    else if($isBold)
                        return "fonts/Verdana_Bold.ttf";
                    else if($isItalic)
                        return "fonts/Verdana_Italic.ttf";
                    else
                        return "fonts/Verdana.ttf";
                    break;
            }
        }
        
    public static function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
           $r = hexdec(substr($hex,0,1).substr($hex,0,1));
           $g = hexdec(substr($hex,1,1).substr($hex,1,1));
           $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
           $r = hexdec(substr($hex,0,2));
           $g = hexdec(substr($hex,2,2));
           $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return $rgb; 
     }
     
     public static function wrapText($text, $fontSize, $fontUrl, $boundingBoxWidth){
         $words = explode(' ', $text);
         
         $lines = array();
         $line = '';
         $pos = 0;
         
         foreach ($words as $word) {
             
             if($line != '')
                $newLine = $line.' '.$word;
             else
                 $newLine = $word;
             
             $textImage = new ImagickDraw();
             $textImage->setfont($fontUrl);
             $textImage->setfontsize($fontSize);
             
             $im = new Imagick();
             $metrics = $im->queryFontMetrics ($textImage, $newLine);
             $textwidth = $metrics['textWidth'] + 2 * $metrics['boundingBox']['x1'];
             
             
             if($textwidth <= $boundingBoxWidth-1){
                 $line = $newLine;
             }
             else{
                 
                 $lines[$pos] = $line;
                 $line = $word;
                 $pos++;
             }      
         }
         
         if($line != ''){
             $lines[$pos] = $line;
         }
         
         return $lines;
     }
     
    public static function drawTextLeft($destImage, $font, $fontSize, $wrappedText, $color){

        $textYPos = 0;
        foreach ($wrappedText as $textLine) {

            
            $textImage = new ImagickDraw();
            $textImage->setfont($font);
            $textImage->setfontsize($fontSize);
            $textImage->setfillcolor(new ImagickPixel($color));

            $im = new Imagick();
            $metrics = $im->queryFontMetrics ($textImage, $textLine);
            $baseline = $metrics['boundingBox']['y2'];
            $textHeight = $metrics['textHeight'] + $metrics['descender'];
//            $textWidth = $metrics['textWidth'] + 2 * $metrics['boundingBox']['x1'];
            
//            $im->newimage($textWidth, $textHeight, new ImagickPixel('black'));
//            $im->setImageFormat('png32');
//            $destImage->compositeImage($im, Imagick::COMPOSITE_DEFAULT, 0, 4+$textYPos);

            $destImage->annotateImage($textImage, 0, 4+$baseline+$textYPos, 0, $textLine);

            $textYPos +=$textHeight+5;
        } 
    }
    
    public static function drawTextRight($destImage, $font, $fontSize, $boxWidth, $wrappedText, $color){
        $textYPos = 0;
        foreach ($wrappedText as $textLine) {

            $textImage = new ImagickDraw();
            $textImage->setfont($font);
            $textImage->setfontsize($fontSize);
            $textImage->setfillcolor(new ImagickPixel($color));

            $im = new Imagick();
            $metrics = $im->queryFontMetrics ($textImage, $textLine);
            $baseline = $metrics['boundingBox']['y2'];
            $textHeight = $metrics['textHeight'] + $metrics['descender'];
            $textWidth = $metrics['textWidth'] + 2 * $metrics['boundingBox']['x1'];
            

            $destImage->annotateImage($textImage, $boxWidth-$textWidth, 4+$baseline+$textYPos, 0, $textLine);
            
            $textYPos +=$textHeight+5;
        } 
    }
    
    public static function drawTextCentered($destImage, $font, $fontSize, $boxWidth, $wrappedText, $color){

        $textYPos = 0;
        foreach ($wrappedText as $textLine) {
            
            $textImage = new ImagickDraw();
            $textImage->setfont($font);
            $textImage->setfontsize($fontSize);
            $textImage->setfillcolor(new ImagickPixel($color));

            $im = new Imagick();
            $metrics = $im->queryFontMetrics ($textImage, $textLine);
            $baseline = $metrics['boundingBox']['y2'];
            $textHeight = $metrics['textHeight'] + $metrics['descender'];
            $textWidth = $metrics['textWidth'] + 2 * $metrics['boundingBox']['x1'];
            
            $textXPos = ($boxWidth/2)-($textWidth/2);
            
//            $im->newimage($textWidth, $textHeight, new ImagickPixel('black'));
//            $im->setImageFormat('png32');
//            $destImage->compositeImage($im, Imagick::COMPOSITE_DEFAULT, $textXPos, 4+$textYPos);

            $destImage->annotateImage($textImage, $textXPos, 4+$baseline+$textYPos, 0, $textLine);
            
            $textYPos +=$textHeight+5;
        } 
    }
    

}
    
    
?>