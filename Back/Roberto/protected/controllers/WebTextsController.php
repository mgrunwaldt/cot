<?php
    
    class WebTextsController extends Controller{
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
            $this->render('main',array());
		}
		catch (Exception $ex)
		{
			Errors::log('Error en WebTextsController/actionViewMain',$ex->getMessage(),'');
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
            $this->render('add',array());
		}
		catch (Exception $ex)
		{
			Errors::log('Error en WebTextsController/actionViewAdd',$ex->getMessage(),'');
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
            $webTexts = WebTexts::getAll();
            $this->render('edit',array('id'=>$id, 'webTexts'=>$webTexts, ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en WebTextsController/actionViewEdit',$ex->getMessage(),'');
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
                    if(isset($_POST['webText']) && is_array($_POST['webText'])){
                        $webTextArray = $_POST['webText'];
                        if(isset($webTextArray['name'])){
                            
                                $webText = WebTexts::create($webTextArray['name']);
                                if(!$webText->hasErrors()){
                                    
                                    

                                    $response['status'] = 'ok';
                                    $response['message'] = 'WebText Added';
                                    $response['id'] = $webText->id;
                                    
                                    Logs::log('Se creó el Web Text '.$webText->id);
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'errorSavingWebText';
                                    $response['errorMessage'] = HelperFunctions::getErrorsFromModel($webText);
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
                    Errors::log('Error en WebTextController/actionAdd',$ex->getMessage(),'');
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
                    if(isset($_POST['webText']) && is_array($_POST['webText'])){
                        $webTextArray = $_POST['webText'];
                        if(isset($webTextArray['id']) && is_numeric($webTextArray['id']) && isset($webTextArray['name'])){
                            $webText = WebTexts::get($webTextArray['id']);
                            if(isset($webText->id)){
                                
                                    $webText->updateAttributes($webTextArray['name']);
                                    if(!$webText->hasErrors()){
                                        
                                        
                                        $response['status'] = 'ok';
                                        $response['message'] = 'WebText Saved';

                                        Logs::log('Se editó el Web Text '.$webText->id);
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'ErrorSavingWebText';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($webText);
                                    }
                                
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'NoWebTextWithId';
                                $response['errorMessage'] = 'NoWebTextWithId';
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
                    Errors::log('Error en WebTextsController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $webText = WebTexts::get($_POST['id']);
                    if(isset($webText->id)){
                        $webTextArray = HelperFunctions::modelToArray($webText);
                        
                            
                        
                            

                        $response['status'] = 'ok';
                        $response['webText'] = $webTextArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoWebTextWithId';
                        $response['errorMessage'] = 'NoWebTextWithId';
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
                Errors::log('Error en WebTextsController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $webTextsArray = array();
                $webTexts = WebTexts::getAll();
                foreach($webTexts as $webText)
                    $webTextsArray[] = HelperFunctions::modelToArray($webText);
                
                $response['webTexts'] = $webTextsArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en WebTextsController/actionGetAllArray',$ex->getMessage(),'');
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
                        $webText = WebTexts::get($_POST['id']);
                        if(isset($webText->id)){
                            $webText->deleteWebText();
                            $response['status'] = 'ok';
                            $response['message'] = 'WebText Deleted';
                                    
                            Logs::log('Se eliminó el Web Text '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noWebTextWithId';
                            $response['errorMessage'] = 'noWebTextWithId';
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
                    Errors::log('Error en WebTextsController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
}
?>