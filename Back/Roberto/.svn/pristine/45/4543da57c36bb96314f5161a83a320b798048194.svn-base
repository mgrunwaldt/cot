<?php
class MailchimpHelper
{   
    public static function subscribe($user){
        $url = Yii::app()->params['mailchimp']['endpoint'].'lists/subscribe';
        $id = Yii::app()->params['mailchimp']['allList'];
                
        $postData = array(
            'apikey'=>Yii::app()->params['mailchimp']['apiKey'],
            'id'=>$id,
            'email'=>array(
                'email'=>$user->email
            ),
            'merge_vars'=>array(
                'FNAME'=>$user->name, 
                'PHONE'=>$user->phone,
                'ESTADO'=>UserCategories::getName($user->category_id),
            ),
            'email_type'=>'html',
            'double_optin'=>'false',
            'update_existing'=>'false',
            'replace_interests'=>'false',
            'send_welcome'=>'false',
        );
        
        $jsonResponse = HelperFunctions::postRequest($url, json_encode($postData), false);
        $arrayResponse = json_decode($jsonResponse);
        if(isset($arrayResponse->email) && isset($arrayResponse->euid) && isset($arrayResponse->leid)){
            $user->added_to_mailchimp = 1;
            $user->save();
            return true;
        }else{
            Errors::log('Error in HelperFunctions/MailchimpHelper/subscribe', 'Error subscribing user to mailchimp', 'Response:'.$jsonResponse);
            Alerts::log('Error in HelperFunctions/MailchimpHelper/subscribe', 'Error subscribing user to mailchimp', 'Response:'.$jsonResponse);
            if(strlen($jsonResponse)>10){
                $user->added_to_mailchimp = 0;
                $user->save();
            }
        }
        return false;
    }  
    
    public static function update($user){
        $url = Yii::app()->params['mailchimp']['endpoint'].'lists/update-member';
        $postData = array(
            'apikey'=>Yii::app()->params['mailchimp']['apiKey'],
            'id'=>Yii::app()->params['mailchimp']['allList'],
            'email'=>array(
                'email'=>$user->email
            ),
            'merge_vars'=>array(
                'FNAME'=>$user->name, 
                'PHONE'=>$user->phone,
                'ESTADO'=>UserCategories::getName($user->category_id),
            ),
            'email_type'=>'html',
            'double_optin'=>'false',
            'update_existing'=>'false',
            'replace_interests'=>'false',
            'send_welcome'=>'false',
        );
        
        $jsonResponse = HelperFunctions::postRequest($url, json_encode($postData), false);
        $arrayResponse = json_decode($jsonResponse);
        if(isset($arrayResponse->email) && isset($arrayResponse->euid) && isset($arrayResponse->leid)){
            $user->added_to_mailchimp = 1;
            $user->save();
            return true;
        }else{
            Errors::log('Error in HelperFunctions/MailchimpHelper/update', 'Error updating user to mailchimp', 'Response:'.$jsonResponse);
            Alerts::log('Error in HelperFunctions/MailchimpHelper/update', 'Error updating user to mailchimp', 'Response:'.$jsonResponse);
            if(strlen($jsonResponse)>10){
                $user->added_to_mailchimp = 0;
                $user->save();
            }
        }
        return false;
    }
}
?> 