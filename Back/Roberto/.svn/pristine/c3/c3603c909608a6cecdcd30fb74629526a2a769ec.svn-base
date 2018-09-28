<?php
    
    class CategoriesController extends Controller{
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
				'actions'=>array('getArray','getAllArray','viewMain','viewAdd','viewEdit','add','save', 'savePositions','delete'),
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
                    $categories = Categories::getAll();
                    $this->render('main', array('categories'=>$categories));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en CategoriesController/actionViewMain',$ex->getMessage(),'');
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
			Errors::log('Error en CategoriesController/actionViewAdd',$ex->getMessage(),'');
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
                    $categories = Categories::getAll();
                    
                    $this->render('edit',array('id'=>$id, 'categories'=>$categories, ));
		}
		catch (Exception $ex)
		{
			Errors::log('Error en CategoriesController/actionViewEdit',$ex->getMessage(),'');
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
                    if(isset($_POST['category']) && is_array($_POST['category'])){
                        $categoryArray = $_POST['category'];
                        if(isset($categoryArray['name']) && isset($categoryArray['icon_file_id']) && isset($categoryArray['active'])){
                            
                                $category = Categories::create($categoryArray['name'],$categoryArray['icon_file_id'],$categoryArray['active']);
                                if(!$category->hasErrors()){
                                    
                                    

                                    $response['status'] = 'ok';
                                    $response['message'] = Categories::getModelName('singular') . ' agregado.';
                                    $response['id'] = $category->id;
                                    
                                    Logs::log('Se creó el Category '.$category->id);
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'errorSavingCategory';
                                    $response['errorMessage'] = HelperFunctions::getErrorsFromModel($category);
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
                    Errors::log('Error en CategoryController/actionAdd',$ex->getMessage(),'');
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
                    if(isset($_POST['category']) && is_array($_POST['category'])){
                        $categoryArray = $_POST['category'];
                        if(isset($categoryArray['id']) && is_numeric($categoryArray['id']) && isset($categoryArray['name']) && isset($categoryArray['icon_file_id']) && isset($categoryArray['active'])){
                            $category = Categories::get($categoryArray['id']);
                            if(isset($category->id)){
                                
                                    $category->updateAttributes($categoryArray['name'],$categoryArray['icon_file_id'],$categoryArray['active']);
                                    if(!$category->hasErrors()){
                                        
                                        
                                        $response['status'] = 'ok';
                                        $response['message'] = Categories::getModelName('singular') . ' guardado.';

                                        Logs::log('Se editó el Category '.$category->id);
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'ErrorSavingCategory';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($category);
                                    }
                                
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'NoCategoryWithId';
                                $response['errorMessage'] = 'NoCategoryWithId';
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
                    Errors::log('Error en CategoriesController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        
            
        public function actionSavePositions(){
                $response = array();
		try{
                    if(isset($_POST['categoryIds']) && is_array($_POST['categoryIds'])){
                        Categories::savePositions($_POST['categoryIds']);
                        $response['status'] = 'ok';
                        $response['message'] = 'Posiciones guardadas';
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
                    Errors::log('Error en CategoriesController/actionSave',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
        }
        
        
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $category = Categories::get($_POST['id']);
                    if(isset($category->id)){
                        $categoryArray = HelperFunctions::modelToArray($category);
                        
                        
        $category->loadIconFile();
        $categoryArray['iconFile'] = HelperFunctions::modelToArray($category->iconFile);
                        
                        $response['status'] = 'ok';
                        $response['category'] = $categoryArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoCategoryWithId';
                        $response['errorMessage'] = 'NoCategoryWithId';
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
                Errors::log('Error en CategoriesController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $categoriesArray = array();
                $categories = Categories::getAll();
                foreach($categories as $category)
                    $categoriesArray[] = HelperFunctions::modelToArray($category);
                
                $response['categories'] = $categoriesArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en CategoriesController/actionGetAllArray',$ex->getMessage(),'');
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
                        $category = Categories::get($_POST['id']);
                        if(isset($category->id)){
                            $category->deleteCategory();
                            $response['status'] = 'ok';
                            $response['message'] = Categories::getModelName('singular') . ' eliminado.';
                                    
                            Logs::log('Se eliminó el Category '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noCategoryWithId';
                            $response['errorMessage'] = 'noCategoryWithId';
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
                    Errors::log('Error en CategoriesController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
}
?>