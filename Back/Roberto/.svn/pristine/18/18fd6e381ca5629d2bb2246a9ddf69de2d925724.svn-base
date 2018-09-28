<?php

class UserCategories
{
        public static $LEAD = 1;
        public static $INTERESTED = 2;
        public static $WAITING_FOR_SIGNATURE = 3;
        public static $SIGNED = 4;
        
        public $id;
        public $name;
        
        public static function getName($id){
        	switch($id){
                        case self::$LEAD: 
                                return 'Lead';
        		break;
                        case self::$INTERESTED: 
                                return 'Interesado';
        		break;
                        case self::$WAITING_FOR_SIGNATURE:
                            return 'Falta Firma';
                        break;
                        case self::$SIGNED:
                            return 'Firmado';
                        break;
        	}
                return false;
        }
        
        public static function getModel($id){
            $model = new UserCategories;
            $model->id = $id;
            $model->name = self::getName($id);
            return $model;
        }
        
        public static function getArray($id){
            $model = array();
            $model['id'] = $id;
            $model['name'] = self::getName($id);
            return $model;
        }
        
        public static function getAll(){
            $modelsArray = array();
            for($i=1; $i<5; $i++)
                $modelsArray[] = self::getModel($i);
            
            return $modelsArray;
        }
        
        public static function getAllArray(){
            $modelsArray = array();
            for($i=1; $i<5; $i++)
                $modelsArray[] = self::getArray($i);
            
            return $modelsArray;
        }
        
        public static function validId($id){
            return in_array($id, array(1,2,3,4));
        }
}
?>