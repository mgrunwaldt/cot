<?php

class BuilderTypes
{
        public static $STRING = 0;
        public static $SELECT = 1;
        public static $CHECKBOX = 2;
        public static $DATETIME = 3;
        public static $FIXED_STRING = 4;
        public static $SINGLE_FILE = 5;
        public static $CREATED_ON = 6;
        public static $INT = 7;
        public static $FLOAT = 8;
        public static $FIXED_INT = 9;
        public static $FIXED_FLOAT = 10;
        public static $FIXED_BOOLEAN = 11;
        public static $DATE = 12;
        public static $POSITION = 13;
        public static $DELETED = 14;
        public static $UPDATED_ON = 15;
        public static $EMAIL = 16;
        
        public $id;
        public $name;
        public $is_fixed;
        public $can_be_modified_by_user;
        
        public static function getName($id){
        	switch($id){
                        case self::$STRING: 
                                return 'String';
        		break;
                        case self::$SELECT: 
                                return 'Select From Table';
        		break;
                        case self::$CHECKBOX: 
                                return 'Boolean/Checkbox';
        		break;
                        case self::$DATETIME: 
                                return 'Datetime';
        		break;
                        case self::$FIXED_STRING: 
                                return 'Fixed String';
        		break;
                        case self::$SINGLE_FILE: 
                                return 'Single File';
        		break;
                        case self::$CREATED_ON: 
                                return 'Created on';
        		break;
                        case self::$INT: 
                                return 'Integer';
        		break;
                        case self::$FLOAT: 
                                return 'Float';
        		break;
                        case self::$FIXED_INT: 
                                return 'Fixed Integer';
        		break;
                        case self::$FIXED_FLOAT: 
                                return 'Fixed Float';
        		break;
                        case self::$FIXED_BOOLEAN: 
                                return 'Fixed Boolean';
        		break;
                        case self::$DATE: 
                                return 'Date';
        		break;
                        case self::$POSITION: 
                                return 'Position';
        		break;
                        case self::$DELETED: 
                                return 'Deleted';
        		break;
                        case self::$UPDATED_ON: 
                                return 'Updated On';
        		break;
                        case self::$EMAIL: 
                                return 'Email';
        		break;
        	}
                return false;
        }
        
        public static function getAll(){
            $builderTypes = array();
            
            for($i=0; $i<17; $i++){
                $builderType = self::getModel($i);
                $builderTypes[] = $builderType;
            }
            
            return $builderTypes;
        }
        
        public static function getAllArray(){
            $builderTypes = array();
            
            for($i=0; $i<17; $i++){
                $builderType = self::getArray($i);
                $builderTypes[] = $builderType;
            }
            
            return $builderTypes;
        }
        
        public static function getModel($id){
            $model = new BuilderTypes;
            $model->id = $id;
            $model->name = self::getName($id);
            $model->is_fixed = self::isFixed($id);
            $model->can_be_modified_by_user = self::canBeModifiedByUser($id);
            return $model;
        }
        
        public static function getArray($id){
            $model = array();
            $model['id'] = $id;
            $model['name'] = self::getName($id);
            $model['is_fixed'] = self::isFixed($id);
            $model['can_be_modified_by_user'] = self::canBeModifiedByUser($id);
            return $model;
        }
        
        public static function validType($id){
                return in_array($id, array('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16'));
        }
        
        public static function isFixed($id){
                return in_array($id, array(self::$FIXED_BOOLEAN, self::$FIXED_FLOAT, self::$FIXED_INT, self::$FIXED_STRING));
        }
        
        public static function canBeModifiedByUser($id){
                return (!self::isFixed($id) && !in_array($id, array(self::$CREATED_ON, self::$POSITION, self::$DELETED, self::$UPDATED_ON)));
        }
}
?>