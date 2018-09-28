<?php

class FileTypes extends CActiveRecord
{
        public static $IMAGE = 1;
        public static $VIDEO = 2;
        public static $DOC = 3;
        public static $YOUTUBE_VIDEO = 4;
        public static $URL_IMAGE = 5;
        
        public static function getName($id){
        	switch($id){
                        case self::$IMAGE: 
                                return 'Image';
        		break;
                        case self::$VIDEO: 
                                return 'Video';
        		break;
                        case self::$DOC: 
                                return 'Doc';
        		break;
                        case self::$YOUTUBE_VIDEO: 
                                return 'Youtube Video';
        		break;
                        case self::$URL_IMAGE: 
                                return 'URL Image';
        		break;
        	}
                return false;
        }
        
        
        public static function getTypeFromExtension($extension){
        	switch($extension){
                        case 'png': 
                        case 'bmp': 
                        case 'gif': 
                        case 'jpg': 
                        case 'jpeg': 
                                return self::$IMAGE;
        		break;
                        case 'mov': 
                        case 'mp4': 
                        case 'mpg': 
                        case 'mpeg': 
                                return self::$VIDEO;
        		break;
                        case 'doc': 
                        case 'docx': 
                        case 'xls': 
                        case 'xlss': 
                        case 'ppt': 
                        case 'pps': 
                        case 'pdf': 
                        case 'zip': 
                        case 'rar': 
                                return self::$DOC;
        		break;
        	}
                return false;
        }
        
        public static function getAllIds(){
                return array('1','2','3');
        }
        
        public static function getAllURLIds(){
                return array('4');
        }
        
        public static function validFileType($id){
                return in_array($id, array('1','2','3','4','5'));
        }
        
        public static function getExtensionFromMimeType($typeId){
            switch ($typeId)
            {
                case IMAGETYPE_GIF:
                    return '.gif';

                case IMAGETYPE_JPEG:
                    return '.jpg';

                case IMAGETYPE_PNG:
                    return '.png';

                default:
                    return '.png';
            }
        }
}
?>