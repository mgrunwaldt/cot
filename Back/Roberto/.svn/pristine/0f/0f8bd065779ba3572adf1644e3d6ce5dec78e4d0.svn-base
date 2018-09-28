<?php
class CookieHandler{
    public static function set($name, $value){
        $name = Yii::app()->params['cookies']['prefix'].'_'.$name;
        Yii::app()->request->cookies[$name] = new CHttpCookie($name, $value);
    }
    
    public static function get($name){
        $name = Yii::app()->params['cookies']['prefix'].'_'.$name;
        if(isset(Yii::app()->request->cookies[$name])){
            return Yii::app()->request->cookies[$name]->value;
        }
        return false;
    }
    
    public static function delete($name){
        $name = Yii::app()->params['cookies']['prefix'].'_'.$name;
        unset(Yii::app()->request->cookies[$name]);
    }
}
?>