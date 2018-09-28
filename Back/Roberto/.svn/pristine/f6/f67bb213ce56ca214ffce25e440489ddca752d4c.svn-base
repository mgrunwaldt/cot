<?php
class BuilderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
                        /*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('viewBuild','getTables','build','getBuilderTypes'),
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
	public function actionViewBuild()
	{
		try
		{
                    $this->render('build');
                }
		catch (Exception $ex)
		{
			Errors::log("Error en BuildController/actionViewBuild",$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionGetTables()
	{
		try
		{
                    $response = array();
                    
                    $connection = Yii::app()->db;
                    $dbSchema = $connection->getSchema();
                    $tableArray = array();
                    $tables = $dbSchema->getTables();
                    foreach($tables as $table){
                        $columnsArray = array();
                        $columnNames = $table->getColumnNames();
                        foreach($columnNames as $columnName){
                            $column = $table->getColumn($columnName);
                            $columnsArray[] = array(
                                    'name'=>$columnName,
                                    'type'=>$column->dbType
                            );
                        }
                        $tableArray[] = array(
                                'name' => $table->name,
                                'columns' => $columnsArray
                        );
                    }
                    
                    $response['tables'] = $tableArray;
                    $response['status'] = 'ok';
                    
                    echo(json_encode($response));
                }
		catch (Exception $ex)
		{
                    Errors::log("Error en BuildController/actionGetTables",$ex->getMessage(),'');
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
	public function actionBuild()
	{
                $response = array();
		try{
                    if(isset($_POST['table'])){
                        $table = $_POST['table'];
                        
                        if(!isset($_POST['model']) || $_POST['model']==1){
                            $this->buildModelClass($table);
                            $this->buildManyToThisModelClasses($table);
                            $this->buildFileClasses($table);
                        }
                        
                        if(!isset($_POST['controller']) || $_POST['controller']==1){
                            $this->buildControllerClass($table);
                        }
                        
                        if(!isset($_POST['views']) || $_POST['views']==1){
                            $this->buildViewMainFile($table);
                            $this->buildViewFormFile($table);
                            $this->buildViewAddFile($table);
                            $this->buildViewEditFile($table);
                        }
                        
                        if(!isset($_POST['js']) || $_POST['js']==1){
                            $this->buildJSFile($table);
                        }
                        
                        $response['status'] = 'ok';
                        $response['message'] = 'CRUD Created';
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'invalidData';
                        $response['errorMessage'] = 'invalidData';
                    }
                    echo(json_encode($response));
                }
		catch (Exception $ex)
		{
                    Errors::log("Error en BuildController/actionBuild",$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        private function buildControllerClass($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            
            $filePath = Yii::app()->basePath.'/controllers/'.$modelNames['plural'].'Controller.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/controller.php';
            fwrite($handle, $data);
        }
        
        private function buildModelClass($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            
            $filePath = Yii::app()->basePath.'/models/'.$modelNames['plural'].'.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/model.php';
            fwrite($handle, $data);
        }
        
        private function buildViewMainFile($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            $folderPath = Yii::app()->basePath.'/views/'.$modelNames['pluralCamelCase'];
            
            if(!file_exists($folderPath))
                mkdir($folderPath, 0777, true);

            $filePath = $folderPath.'/main.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/viewMain.php';
            fwrite($handle, $data);
        }
        
        private function buildViewAddFile($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            $folderPath = Yii::app()->basePath.'/views/'.$modelNames['pluralCamelCase'];
            
            if(!file_exists($folderPath))
                mkdir($folderPath, 0777, true);

            $filePath = $folderPath.'/add.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/viewAdd.php';
            fwrite($handle, $data);
        }
        
        private function buildViewEditFile($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            $folderPath = Yii::app()->basePath.'/views/'.$modelNames['pluralCamelCase'];
            
            if(!file_exists($folderPath))
                mkdir($folderPath, 0777, true);

            $filePath = $folderPath.'/edit.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/viewEdit.php';
            fwrite($handle, $data);
        }
        
        private function buildViewFormFile($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            $folderPath = Yii::app()->basePath.'/views/'.$modelNames['pluralCamelCase'];
            
            if(!file_exists($folderPath))
                mkdir($folderPath, 0777, true);

            $filePath = $folderPath.'/form.php';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/viewForm.php';
            fwrite($handle, $data);
        }
        
        private function buildJSFile($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            
            $folderPath = Yii::app()->basePath.'/../public_html/js/'.$modelNames['pluralCamelCase'];
            
            if (!file_exists($folderPath))
                mkdir($folderPath, 0777, true);
            
            $filePath = $folderPath.'/admin.js';
            
            if(file_exists($filePath))
                unlink($filePath);
            
            $handle = fopen($filePath, 'w');
            include Yii::app()->basePath.'/helpers/builder/js.php';
            fwrite($handle, $data);
        }
        
        private function buildManyToThisModelClasses($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            
            if(isset($table['manyToThis'])){
                foreach($table['manyToThis'] as $manyToThis){
                    $manyToThisNames = $this->getModelNamesFromTableName($manyToThis['table']);
                    $filePath = Yii::app()->basePath.'/models/'.$manyToThisNames['plural'].'.php';

                    if(file_exists($filePath))
                        unlink($filePath);

                    $handle = fopen($filePath, 'w');
                    include Yii::app()->basePath.'/helpers/builder/manyToThisModel.php';
                    fwrite($handle, $data);
                }
            }
        }
        
        private function buildFileClasses($table){
            $modelNames = $this->getModelNamesFromTableName($table['name']);
            
            if(isset($table['files'])){
                foreach($table['files'] as $file){
                    $fileNames = $this->getModelNamesFromTableName($file['table']);
                    $filePath = Yii::app()->basePath.'/models/'.$fileNames['plural'].'.php';

                    if(file_exists($filePath))
                        unlink($filePath);

                    $handle = fopen($filePath, 'w');
                    include Yii::app()->basePath.'/helpers/builder/filesModel.php';
                    fwrite($handle, $data);
                }
            }
        }
        
        public function getModelNamesFromTableName($tableName){
            $modelNames = array();
            $modelNames['table'] = $tableName;
            $modelNames['singular'] = '';
            $modelNames['plural'] = '';
            $modelNames['singularCamelCase'] = '';
            $modelNames['pluralCamelCase'] = '';
            $modelNames['pluralSpaces'] = '';
            $modelNames['singularSpaces'] = '';
            
            $modelNames['noId'] = '';
            $modelNames['noIdCamelCase'] = '';
            
            $words = explode('_', $tableName);
            
            for($i=0; $i<count($words); $i++){
                $word = $words[$i];
                $wordUpper = strtoupper(substr($word, 0, 1)).substr($word, 1, strlen($word)-1);
                $modelNames['plural'] .= $wordUpper;
                $modelNames['pluralSpaces'] .= $wordUpper . ' ';
            }
            
            $last3Characters = substr($modelNames['plural'], strlen($modelNames['plural'])-3, 3);
            $last2Characters = substr($modelNames['plural'], strlen($modelNames['plural'])-2, 2);
            
            $modelNames['pluralSpaces'] = substr($modelNames['pluralSpaces'], 0, strlen($modelNames['pluralSpaces'])-1);
            if($last3Characters=="ies"){
                $modelNames['singular'] = substr($modelNames['plural'], 0, strlen($modelNames['plural'])-3)."y";
                $modelNames['singularSpaces'] = substr($modelNames['pluralSpaces'], 0, strlen($modelNames['pluralSpaces'])-3)."y";
            }
            else if($last2Characters=="es"){
                $modelNames['singular'] = substr($modelNames['plural'], 0, strlen($modelNames['plural'])-2);
                $modelNames['singularSpaces'] = substr($modelNames['pluralSpaces'], 0, strlen($modelNames['pluralSpaces'])-2);
            }
            else{
                $modelNames['singular'] = substr($modelNames['plural'], 0, strlen($modelNames['plural'])-1);
                $modelNames['singularSpaces'] = substr($modelNames['pluralSpaces'], 0, strlen($modelNames['pluralSpaces'])-1);
            }
            
            $modelNames['singularCamelCase'] = strtolower(substr($modelNames['singular'], 0, 1)).substr($modelNames['singular'], 1, strlen($modelNames['singular'])-1);
            $modelNames['pluralCamelCase'] = strtolower(substr($modelNames['plural'], 0, 1)).substr($modelNames['plural'], 1, strlen($modelNames['plural'])-1);
            
            $modelNames['noId'] = str_replace("Id", "", strtoupper(substr($modelNames['pluralCamelCase'], 0, 1)).substr($modelNames['pluralCamelCase'], 1, strlen($modelNames['pluralCamelCase'])-1));
            $modelNames['noIdCamelCase'] = str_replace("Id", "", $modelNames['pluralCamelCase']);
            
            return $modelNames;
        }
        
        public function getColumnLength($tableName, $columnName){
            $connection = Yii::app()->db;
            $dbSchema = $connection->getSchema();
            $table = $dbSchema->getTable($tableName);

            if(isset($table->rawName))
                $column = $table->getColumn($columnName);
            else
                die('unknown table '.$tableName);
            
            if(isset($column->name))
                if(isset($column->size))
                    return $column->size;
                else
                    return 0;
            else
                die('unknown column '.$columnName. ' in table '.$tableName);
        }
        
        public function getInputLength($length){
            if($length>200)
                return 300;
            if($length>100)
                return 200;
            if($length>75)
                return 100;
            if($length>50)
                return 75;
            return 50;
        }
        
        public function actionGetBuilderTypes(){
            $response = array();
            $response['builderTypes'] = BuilderTypes::getAllArray();
            $response['status'] = 'ok';
            echo(json_encode($response));
        }
        
}
?>