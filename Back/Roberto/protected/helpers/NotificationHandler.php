<?php 

class NotificationHandler
{
    /* This class sends message notifications to devices
     * The deviceIds should come as an array of arrays such as
     * 'ios'=> array of 
     * 'android'=> array of 
     */
    
    public static function pushMessages($data, $regIds){
        return NotificationHandler::notifyAndroidDevices($regIds, $data);
    }

    private static function notifyAndroidDevices($androidRegIds, $message){

        //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $androidRegIds,
            'data' => $message,
        );
        
		define("GOOGLE_API_KEY", "AIzaSyB_72wtrg61_bRkhCv2dJKdJyCHkY4xdyY"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);	
        
        //{"multicast_id":5942116092175857640,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1447444891291428%c8b6d073f9fd7ecd"}]}
        
        if ($result === FALSE) {
             Errors::log("NotificationHandler","notifyAndroidDevices",curl_error($ch));
        }
        curl_close($ch);
        
        return $result;
    }
    
}
?>

		