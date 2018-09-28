<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticateAdmin()
	{	
		$Criteria = new CDbCriteria();
                $Criteria->condition = "email=:email AND active=1 AND deleted=0";
                $Criteria->params = array(':email'=>$this->username);
	                              
                $admin = Administrators::model()->find($Criteria);  
	                
                    if(isset($admin->id)){
                        if($admin->password==crypt(md5($this->password), Yii::app()->params['salt'])){
                            Yii::app()->session['session_admin_id'] = $admin->id;
                            $log = new Logs;
                            $log->log('El admin '.$this->username.' inició sesión');
                            $this->errorCode=self::ERROR_NONE; 
                            
                            $adminRoles = array();
                            switch($admin->administrator_role_id){
                                case AdministratorRoles::$SUPER_ADMIN:
                                    $adminRoles[] = AdministratorRoles::$SUPER_ADMIN;
                                case AdministratorRoles::$OWNER:
                                    $adminRoles[] = AdministratorRoles::$OWNER;
                                case AdministratorRoles::$EMPLOYEE:
                                    $adminRoles[] = AdministratorRoles::$EMPLOYEE;
                                    break;
                                case AdministratorRoles::$SAMSUNG:
                                    $adminRoles[] = AdministratorRoles::$SAMSUNG;
                                    break;
                            }
                            
                            $this->SetState('role','admin');
                            $this->SetState('adminRoles',$adminRoles);
                            
                            AdministratorSessions::newAdministratorSession($admin);
                            AdministratorLoginAttempts::create($this->username, 1);
                            
                            return true;
                        }
                        else{
                            AdministratorLoginAttempts::create($this->username, 0);
                            return false;
                        }
                    }
                    else{
                        return false;
                    }		
	}
        
	public function authenticateClientUser()
	{	
		$Criteria = new CDbCriteria();
                $Criteria->condition = "email=:email AND active=1 AND deleted=0";
                $Criteria->params = array(':email'=>$this->username);
	                              
                $clientUser = ClientUsers::model()->find($Criteria);  
	                
                    if(isset($clientUser->id)){
                        if($clientUser->password==crypt(md5($this->password), Yii::app()->params['salt'])){
                            Yii::app()->session['session_client_user_id'] = $clientUser->id;
                            $log = new Logs;
                            $log->log('El clientUser '.$this->username.' inició sesión');
                            $this->errorCode=self::ERROR_NONE; 
                            
                            $this->SetState('role','clientUser');
                            $this->SetState('adminRoles','clientUser');
                            
                            ClientUserSessions::newClientUserSession($clientUser);
                            ClientUserLoginAttempts::create($this->username, 1);
                            
                            return true;
                        }
                        else{
                            ClientUserLoginAttempts::create($this->username, 0);
                            return false;
                        }
                    }
                    else{
                        return false;
                    }		
	}
}	