<?php

class HelperFunctions
{
    /*
    $words = array(array('A','B'),array('C','D'), array('E','F'));

    $combos = combinations($words,0);  // ALWAYS, call it with 0 as the last parameter
    print_r($combos);
    
    Array
    (
        [0] => A C E
        [1] => A C F
        [2] => A D E
        [3] => A D F
        [4] => B C E
        [5] => B C F
        [6] => B D E
        [7] => B D F
    )*/
    
    public static function specialCombinations($arr, $n){
        $res = self::specialCombinationsAux($arr, $n);
        $finalresult = array();
        foreach($res as $string)
            $finalresult[] = explode(' ', $string);
        return $finalresult;
    }
    
    public static function specialCombinationsAux($arr, $n){
        $res = array();

        foreach ($arr[$n] as $item)
        {
            if ($n==count($arr)-1)
                $res[]=$item;
            else
            {
                $combs = self::specialCombinationsAux($arr,$n+1);

                foreach ($combs as $comb)
                {
                    $res[] = $item.' '.$comb;
                }
            }
        }
        
        return $res;
    }
    
    
    
    public static function encrypt($string, $certificate, $vector){
        //CREO UNA LLAVE PARA, JUNTO CON EL VECTOR, ENCRIPTAR SIMETRICAMENTE EL STRING 
        $key = HelperFunctions::genRandomString(16);
        $encryptedString = self::SimmetricEncrypt($string, $key, $vector);
        $encryptedKey = self::SSLEncrypt($key, $certificate);
        
        return array(
            'key'=>$encryptedKey,
            'string'=>$encryptedString,
        );
    }
    public static function decrypt($encryptedKey, $encryptedString, $certificate, $vector){
        //TOMO LA LLAVE
        $key = self::SSLDecrypt($encryptedKey, $certificate);
        //LA USO PARA AGARRAR EL STRING
        $string = self::SimmetricDecrypt($encryptedString, $key, $vector);
        
        return $string;
    }
    
    public static function SSLEncrypt($string, $certificate){
        //VOY A BUSCAR EL CERTIFICADO Y LA LLAVE PUBLICA
        $certificateFile = fopen($certificate,"r");
        $publicKey = fread($certificateFile,8192);
        fclose($certificateFile);
        $publicKey = openssl_get_publickey($publicKey);
        if(!$publicKey){
            Errors::log('Error in HelperFunctions/encrypt', 'Not a valid public key', '');
            return false;
        }
        
        //ENCRIPTO
        $encryptedString="";
        if(openssl_public_encrypt($string, $encryptedString, $publicKey, OPENSSL_PKCS1_PADDING)){
            openssl_free_key($publicKey);
            //ENCODE BASE 64 Y SPECIAL CHARS
            $encryptedString = base64_encode($encryptedString);
            $encryptedString = ereg_replace('(/)','_',$encryptedString);
            $encryptedString = ereg_replace('(\+)','-',$encryptedString);
            $encryptedString = ereg_replace('(=)','.',$encryptedString);
            return $encryptedString;
        }
        else{
            $errorMessage = 'String';
            while($msg = openssl_error_string()){
                $errorMessage .= " - ERROR: " . $msg; 
            }
            Errors::log('Error in HelperFunctions/SSLEncrypt', 'Couldnt Encrypt String', $errorMessage);
            return false;
        }
    }
    
    public static function SSLDecrypt($encryptedString, $certificate){
        //DECODE BASE 64 Y SPECIAL CHARS
        $encryptedString = ereg_replace('_','/',$encryptedString);
        $encryptedString = ereg_replace('-','+',$encryptedString);
        $encryptedString = ereg_replace('\.','=',$encryptedString);
        $encryptedString = base64_decode($encryptedString);
        
        //VOY A BUSCAR EL CERTIFICADO Y LA LLAVE PRIVADA
        $certificateFile = fopen($certificate,"r");
        $privateKey = fread($certificateFile,8192);
        fclose($certificateFile);
        $privateKey = openssl_get_privatekey($privateKey);
        if(!$privateKey){
            Errors::log('Error in HelperFunctions/decrypt', 'Not a valid public key', '');
            return false;
        }
        
        //DECRIPTO
        $string="";
        if(openssl_private_decrypt($encryptedString, $string, $privateKey, OPENSSL_PKCS1_PADDING)){
            openssl_free_key($privateKey);
            return $string;
        }
        else{
            $errorMessage = 'String';
            while($msg = openssl_error_string()){
                $errorMessage .= " - ERROR: " . $msg; 
            }
            Errors::log('Error in HelperFunctions/SSLDecrypt', 'Couldnt decrypt String', $errorMessage);
            return false;
        }
    }
    
    public static function SimmetricEncrypt($string, $key, $vector){
        $binaryVector = pack("H*", $vector);
        
        $key .= substr($key,0,8);
        
        $blockSize = mcrypt_get_block_size('tripledes', 'cbc');
        $stringLength = strlen($string);
        $padding = $blockSize - ($stringLength % $blockSize);
        $string .= str_repeat(chr($padding),$padding);
        
        $encryptedString = mcrypt_encrypt(MCRYPT_3DES, $key, $string, MCRYPT_MODE_CBC, $binaryVector);
        
        //ENCODE BASE 64 Y SPECIAL CHARS
        $encryptedString = base64_encode($encryptedString);
        $encryptedString = ereg_replace('(/)','_',$encryptedString);
        $encryptedString = ereg_replace('(\+)','-',$encryptedString);
        $encryptedString = ereg_replace('(=)','.',$encryptedString);

        return $encryptedString;
    }
    
    public static function SimmetricDecrypt($encryptedString, $key, $vector){
        //DECODE BASE 64 Y SPECIAL CHARS
        $binaryVector = pack("H*", $vector);
        
        $key .= substr($key,0,8);
        
        $encryptedString = ereg_replace('_','/',$encryptedString);
        $encryptedString = ereg_replace('-','+',$encryptedString);
        $encryptedString = ereg_replace('\.','=',$encryptedString);
        $encryptedString = base64_decode($encryptedString);
        
        $string = mcrypt_decrypt(MCRYPT_3DES, $key, $encryptedString, MCRYPT_MODE_CBC, $binaryVector);
        $blockSize = mcrypt_get_block_size('tripledes', 'cbc');
        $packing = ord($string{strlen($string) - 1});
        if($packing and ($packing < $blockSize))
        {
                for($P = strlen($string) - 1; $P >= strlen($string) - $packing; $P--)
                {
                        if(ord($string{$P}) != $packing)
                        {
                                $packing = 0;
                        }
                }
        }

        $string = substr($string,0,strlen($string) - $packing);
        
        return $string;
    }
    
    public static function prepareToLink($text){
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '_', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($text, ENT_QUOTES, 'UTF-8'))), '_'));
    }
    
    public static function getErrorsFromModel($model){
        $message = 'Por favor corrija los siguientes errores:</br>

';
        if($model->hasErrors()){
            $errors = $model->getErrors();
            
            foreach($errors as $error){
                $message .= html_entity_decode($error[0]).'</br>
';
            }
        }
        
        return $message;
    }
    
    public static function nearestWeekday($date){
        $dateText = HelperFunctions::dateToSpanish($date);
        if(strpos($dateText, 'Sábado')!==false)
                $date = self::addSecondsToDate($date, (-1)*24*60*60);
        else if(strpos($dateText, 'Domingo')!==false)
                $date = self::addSecondsToDate($date, 1*24*60*60);
        return $date;
    }
    
    public static function breakDate($date){
        $returnArray = array(
                    'year'=>'0000',
                    'month'=>'00',
                    'day'=>'00',
                    'hour'=>'00',
                    'minute'=>'00',
                    'second'=>'00',
        );
        
        $dateArray = explode('-',$date);

        $returnArray['year'] = $dateArray[0];
        $returnArray['month'] = $dateArray[1];
        $dayArray = explode(' ',$dateArray[2]);
        $returnArray['day'] = $dayArray[0];

        if(strlen($returnArray['day'])==1)
            $returnArray['day'] = '0'.$returnArray['day'];
        if(strlen($returnArray['month'])==1)
            $returnArray['month'] = '0'.$returnArray['month'];
        
        if(strpos($date, ':')){
            $timeArray = explode(':',$dateArray[1]);
            
            $returnArray['hour'] = $timeArray[0];
            $returnArray['minute'] = $timeArray[1];
            $returnArray['second'] = $timeArray[2];
        }
        
        return $returnArray;
    }
        public static function modelToArray($model, $purify=true){
            if(isset($model->id)){
                $modelArray = array();
                $modelAttributes = $model->getAttributes($model->safeAttributeNames);

                if(isset($model->id))
                    $modelArray['id'] = $model->id; 
                foreach($modelAttributes as $name=>$value){
                    if($purify)
                        $modelArray[$name] = self::purify($value); 
                }

                return $modelArray;
            }
            else
                return array();
        }
        
        public static function checkSessionLost($order){
            if(!isset($_SESSION['session_user_id'])){
                $user = Users::get($order->user_id);
                if($user!==false){
                    if($user->login()){                                        
                        return 2;
                    } 
                    else
                        return 3;
               }
                else
                    return 4;
            }
            else
                return 1;
        }
        
        public static function SQLInjectionCheck($text){
            $text = str_replace('"', '', $text);
            $text = str_replace("'", "", $text);
            return $text;
        }
        
        public static function getReferrer(){
            if(isset($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER'])>0)
                return $_SERVER['HTTP_REFERER'];
            else
                return 'no';
        }
    
	public static function dateToSpanish($origDate){
		//if(date("l d F Y",strtotime($origDate))==date("l d F Y", strtotime(self::getDate()))){
		//	$spanishDate = 'Hoy '.date("H:i",strtotime($origDate));
		//}
		//else if(date("l d F Y",strtotime($origDate))==date("l d F Y", (strtotime(self::getDate()))-(60*60*24))){
		//	$spanishDate = 'Ayer '.date("H:i",strtotime($origDate));
		//}
		//else{
			//$spanishDate = date("l d F Y H:i",strtotime($origDate));
		//}
		
                $spanishDate = date("l d F Y",strtotime($origDate));
                        
		$spanishDate = str_ireplace('Monday', 'Lunes', $spanishDate);
		$spanishDate = str_ireplace('Tuesday', 'Martes', $spanishDate);
		$spanishDate = str_ireplace('Wednesday', 'Miércoles', $spanishDate);
		$spanishDate = str_ireplace('Thursday', 'Jueves', $spanishDate);
		$spanishDate = str_ireplace('Friday', 'Viernes', $spanishDate);
		$spanishDate = str_ireplace('Saturday', 'Sábado', $spanishDate);
		$spanishDate = str_ireplace('Sunday', 'Domingo', $spanishDate);

		$spanishDate = str_ireplace('January', 'de enero de', $spanishDate);
		$spanishDate = str_ireplace('February', 'de febrero de ', $spanishDate);
		$spanishDate = str_ireplace('March', 'de marzo de', $spanishDate);
		$spanishDate = str_ireplace('April', 'de abril de ', $spanishDate);
		$spanishDate = str_ireplace('May', 'de mayo de', $spanishDate);
		$spanishDate = str_ireplace('June', 'de junio de', $spanishDate);
		$spanishDate = str_ireplace('July', 'de julio de', $spanishDate);
		$spanishDate = str_ireplace('August', 'de agosto de', $spanishDate);
		$spanishDate = str_ireplace('September', 'de setiembre de', $spanishDate);
		$spanishDate = str_ireplace('October', 'de octubre de', $spanishDate);
		$spanishDate = str_ireplace('November', 'de noviembre de', $spanishDate);
		$spanishDate = str_ireplace('December', 'de diciembre de', $spanishDate);
		
		
		return $spanishDate;
	}
	
	public static function formatDate($origDate){
		if(date("l d F Y",strtotime($origDate))==date("l d F Y", strtotime(self::getDate()))){
			$spanishDate = 'Hoy, '.date("H:i",strtotime($origDate));
		}
		else if(date("l d F Y",strtotime($origDate))==date("l d F Y", (strtotime(self::getDate()))-(60*60*24))){
			$spanishDate = 'Ayer, '.date("H:i",strtotime($origDate));
		}
		else{
			$spanishDate = date("d-F-Y",strtotime($origDate));
		}
		
		$spanishDate = str_ireplace('January', 'Enero', $spanishDate);
		$spanishDate = str_ireplace('February', 'Febrero', $spanishDate);
		$spanishDate = str_ireplace('March', 'Marzo', $spanishDate);
		$spanishDate = str_ireplace('April', 'Abril', $spanishDate);
		$spanishDate = str_ireplace('May', 'Mayo', $spanishDate);
		$spanishDate = str_ireplace('June', 'Junio', $spanishDate);
		$spanishDate = str_ireplace('July', 'Julio', $spanishDate);
		$spanishDate = str_ireplace('August', 'Agosto', $spanishDate);
		$spanishDate = str_ireplace('September', 'Setiembre', $spanishDate);
		$spanishDate = str_ireplace('October', 'Octubre', $spanishDate);
		$spanishDate = str_ireplace('November', 'Noviembre', $spanishDate);
		$spanishDate = str_ireplace('December', 'Diciembre', $spanishDate);
		
		
		return $spanishDate;
	}
	
	public static function getIP()
	{
            if(isset($_SERVER['REMOTE_ADDR']))
                return $_SERVER['REMOTE_ADDR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            else return false;
        }
        
	public static function getDate(){
                date_default_timezone_set('America/Montevideo');
		$timestamp_of_date = time();
                
                $hourChange = 0;
                
		$new_hour = $timestamp_of_date + ($hourChange*60*60);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function addDaysToToday($daysToAdd){
                date_default_timezone_set('America/Montevideo');
		$timestamp_of_date = time();
		$new_hour = $timestamp_of_date + ($daysToAdd*24*60*60);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function addHoursToToday($hoursToAdd){
                date_default_timezone_set('America/Montevideo');
		$timestamp_of_date = time();
		$new_hour = $timestamp_of_date + ($hoursToAdd*60*60);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function addMinutesToToday($minutesToAdd){
                date_default_timezone_set('America/Montevideo');
		$timestamp_of_date = time();
		$new_hour = $timestamp_of_date + ($minutesToAdd*60);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function addSecondsToToday($secondsToAdd){
                date_default_timezone_set('America/Montevideo');
		$timestamp_of_date = time();
		$new_hour = $timestamp_of_date + ($secondsToAdd);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function addSecondsToDate($date, $secondsToAdd){
		$timestamp_of_date = strtotime($date);
		$new_hour = $timestamp_of_date + ($secondsToAdd);
		return date('Y-m-d H:i:s', $new_hour);
	}
        
	public static function sendEmail($subject, $text){
            $params = array(
                    'to' => "burgosmatias@hotmail.com",
                    'subject' => 'WEB: '.$subject, 
                    'body' => $text,
                    'from' => "juan@juanconstruye.com.uy", 
            );
            
            $mail = new phpmailer();
            $mail->IsSMTP(); 
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
	    $mail->Port = 25;
	    $mail->SetFrom($params['from'], "Juan");
            $mail->AddAddress($params['to']);
            $mail->Subject = $params['subject'];
            $mail->Body = $params['body'];
            $mail->IsHTML(true);
            $mail->CharSet = "UTF-8";
            try{
                $mail->Host = "server.moonideas.com";
                $mail->Username = "moonideas@moonideas.com";
                $mail->Password = "F~$1k#,NV{Cm";
                if($mail->send())
                    return 'enviado';
                else
                    return 'error';
            }
            catch(Exception $e){
                print_r($e);
            }
        }
        
	public static function genRandomString($length) {
		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}

		return $string;
	}
        
	public static function genRandomPassword($restrictions=array()) {
		
		$numbers = '0123456789';
                $letters ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $specialChars="_.,=)(/&%!'!-";
		$string = '';

		for ($p = 0; $p < 5; $p++)
			$string .= $letters[mt_rand(0, strlen($letters)-1)];
                
		for ($p = 0; $p < 3; $p++)
			$string .= $numbers[mt_rand(0, strlen($numbers)-1)];
                
		for ($p = 0; $p < 3; $p++)
			$string .= $specialChars[mt_rand(0, strlen($specialChars)-1)];
                
                //mix
		for($p = 0; $p < 100; $p++) {
			$from = mt_rand(0, strlen($string)-1);
			$to = mt_rand(0, strlen($string)-1);
                        
			$aux = $string[$to];
                        $string[$to] = $string[$from];
                        $string[$from] = $aux;
		}
                
                while(!self::validPassword($string, $restrictions))
                    $string = self::genRandomPassword($restrictions);

		return $string;
	}
        
        public static function validPassword($password, $restrictions) {
            $numbers = '0123456789';
            $letters ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $spaces = '  
';
            //3 types of characters & spaces
            $hasLetter = false;
            $hasNumber = false;
            $hasSpecial = false;
            $hasSpaces = false;
            
            for($i=0; $i<strlen($password); $i++){
                if(strpos($letters, $password[$i])!==false)
                    $hasLetter = true;
                else if(strpos($numbers, $password[$i])!==false)
                    $hasNumber = true;
                else if(strpos($spaces, $password[$i])!==false)
                    $hasSpaces = true;
                else
                    $hasSpecial = true;
            }
            
            //consecutive and repeated
            
            $hasConsecutiveCharacters = false;
            $hasRepeatedCharacters = false;
            /*for($i=0; $i<strlen($password)-4; $i++){
                $character = $password[$i];
                $next4Characters = $character.$password[$i+1].$password[$i+2].$password[$i+3];
                if(strpos($letters, $character)!==false || strpos($numbers, $character)!==false){
                    if(strpos('789xyzXYZ',$character)===false){
                        if(strpos($letters, $character)!==false){
                            $positionOfCharacter = strpos($letters, $character);
                            $fourConsecutiveCharacters = $character.$letters[$positionOfCharacter+1].$letters[$positionOfCharacter+2].$letters[$positionOfCharacter+3];
                        }
                        
                        if(strpos($numbers, $character)!==false){
                            $positionOfCharacter = strpos($numbers, $character);
                            $fourConsecutiveCharacters = $character.$numbers[$positionOfCharacter+1].$numbers[$positionOfCharacter+2].$numbers[$positionOfCharacter+3];
                        }
                        
                        if($next4Characters==$fourConsecutiveCharacters){
                            $hasConsecutiveCharacters = true;
                        }
                    }
                }
                if($next4Characters==$character.$character.$character.$character){
                    $hasRepeatedCharacters = true;
                }
            }*/
            
            //restrictions
            $hasRestrictions = false;
            /*foreach($restrictions as $restriction){
                if(strpos($password,$restriction)!==false)
                    $hasRestrictions = true;
            }
            */
            //length
            $isLongEnough = strlen($password)>7;
            
            /*if(!$hasLetter)
                echo('doesnt have letter');
            if(!$hasNumber)
                echo('doesnt have number');
            if(!$hasSpecial)
                echo('doesnt have special');
            if($hasSpaces)
                echo('has spaces');
            if($hasConsecutiveCharacters)
                echo('has consecutive characters');
            if($hasRepeatedCharacters)
                echo('has repeated characters');
            if($hasRestrictions)
                echo('has restrictons');
            if(!$isLongEnough)
                echo('not long enough');*/
            
            
            if($hasLetter && $hasNumber && $hasSpecial && !$hasSpaces & !$hasConsecutiveCharacters & !$hasRepeatedCharacters && !$hasRestrictions && $isLongEnough)
                return true;
            
            return false;
        }
    
    public static function genRandomCode($length) {
		
		$characters = '234679ACDEFGHJKMNPQRTUVWXYZ';
		$string = '';

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}

		return $string;
	}
       
        
	public static function getRandomNumber($length) {
		
		$characters = '0123456789';
		$string = '';

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}

		return $string;
	}
        
        public static function secondsBetweenDates($date1,$date2){
                $date1=  strtotime($date1);                 
                $date2= strtotime($date2);                  
                return abs($date1-$date2);
	}
        
         public static function getBrowser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
			
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
			
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
			
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
			
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
			
		return $bname.'|'.$version.'|'.$platform;
                
                /*array(
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern
		);*/
	}
        
        public static function setCookieParam($name, $value){
            $cookieArray = self::getCookie();
            if($cookieArray===false){
                $cookieArray = array();
                $cookieArray[$name] = $value;
            }
            $cookie = new CHttpCookie(Yii::app()->params['cookie']['name'],$cookieArray);
            $cookie->expire = time() + (60*60*24*60);
            
            Yii::app()->request->cookies[Yii::app()->params['cookie']['name']] = $cookie;
        }
        
        public static function getCookieParam($param){
            $cookieArray = self::getCookie();
            if($cookieArray!==false && isset($cookieArray[$param]))
                return $cookieArray[$param];
            
            return false;
        }
        
        public static function getCookie(){
            return (isset(Yii::app()->request->cookies[Yii::app()->params['cookie']['name']]) ? Yii::app()->request->cookies[Yii::app()->params['cookie']['name']]->value : false);
        }
        
        public static function deleteCookieParam($name){
            self::setCookieParam($name, false);
        }
        
        public static function postRequest($url, $data, $ssl=false){
           $curl = curl_init();
           curl_setopt($curl, CURLOPT_URL, $url);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt($curl, CURLOPT_POST, true);

           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
           
           if($ssl){
                curl_setopt($curl, CURLOPT_SSLCERT, Yii::app()->basePath.'/data/wholelabels.pem');
                curl_setopt($curl, CURLOPT_SSLVERSION,3);
                curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
           }
           
           //curl_setopt($curl, CURLOPT_HEADER, 0);
           //curl_setopt($curl, CURLOPT_INTERFACE, '192.252.218.27');
           $output = curl_exec($curl);

           if(curl_errno($curl)){
               Errors::log("Error en /HelperFunctions/postRequest",'Error: '.curl_error($curl),$url.' '.print_r($data,true));
               Alerts::log("Error en /HelperFunctions/postRequest",'Error: '.curl_error($curl),$url.' '.print_r($data,true));
           }
           
           curl_close($curl);
           
           return $output;
       }
        
        public static function getRequest($url, $data){
           $count = 0;
           foreach($data as $key=>$val){
               if($count==0)
                    $url .= '?';
                else
                    $url .= '&';
               
               $url .= $key.'='.$val;
               $count++;
           }
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           //curl_setopt($ch, CURLOPT_HEADER, 0);
           //curl_setopt($ch, CURLOPT_INTERFACE, '192.252.218.27');

           $output = curl_exec($ch);

           curl_close($ch);
           
           return $output;
       }
       

        public static function ipToCountry($ip) {
    //        $info = file_get_contents("http://www.whois.com/whois/$ip");
    //        $countryArray = explode('country:', $info);
    //        $country = explode('
    //', $countryArray[1]);
    //        $country = stripcslashes($country[0]);
    //        return trim($country);

            /*$info = file_get_contents("http://who.is/whois-ip/ip-address/$ip");
            $countryArray = explode('country:', $info);
            $country = explode('phone',$countryArray[1]);
            $country = stripcslashes($country[0]);
            return  $country;*/
        
        
            $output = '';
            $data = json_decode(self::getRequest("http://www.geoplugin.net/json.gp?ip=" . $ip,array()));
            if(isset($data->geoplugin_countryCode)){
                $output = $data->country_code;
            }
            else{
                $data = json_decode(self::getRequest('freegeoip.net/json/'.$ip,array()));
                if(isset($data->country_code)){
                    $output = $data->country_code;
                }
            }
            return $output;
        }
       
       
        public static function addStops($number){
            $numberString = '';
            $counter = 0;
            
            $number = explode('.',$number);
            
            $units = $number[0];
            $cents = '';
            
            if(count($number)>1){
                $cents = $number[1];
                if(strlen($cents)>2){
                    $centsAux = substr($cents, 0, 2).'.'.substr($cents, 2, strlen($cents)-2);
                    $cents = ','.round($centsAux);
                }
                else if(strlen($cents)===1){
                    $cents = ','.$cents.'0';
                }
                else{
                    $cents = ','.$cents;
                }
            }

            for($i=strlen($units)-1; $i>-1; $i--){
                    if($counter===3){
                        $numberString = '.'.$numberString;
                        $counter=0;
                    }
                    
                    $counter++;
                    
                    $numberString = substr($units, $i, 1) . $numberString;
            }
            
            $numberString = $numberString . $cents;
            
            return $numberString;
        }

        public static function isBot($ip){
            if(strlen($ip) < 7){
                return true;
            }
            $bigBots = array(
                //GOOGLE
                '37.58.100.',
                //CHINA?baiduspider
                '180.76.5.',
                '180.76.6.',

                //Microsoft
                '157.55.39.',

                //Beijing Baidu Netcom Science and Technology
                '119.63.193.',

                //Facebook
                '69.171.234.',
            );

            $bots = array(

                //GOOGLE
                '66.249.66.176',

                '66.249.70.96',

                '66.249.74.69',
                '66.249.74.200',

                '66.249.76.96',
                '66.249.76.201',

                '66.249.79.20',
                '66.249.79.137',
                '66.249.79.150',

                '66.71.247.10',


                //AMAZON
                '54.83.133.24',
                '54.87.124.',
                '54.205.74.178',
                '54.226.198.185',
                '54.226.109.129',
                '54.242.164.27',
                '54.221.84.149',

                //NASHNET
                '94.244.139.199',

                //LeaseWeb
                '95.211.138.10',

                //Robert Bentley, Synergyworks
                '91.197.32.185',

                //Virtacore Systems
                '74.204.172.210',

                //Linode ISP
                '74.207.252.212',

                //Redstation Limited
                '31.3.233.120',

                //free tics
                '200.68.124.129',

                //Yandex
                '199.21.99.197',

                //SingleHop
                '198.20.70.114',

                //ENTEL CHILE S.A
                '186.67.35.171',

                //FACEBOOK
                '173.252.100.112',

            );
            $preIp = explode('.', $ip);
            $preIp = $preIp[0].'.'.$preIp[1].'.'.$preIp[2].'.';

            if(in_array($preIp, $bigBots))
                return true;

            return in_array($ip, $bots);
        }
        
        public static function ReplaceSpecialCharacters($text){
           
            $entities = array("ñ"=>"&ntilde;","Ñ"=>"&Ntilde;",
                                "á"=>"&aacute;","é"=>"&eacute;",
                                "í"=>"&iacute;","ó"=>"&oacute;",
                                "ú"=>"&uacute;","Á"=>"&Aacute;",
                                "É"=>"&Eacute;","Í"=>"&Iacute;",
                                "Ó"=>"&Oacute;","Ú"=>"&Uacute;");
            
            $text=str_replace("&aacute;;", "á",$text);
            $text=str_replace("&eacute;", "é",$text);
            $text=str_replace("&iacute;", "í",$text);
            $text=str_replace("&oacute;", "ó",$text);
            $text=str_replace("&uacute;", "ú",$text);
                        
            return $text;
       }
       
       
       public static function getMaxFitSize($width, $height, $maxWidth, $maxHeight){
            $returnObj = [];

            if($width==0)
                $width = 1;
            if($height==0)
                $height = 1;
            if($maxWidth==0)
                $maxWidth = 1;
            if($maxHeight==0)
                $maxHeight = 1;
            
            $returnObj['width'] = 0;
            $returnObj['height'] = 0;

            if($width/$maxWidth > $height/$maxHeight){
                $returnObj['width'] = $maxWidth;
                $returnObj['height'] = $height * $maxWidth / $width;
            }
            else{
                $returnObj['height'] = $maxHeight;
                $returnObj['width'] = $width * $maxHeight / $height;
            }
            
            $returnObj['top'] = ($maxHeight/2) - ($returnObj['height']/2);
            $returnObj['left'] = ($maxWidth/2) - ($returnObj['width']/2);

            return $returnObj;
        }
        
        public static function isMobileApp(){
            if(isset($_SERVER['HTTP_USER_AGENT']))
                return false;
            else  
                return true;
        }
       
        public static function purify($str){
            $p = new CHtmlPurifier();
            $p->options = array('URI.AllowedSchemes'=>array(
              'http' => true,
              'https' => true,
            ));
            return $p->purify($str);
        }
       
       public static function isMobileBrowser(){
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
            if($isiPad)
                return true;
                
            return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
       }
}

?>