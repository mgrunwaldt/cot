<?php

class AdministratorRoles
{
        public static $SUPER_ADMIN= 1;
        public static $OWNER = 2;
        public static $EMPLOYEE = 3;
        public static $SAMSUNG = 4;
        
        public $id;
        public $name;
        
        public static function getName($id){
        	switch($id){
                        case self::$SUPER_ADMIN: 
                                return 'Superadmin';
        		break;
                        case self::$OWNER: 
                                return 'Owner';
        		break;
                        case self::$EMPLOYEE: 
                                return 'Employee';
        		break;
                        case self::$SAMSUNG: 
                                return 'Samsung';
        		break;
        	}
                return false;
        }
        
        public static function getModel($id){
            $model = new AdministratorRoles;
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