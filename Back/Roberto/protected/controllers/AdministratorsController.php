<?php
    
    class AdministratorsController extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules(){
		return array(
			            array('allow',
				'actions'=>array('viewLogin','login'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('getArray','getAllArray','viewAdd','viewEdit','add','save','delete', 'getAllFromAdministratorRoleArray','resetPassword'),
				'users'=>array('*'),
				'expression'=>'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\') && in_array(AdministratorRoles::$SUPER_ADMIN,Yii::app()->user->adminRoles)',
			),
			array('allow',
				'actions'=>array('viewChangePassword','changePassword','viewIndex','viewMain'),
				'users'=>array('*'),
				'expression'=>'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\') && (in_array(AdministratorRoles::$EMPLOYEE,Yii::app()->user->adminRoles) || in_array(AdministratorRoles::$SAMSUNG,Yii::app()->user->adminRoles))',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewLogin(){
		//try
		//{   
                    //echo "$2y$10$".bin2hex(openssl_random_pseudo_bytes(22));
                    //die();
//                    $administrator = Administrators::getByEmail('matias@moonideas.com');
//                    $administrator->resetPassword();
//                    AdministratorLoginAttempts::model()->deleteAll('email="matias@moonideas.com" AND success=0');
                    
                    if(!Administrators::model()->exists('email="matias@moonideas.com"'))
                        Administrators::create('matias@moonideas.com', 'Matias', 'Burgos', '098773344', 1, 1);
                    
                    
                    
                        if(!Yii::app()->session['session_admin_id'])
                            $this->renderPartial('login');
                        else
                            $this->redirect('/administrators/viewIndex');
		//}
//		catch (Exception $ex)
//		{
//			Errors::log('Error en AdministratorsController/actionViewLogin',$ex->getMessage(),'');
//			$this->redirect('/index.php/site/error');
//		}
	}
        

	public function actionViewIndex(){
		try
		{
            $this->render('index');
		}
		catch (Exception $ex)
		{
			Errors::log('Error en AdministratorsController/actionViewIndex',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	public function actionViewMain(){
		try
		{
                    if(in_array(AdministratorRoles::$SUPER_ADMIN,Yii::app()->user->adminRoles))
                        $this->render('main');
                    else
                        $this->redirect('/Administrators/viewChangePassword');
		}
		catch (Exception $ex)
		{
			Errors::log('Error en AdministratorsController/actionViewMain',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	public function actionViewAdd()
	{
		try
		{
                    $administratorRoles = AdministratorRoles::getAll();
                    $this->render('add',array('administratorRoles'=>$administratorRoles, ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en AdministratorsController/actionViewAdd',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	public function actionViewEdit($id=0)
	{
		try
		{
                    $administrators = Administrators::getAll();
                    $administratorRoles = AdministratorRoles::getAll();
            
                    $this->render('edit',array('id'=>$id, 'administrators'=>$administrators, 'administratorRoles'=>$administratorRoles, ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en AdministratorsController/actionViewEdit',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	public function actionViewChangePassword(){
		try
		{
                        if(in_array(AdministratorRoles::$SAMSUNG,Yii::app()->user->adminRoles))
                            $this->layout="column3";
                        $this->render('changePassword');
		}
		catch (Exception $ex)
		{
			Errors::log('Error en AdministratorsController/actionViewChangePassword',$ex->getMessage(),'');
			$this->redirect('/index.php/site/error');
		}
	}
        
    public function actionLogin()
	{
            $response = array();
            try{
                $ip = HelperFunctions::getIP();
                if(!Yii::app()->params['security']['fixedIpsInAdmin'] || in_array($ip, Yii::app()->params['security']['adminIps'])){
                    if(!Yii::app()->session['session_admin_id']){
                        if(isset($_POST['email']) && isset($_POST['password'])){
                            $model = new LoginForm;
                            $model->username = $_POST['email'];
                            $model->password = $_POST['password'];
                            $model->setScenario('admin');

                            $consecutiveFailedLoginAttemptsInLastHour = AdministratorLoginAttempts::getConsecutiveFailedLoginAttemptsInLastHour($model->username);
                            if(count($consecutiveFailedLoginAttemptsInLastHour)<5){
                                if($model->validate() && $model->loginAdmin()){
                                    $response['status'] = 'ok';
                                    if(in_array(AdministratorRoles::$SAMSUNG,Yii::app()->user->adminRoles))
                                        $response['redirect'] = '/SamsungDeviceFiles/viewAdd';
                                    else
                                        $response['redirect'] = '/administrators/viewIndex';
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'wrongUsernameOrPassword';
                                    $response['errorMessage'] = 'wrongUsernameOrPassword';
                                }
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'blocked';
                                $response['errorMessage'] = 'Su cuenta ha sido bloqueada por reiterados intentos de inicio de sesión fallidos. Intente más tarde.';
                                Alerts::log('AdministratosController','actionLogin',$_POST['email'].' has been blocked because of too many failed login attempts.');
                            }
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'wrongInputData';
                            $response['errorMessage'] = 'wrongInputData';
                        }
                    }
                    else{
                        if(Yii::app()->user->role!='admin'){
                            $response['status'] = 'error';
                            $response['error'] = 'alreadyLogged';
                            $response['errorMessage'] = 'alreadyLogged';
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'alreadyLogged';
                            $response['errorMessage'] = 'alreadyLogged';
                        }
                    }

                    echo json_encode($response);
                }
            }
            catch (Exception $ex)
            {
                    Errors::log("Error en AdministratorsController/actionLogin",$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
            }
        }
        
        public function actionChangePassword()
	{
            $response = array();
            try{
                if(isset($_POST['oldPassword']) && isset($_POST['newPassword'])  && isset($_POST['newPasswordRepeat'])){
                    if($this->administrator!==false){
                        $restrictions = array(
                            $this->administrator->name,
                            $this->administrator->last_name,
                            $this->administrator->email,
                            $this->administrator->phone
                        );
                        if(HelperFunctions::validPassword($_POST['newPassword'], $restrictions)){
                            if($this->administrator->changePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPasswordRepeat'])){
                                $response['status'] = 'ok';
                                $response['message'] = 'Contraseña cambiada con éxito.';
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'wrongOldPassword';
                                $response['errorMessage'] = 'Error cambiando su contraseña, verifique su contraseña actual.';
                            }
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'invalidNewPassword';
                            $response['errorMessage'] = 'Su contraseña es inválida. Debe contener al menos 10 caracteres, entre ellos debe haber al menos 1 número y 1 caracter especial. No se pueden utilizar caracteres consecutivos, ejemplo 1234. No se pueden repetir caracteres, ejemplo: aaaa. Tampoco puede utilizar su nombre, teléfono o email.';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'notLogged';
                        $response['errorMessage'] = 'notLogged';
                    }
                }
                else{
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
                
                echo json_encode($response);
            }
            catch (Exception $ex)
            {
                    Errors::log("Error en AdministratorsController/actionChangePassword",$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
            }
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAdd()
	{
                $response = array();
		try
		{
                    if(isset($_POST['administrator']) && is_array($_POST['administrator'])){
                        $administratorArray = $_POST['administrator'];
                        if(isset($administratorArray['email']) && isset($administratorArray['name']) && isset($administratorArray['last_name']) && isset($administratorArray['phone']) && isset($administratorArray['administrator_role_id']) && isset($administratorArray['active'])){
                            if(Administrators::checkUnique($administratorArray['email'])){
                                    $administrator = Administrators::create($administratorArray['email'],$administratorArray['name'],$administratorArray['last_name'],$administratorArray['phone'],$administratorArray['administrator_role_id'],$administratorArray['active']);
                                    if(!$administrator->hasErrors()){
                                        $administratorFiles = array();
                                            if(isset($administratorArray['administratorFiles']) && is_array($administratorArray['administratorFiles']))
                                                $administratorFiles = $administratorArray['administratorFiles'];
                                            AdministratorFiles::updateAdministrator($administrator->id, $administratorFiles, true);

                                        Logs::log('Se creó el Administrador '.$administrator->id);

                                        $response['status'] = 'ok';
                                        $response['message'] = 'Administrator Added';
                                        $response['id'] = $administrator->id;
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'errorSavingAdministrator';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($administrator);
                                    }
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'administratorAlreadyExists';
                                $response['errorMessage'] = 'administratorAlreadyExists';
                            }
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'invalidData';
                            $response['errorMessage'] = 'invalidData';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'noData';
                        $response['errorMessage'] = 'noData';
                    }
                    echo json_encode($response);
		}
		catch (Exception $ex)
		{
                    Errors::log('Error en AdministratorController/actionAdd',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
	public function actionSave()
	{
                $response = array();
		try{
                    if(isset($_POST['administrator']) && is_array($_POST['administrator'])){
                        $administratorArray = $_POST['administrator'];
                        if(isset($administratorArray['id']) && is_numeric($administratorArray['id']) && isset($administratorArray['email']) && isset($administratorArray['name']) && isset($administratorArray['last_name']) && isset($administratorArray['phone']) && isset($administratorArray['administrator_role_id']) && isset($administratorArray['active'])){
                            $administrator = Administrators::get($administratorArray['id']);
                            if(isset($administrator->id)){
                                if(Administrators::checkUnique($administratorArray['email'], $administratorArray['id'])){
                                    
                                    $administrator->updateAttributes($administratorArray['email'],$administratorArray['name'],$administratorArray['last_name'],$administratorArray['phone'],$administratorArray['administrator_role_id'],$administratorArray['active']);
                                    
                                    if(!$administrator->hasErrors()){
                                        $administratorFiles = array();
                                            if(isset($administratorArray['administratorFiles']) && is_array($administratorArray['administratorFiles']))
                                                $administratorFiles = $administratorArray['administratorFiles'];
                                            AdministratorFiles::updateAdministrator($administrator->id, $administratorFiles, false);

                                        Logs::log('Se editó el Administrador '.$administrator->id);

                                        $response['status'] = 'ok';
                                        $response['message'] = 'Administrator Saved';
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'errorSavingAdministrator';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($administrator);
                                    }
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'administratorAlreadyExists';
                                    $response['errorMessage'] = 'administratorAlreadyExists';
                                }
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'NoAdministratorWithId';
                                $response['errorMessage'] = 'NoAdministratorWithId';
                            }
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'invalidData';
                            $response['errorMessage'] = 'invalidData';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'noData';
                        $response['errorMessage'] = 'noData';
                    }
                    echo json_encode($response);
		}
		catch (Exception $ex)
		{
                    Errors::log('Error en AdministratorsController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $administrator = Administrators::get($_POST['id']);
                    if(isset($administrator->id)){
                        $administratorArray = HelperFunctions::modelToArray($administrator);
                        
                            
                        

                            $administrator->loadAdministratorFiles();
                            $administratorArray['administratorFiles'] = array();
                            foreach($administrator->administratorFiles as $administratorFile)
                                $administratorArray['administratorFiles'][] = HelperFunctions::modelToArray($administratorFile);
                            

                        $response['status'] = 'ok';
                        $response['administrator'] = $administratorArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoAdministratorWithId';
                        $response['errorMessage'] = 'NoAdministratorWithId';
                    }
                }
                else{
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en AdministratorsController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $administratorsArray = array();
                $administrators = Administrators::getAll();
                foreach($administrators as $administrator)
                    $administratorsArray[] = HelperFunctions::modelToArray($administrator);
                
                $response['administrators'] = $administratorsArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en AdministratorsController/actionGetAllArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
	public function actionDelete()
	{
                $response = array();
		try{
                    if(isset($_POST['id']) && is_numeric($_POST['id'])){
                        $administrator = Administrators::get($_POST['id']);
                        if(isset($administrator->id)){
                            $administrator->deleteAdministrator();
                            $response['status'] = 'ok';
                            $response['message'] = 'Administrator Deleted';
                            
                            Logs::log('Se eliminó el Adminisrtador '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noAdministratorWithId';
                            $response['errorMessage'] = 'noAdministratorWithId';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'noData';
                        $response['errorMessage'] = 'noData';
                    }
                    echo json_encode($response);
		}
		catch (Exception $ex)
		{
                    Errors::log('Error en AdministratorsController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        public function actionGetAllFromAdministratorRoleArray(){
            if(isset($_POST['administratorRoleId']) && is_numeric($_POST['administratorRoleId'])){
                $response = array();
                $administratorsArray = array();
                $administratorRoleId = $_POST['administratorRoleId'];
                $administrators = Administrators::model()->getAllFromAdministratorRole($administratorRoleId);
                foreach($administrators as $administrator){
                    $administratorsArray[] = HelperFunctions::modelToArray($administrator);
                }
                $response['status'] = 'ok';
                $response['administrators'] = $administratorsArray;

                echo(json_encode($response));
            }
        }
            

	public function actionResetPassword(){
                $response = array();
		try{
                    if(isset($_POST['id']) && is_numeric($_POST['id'])){
                        $administrator = Administrators::get($_POST['id']);
                        if(isset($administrator->id)){
                            $administrator->resetPassword();
                            $response['status'] = 'ok';
                            $response['message'] = 'La contraseña ha sido reestablecida.';
                                    
                            Logs::log('Se restableció la contraseña del administrador '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noClientUserWithId';
                            $response['errorMessage'] = 'noClientUserWithId';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'noData';
                        $response['errorMessage'] = 'noData';
                    }
                    echo json_encode($response);
		}
		catch (Exception $ex)
		{
                    Errors::log('Error en AdministratorsController/actionResetPassword',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
}
?>