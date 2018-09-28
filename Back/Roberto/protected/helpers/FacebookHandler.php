<?php

class FacebookHandler {
    
    public static function getLoggedUser($accessToken=false){
        
        Yii::import('application.extensions.*');
        include_once 'facebook/src/facebook.php';
        
        $facebook = new Facebook(array(
            'appId'  => Yii::app()->params['facebook']['appId'],
            'secret'  => Yii::app()->params['facebook']['appSecret'],
        ));
        
        if($accessToken!=false && strlen($accessToken)>5)
            $facebook->setAccessToken($accessToken);
        
        $user = $facebook->getUser();
        
        if($user){
            try {
                $user = $facebook->api('/me');
                $friends = $facebook->api('/me/friends');
                $user['friends'] = $friends;
                return $user;
            } 
            catch (FacebookApiException $e) {
                return false;
            }
        }
        else{
            Alerts::log('FacebookHandler/getLoggedUser', 'No User', 'User:'.print_r($user,true));
            return false;
        }
    }
    
    public static function getPermissions($accessToken=false){
        Yii::import('application.extensions.*');
        include_once 'facebook/src/facebook.php';
        
        $facebook = new Facebook(array(
            'appId'  => Yii::app()->params['facebook']['appId'],
            'secret'  => Yii::app()->params['facebook']['appSecret'],
        ));
        
        if($accessToken!=false && strlen($accessToken)>5)
            $facebook->setAccessToken($accessToken);
        
        $user = $facebook->getUser();
        
        if($user){
            try {
                $permissions = $facebook->api('/me/permissions');
                return $permissions;
            } 
            catch (FacebookApiException $e) {
                return array('Some error');
            }
        }
        else{
            return array('No User');
        }
    }
}
