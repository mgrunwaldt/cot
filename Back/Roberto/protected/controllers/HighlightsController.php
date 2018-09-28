<?php
    
    class HighlightsController extends Controller{
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
			Errors::log('Error en HighlightsController/actionViewMain',$ex->getMessage(),'');
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
			Errors::log('Error en HighlightsController/actionViewAdd',$ex->getMessage(),'');
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
                    $highlights = Highlights::getAll();
                    
                    $this->render('edit',array('id'=>$id, 'highlights'=>$highlights, ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en HighlightsController/actionViewEdit',$ex->getMessage(),'');
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
                    if(isset($_POST['highlight']) && is_array($_POST['highlight'])){
                        $highlightArray = $_POST['highlight'];
                        if(isset($highlightArray['name']) && isset($highlightArray['highlight_file_id']) && isset($highlightArray['title']) && isset($highlightArray['font_size']) && isset($highlightArray['letter_spacing']) && isset($highlightArray['link']) && isset($highlightArray['mobile'])){
                            
                                $highlight = Highlights::create($highlightArray['name'],$highlightArray['highlight_file_id'],$highlightArray['title'],$highlightArray['font_size'],$highlightArray['letter_spacing'],$highlightArray['link'],$highlightArray['mobile']);
                                if(!$highlight->hasErrors()){
                                    
                                    

                                    $response['status'] = 'ok';
                                    $response['message'] = Highlights::getModelName('singular') . ' agregado.';
                                    $response['id'] = $highlight->id;
                                    
                                    Logs::log('Se creó el Highlight '.$highlight->id);
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'errorSavingHighlight';
                                    $response['errorMessage'] = HelperFunctions::getErrorsFromModel($highlight);
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
                    Errors::log('Error en HighlightController/actionAdd',$ex->getMessage(),'');
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
                    if(isset($_POST['highlight']) && is_array($_POST['highlight'])){
                        $highlightArray = $_POST['highlight'];
                        if(isset($highlightArray['id']) && is_numeric($highlightArray['id']) && isset($highlightArray['name']) && isset($highlightArray['highlight_file_id']) && isset($highlightArray['title']) && isset($highlightArray['font_size']) && isset($highlightArray['letter_spacing']) && isset($highlightArray['link']) && isset($highlightArray['mobile'])){
                            $highlight = Highlights::get($highlightArray['id']);
                            if(isset($highlight->id)){
                                
                                    $highlight->updateAttributes($highlightArray['name'],$highlightArray['highlight_file_id'],$highlightArray['title'],$highlightArray['font_size'],$highlightArray['letter_spacing'],$highlightArray['link'],$highlightArray['mobile']);
                                    if(!$highlight->hasErrors()){
                                        
                                        
                                        $response['status'] = 'ok';
                                        $response['message'] = Highlights::getModelName('singular') . ' guardado.';

                                        Logs::log('Se editó el Highlight '.$highlight->id);
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'ErrorSavingHighlight';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($highlight);
                                    }
                                
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'NoHighlightWithId';
                                $response['errorMessage'] = 'NoHighlightWithId';
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
                    Errors::log('Error en HighlightsController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $highlight = Highlights::get($_POST['id']);
                    if(isset($highlight->id)){
                        $highlightArray = HelperFunctions::modelToArray($highlight);
                        
                        
        $highlight->loadHighlightFile();
        $highlightArray['highlightFile'] = HelperFunctions::modelToArray($highlight->highlightFile);
                        
                        $response['status'] = 'ok';
                        $response['highlight'] = $highlightArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoHighlightWithId';
                        $response['errorMessage'] = 'NoHighlightWithId';
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
                Errors::log('Error en HighlightsController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $highlightsArray = array();
                $highlights = Highlights::getAll();
                foreach($highlights as $highlight)
                    $highlightsArray[] = HelperFunctions::modelToArray($highlight);
                
                $response['highlights'] = $highlightsArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en HighlightsController/actionGetAllArray',$ex->getMessage(),'');
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
                        $highlight = Highlights::get($_POST['id']);
                        if(isset($highlight->id)){
                            $highlight->deleteHighlight();
                            $response['status'] = 'ok';
                            $response['message'] = Highlights::getModelName('singular') . ' eliminado.';
                                    
                            Logs::log('Se eliminó el Highlight '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noHighlightWithId';
                            $response['errorMessage'] = 'noHighlightWithId';
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
                    Errors::log('Error en HighlightsController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
}
?>