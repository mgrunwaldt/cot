<?php
    
    class UsersController extends Controller{
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
			
                        /*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('getArray','getAllArray','viewMain','viewAdd','viewEdit','add','save','delete'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\')',
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
	public function actionViewMain(){
		try
		{
                    
                    $this->render('main');
		}
		catch (Exception $ex)
		{
			Errors::log('Error en UsersController/actionViewMain',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewAdd()
	{
		try
		{
                    $userCategories = UserCategories::getAll();
                    $ranches = Ranches::getAll();
                    $this->render('add',array('userCategories'=>$userCategories, 'ranches'=>$ranches));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en UsersController/actionViewAdd',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewEdit($id=0)
	{
		try
		{
                    $users = Users::getAll();
                    $userCategories = UserCategories::getAll();
                    $ranches = Ranches::GetAll();
                    $this->render('edit',array('id'=>$id, 'users'=>$users, 'userCategories'=>$userCategories, 'ranches'=>$ranches ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en UsersController/actionViewEdit',$ex->getMessage(),'');
			$this->redirect('/site/userError');
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
                    if(isset($_POST['user']) && is_array($_POST['user'])){
                        $userArray = $_POST['user'];
                        if(isset($userArray['name']) && isset($userArray['email']) && isset($userArray['phone']) && isset($userArray['category_id']) && isset($userArray['ranch_id'])){
                            
                                $user = Users::create($userArray['name'],$userArray['email'],$userArray['phone'],$userArray['category_id'],$userArray['ranch_id']);
                                if(!$user->hasErrors()){
                                    $userNotes = array();
                                    if(isset($userArray['userNotes']) && is_array($userArray['userNotes']))
                                        $userNotes = $userArray['userNotes'];
                                    UserNotes::updateUser($user->id, $userNotes, true, $this->administrator->id);
                                        
                                        
                                    $added = MailchimpHelper::subscribe($user, 0);
                                    if(!$added)
                                        Alerts::log("Error in UsersController/actionAdd", "Unable to subscribe user to mailchimp", "User: ".$user->id." List: Todos");
                                    
                                    
                                    $added = MailchimpHelper::subscribe($user, $user->category_id);
                                    if(!$added)
                                        Alerts::log("Error in UsersController/actionAdd", "Unable to subscribe user to mailchimp", "User: ".$user->id." Category: ".$user->category_id);

                                    $response['status'] = 'ok';
                                    $response['message'] = Users::getModelName('singular') . ' agregado.';
                                    $response['id'] = $user->id;
                                    
                                    Logs::log('Se creó el User '.$user->id);
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'errorSavingUser';
                                    $response['errorMessage'] = HelperFunctions::getErrorsFromModel($user);
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
                    Errors::log('Error en UserController/actionAdd',$ex->getMessage(),'');
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
                    if(isset($_POST['user']) && is_array($_POST['user'])){
                        $userArray = $_POST['user'];
                        if(isset($userArray['id']) && is_numeric($userArray['id']) && isset($userArray['name']) && isset($userArray['email']) && isset($userArray['phone']) && isset($userArray['category_id']) && isset($userArray['ranch_id'])){
                            $user = Users::get($userArray['id']);
                            if(isset($user->id)){
                                    $oldCategory = $user->category_id;
                                    $user->updateAttributes($userArray['name'],$userArray['email'],$userArray['phone'],$userArray['category_id'],$userArray['ranch_id']);
                                    if(!$user->hasErrors()){
                                        
                                        $userNotes = array();
                                        if(isset($userArray['userNotes']) && is_array($userArray['userNotes']))
                                            $userNotes = $userArray['userNotes'];
                                        UserNotes::updateUser($user->id, $userNotes, false, $this->administrator->id);
                                        
                                        MailchimpHelper::update($user);
                                        
                                        $response['status'] = 'ok';
                                        $response['message'] = Users::getModelName('singular') . ' guardado.';

                                        Logs::log('Se editó el User '.$user->id);
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'ErrorSavingUser';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($user);
                                    }
                                
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'NoUserWithId';
                                $response['errorMessage'] = 'NoUserWithId';
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
                    Errors::log('Error en UsersController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $user = Users::get($_POST['id']);
                    if(isset($user->id)){
                        $userArray = HelperFunctions::modelToArray($user);
                        
                        $user->loadUserNotes();
                        $userArray['userNotes'] = array();
                        foreach($user->userNotes as $userNot)
                            $userArray['userNotes'][] = HelperFunctions::modelToArray($userNot);
                        
                        $response['status'] = 'ok';
                        $response['user'] = $userArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoUserWithId';
                        $response['errorMessage'] = 'NoUserWithId';
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
                Errors::log('Error en UsersController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $usersArray = array();
                $users = Users::getAll();
                foreach($users as $user)
                    $usersArray[] = HelperFunctions::modelToArray($user);
                
                $response['users'] = $usersArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en UsersController/actionGetAllArray',$ex->getMessage(),'');
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
                        $user = Users::get($_POST['id']);
                        if(isset($user->id)){
                            $user->deleteUser();
                            $response['status'] = 'ok';
                            $response['message'] = Users::getModelName('singular') . ' eliminado.';
                                    
                            Logs::log('Se eliminó el User '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noUserWithId';
                            $response['errorMessage'] = 'noUserWithId';
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
                    Errors::log('Error en UsersController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
}
?>