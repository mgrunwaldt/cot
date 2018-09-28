<?php
    //--------------------------------------------------------------------------
    //------------------------SearchThroughTables-------------------------------
    //--------------------------------------------------------------------------
    $searchThroughTablesFunctionNames = "";
    $searchThroughTablesFunctions = "";
    
    if(isset($table['searchThroughTables'])){
        foreach($table['searchThroughTables'] as $searchThroughTable){
                $tableNames = self::getModelNamesFromTableName($searchThroughTable['table']);

                $searchThroughTablesFunctionNames .= ", 'getAllFrom".$tableNames['singular']."Array'";
                $searchThroughTablesFunctions = "
            public function actionGetAllFrom".$tableNames['singular']."Array(){
                if(isset(\$_POST['".$searchThroughTable['through']."']) && is_numeric(\$_POST['".$searchThroughTable['through']."'])){
                    \$response = array();
                    \$".$modelNames['pluralCamelCase']."Array = array();
                    \$".$searchThroughTable['through']." = \$_POST['".$searchThroughTable['through']."'];
                    \$".$modelNames['pluralCamelCase']." = ".$modelNames['plural']."::model()->getAllFrom".$tableNames['singular']."(\$".$searchThroughTable['through'].");
                    foreach(\$".$modelNames['pluralCamelCase']." as \$".$modelNames['singularCamelCase']."){
                        \$".$modelNames['pluralCamelCase']."Array[] = HelperFunctions::modelToArray(\$".$modelNames['singularCamelCase'].");
                    }
                    \$response['status'] = 'ok';
                    \$response['".$modelNames['pluralCamelCase']."'] = \$".$modelNames['pluralCamelCase']."Array;

                    echo(json_encode(\$response));
                }
            }
                ";
        }
    }
    
    
    //--------------------------------------------------------------------------
    //---------------------------ActionViewAdd----------------------------------
    //--------------------------------------------------------------------------
    $actionViewAddGetSelectModels = "";
    $actionViewAddArrayHTML = "";
    foreach($table['columns'] as $column){
        if($column['type']==BuilderTypes::$SELECT){
            $modelNamesAux = self::getModelNamesFromTableName($column['typeValue']);
            $actionViewAddGetSelectModels .= "\$".$modelNamesAux['pluralCamelCase']." = ".$modelNamesAux['plural']."::getAll();
            ";
            $actionViewAddArrayHTML .= "'".$modelNamesAux['pluralCamelCase']."'=>\$".$modelNamesAux['pluralCamelCase'].', ';
        }
    }
    
    
    //--------------------------------------------------------------------------
    //---------------------------ActionViewEdit---------------------------------
    //--------------------------------------------------------------------------
    $actionViewEditGetSelectModels = "\$".$modelNames['pluralCamelCase']." = ".$modelNames['plural']."::getAll();
                    ";
    $actionViewEditGetSelectModels .= $actionViewAddGetSelectModels;
    
    $searchThroughTableRender = "";
    if(isset($table['searchThroughTables'])){
        $searchThroughTableNames = $this->getModelNamesFromTableName($table['searchThroughTables'][count($table['searchThroughTables'])-1]['table']);
        $actionViewEditGetSelectModels .= "\$".$searchThroughTableNames['pluralCamelCase']." = ".$searchThroughTableNames['plural']."::getAll();
                    ";
        $searchThroughTableRender = " '".$searchThroughTableNames['pluralCamelCase']."'=>\$".$searchThroughTableNames['pluralCamelCase'].',';
    }
    
    $actionViewEditArrayHTML = "'id'=>\$id, '".$modelNames['pluralCamelCase']."'=>\$".$modelNames['pluralCamelCase'].', '.$searchThroughTableRender;
    $actionViewEditArrayHTML .= $actionViewAddArrayHTML;

    
    //--------------------------------------------------------------------------
    //------------------------------ActionAdd-----------------------------------
    //--------------------------------------------------------------------------
    $actionAddArrayName = "\$".$modelNames['singularCamelCase']."Array";
    $actionAddIssetVerification = "";
    foreach($table['columns'] as $column)
        if(BuilderTypes::canBeModifiedByUser($column['type']))
            $actionAddIssetVerification .= "isset(".$actionAddArrayName."['".$column['name']."']) && ";
    $actionAddIssetVerification = substr($actionAddIssetVerification, 0, strlen($actionAddIssetVerification)-4);
    
    $actionAddUniqueColumnsCheckNeeded = false;
    $actionAddUniqueColumnsCheck = "";
    $actionAddUniqueColumnsException = "";
    foreach($table['columns'] as $column)
        if($column['unique']=='1'){
            $actionAddUniqueColumnsCheckNeeded = true;
            $actionAddUniqueColumnsCheck .= $actionAddArrayName."['".$column['name']."'],";
        }
    if($actionAddUniqueColumnsCheckNeeded){
        $actionAddUniqueColumnsCheck = "if(".$modelNames['plural']."::checkUnique(".substr($actionAddUniqueColumnsCheck, 0, strlen($actionAddUniqueColumnsCheck)-1).")){";
        $actionAddUniqueColumnsException = "}
                            else{
                                \$response['status'] = 'error';
                                \$response['error'] = '".$modelNames['singularCamelCase']."AlreadyExists';
                                \$response['errorMessage'] = '".$modelNames['singularCamelCase']."AlreadyExists';
                            }";
    }
    
    $actionAddCreate = "\$".$modelNames['singularCamelCase']." = ".$modelNames['plural']."::create(";
    foreach($table['columns'] as $column)
        if(BuilderTypes::canBeModifiedByUser($column['type']))
            $actionAddCreate .= $actionAddArrayName."['".$column['name']."'],";
    $actionAddCreate = substr($actionAddCreate, 0, strlen($actionAddCreate)-1);
    $actionAddCreate .= ');';
    
    $actionAddManyToThis = '';
    
    if(isset($table['manyToThis'] ))
        foreach($table['manyToThis'] as $manyToThis){
            $auxTableNames = $this->getModelNamesFromTableName($manyToThis['table']);
            $actionAddManyToThis .= "\$".$auxTableNames['pluralCamelCase']." = array();
                                        if(isset(".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."']) && is_array(".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."']))
                                            \$".$auxTableNames['pluralCamelCase']." = ".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."'];
                                        ".$auxTableNames['plural']."::update".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."->id, \$".$auxTableNames['pluralCamelCase'].", true);

                                        ";
        }
    
    $actionAddFiles = '';
    if(isset($table['files'] ))
        foreach($table['files'] as $files){
            $auxTableNames = $this->getModelNamesFromTableName($files['table']);
            $actionAddFiles .= "\$".$auxTableNames['pluralCamelCase']." = array();
                                        if(isset(".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."']) && is_array(".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."']))
                                            \$".$auxTableNames['pluralCamelCase']." = ".$actionAddArrayName."['".$auxTableNames['pluralCamelCase']."'];
                                        ".$auxTableNames['plural']."::update".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."->id, \$".$auxTableNames['pluralCamelCase'].", true);

                                        ";
    }
    
    //--------------------------------------------------------------------------
    //------------------------------ActionSave----------------------------------
    //--------------------------------------------------------------------------
    $actionSaveArrayName = $actionAddArrayName;
    $actionSaveIssetVerification = "isset(".$actionSaveArrayName."['id']) && is_numeric(".$actionSaveArrayName."['id']) && ".$actionAddIssetVerification;

    $actionSaveUniqueColumnsCheck = "";
    $actionSaveUniqueColumnsException = "";
    if($actionAddUniqueColumnsCheckNeeded){
        $actionSaveUniqueColumnsCheck = substr($actionAddUniqueColumnsCheck, 0, strlen($actionAddUniqueColumnsCheck)-3).", ".$actionSaveArrayName."['id'])){";
        $actionSaveUniqueColumnsException = "}
                                else{
                                    \$response['status'] = 'error';
                                    \$response['error'] = '".$modelNames['singularCamelCase']."AlreadyExists';
                                    \$response['errorMessage'] = '".$modelNames['singularCamelCase']."AlreadyExists';
                                }";
    }
    
    $actionSaveUpdateAttributes = str_replace("\$".$modelNames['singularCamelCase']." = ".$modelNames['plural']."::create(", "\$".$modelNames['singularCamelCase']."->updateAttributes(", $actionAddCreate);
    $actionSaveUpdateAttributes = substr($actionSaveUpdateAttributes,0,  strlen($actionSaveUpdateAttributes)-1).';';
    $actionSaveManyToThis = str_replace(", true);",", false);",$actionAddManyToThis);
    $actionSaveFiles = str_replace(", true);",", false);",$actionAddFiles);
    
    //--------------------------------------------------------------------------
    //----------------------------ActionGetArray--------------------------------
    //--------------------------------------------------------------------------
    $actionGetArrayManyToThis = '';
    if(isset($table['manyToThis'] ))
        foreach($table['manyToThis'] as $manyToThis){
            $auxTableNames = $this->getModelNamesFromTableName($manyToThis['table']);
            $actionGetArrayManyToThis .= "

                            \$".$modelNames['singularCamelCase']."->load".$auxTableNames['plural']."();
                            \$".$modelNames['singularCamelCase']."Array['".$auxTableNames['pluralCamelCase']."'] = array();
                            foreach(\$".$modelNames['singularCamelCase']."->".$auxTableNames['pluralCamelCase']." as \$".$auxTableNames['singularCamelCase'].")
                                \$".$modelNames['singularCamelCase']."Array['".$auxTableNames['pluralCamelCase']."'][] = HelperFunctions::modelToArray(\$".$auxTableNames['singularCamelCase'].");";
        }

    $actionGetArraySingleFiles = '';
    
    foreach($table['columns'] as $column){
        if($column['type']==BuilderTypes::$SINGLE_FILE){
            $columnNames = $this->getModelNamesFromTableName($column['name']);
            $actionGetArraySingleFiles .= "
        \$".$modelNames['singularCamelCase']."->load".$columnNames['noId']."();
        \$".$modelNames['singularCamelCase']."Array['".$columnNames['noIdCamelCase']."'] = HelperFunctions::modelToArray(\$".$modelNames['singularCamelCase']."->".$columnNames['noIdCamelCase'].");";
        }
    }
        
    $actionGetArrayFiles = '';
    if(isset($table['files'] ))
        foreach($table['files'] as $files){
            $auxTableNames = $this->getModelNamesFromTableName($files['table']);
            $actionGetArrayFiles .= "

                            \$".$modelNames['singularCamelCase']."->load".$auxTableNames['plural']."();
                            \$".$modelNames['singularCamelCase']."Array['".$auxTableNames['pluralCamelCase']."'] = array();
                            foreach(\$".$modelNames['singularCamelCase']."->".$auxTableNames['pluralCamelCase']." as \$".$auxTableNames['singularCamelCase'].")
                                \$".$modelNames['singularCamelCase']."Array['".$auxTableNames['pluralCamelCase']."'][] = HelperFunctions::modelToArray(\$".$auxTableNames['singularCamelCase'].");";
        }
    

    $positions = false;
    $positionsData = '';
    $positionsData2 = '';
    $positionsData3 = '';
    $positionsData4 = '';
    
    foreach($table['columns'] as $column)
        if($column['type']==BuilderTypes::$POSITION)
            $positions = true;
        
    if($positions){
        $positionsData = ", 'savePositions'";
        $positionsData2 = "\$".$modelNames['pluralCamelCase']." = ".$modelNames['plural']."::getAll();";
        $positionsData3 = ", array('".$modelNames['pluralCamelCase']."'=>\$".$modelNames['pluralCamelCase'].")";
        $positionsData4 = "
            
        public function actionSavePositions(){
                \$response = array();
		try{
                    if(isset(\$_POST['".$modelNames['singularCamelCase']."Ids']) && is_array(\$_POST['".$modelNames['singularCamelCase']."Ids'])){
                        ".$modelNames['plural']."::savePositions(\$_POST['".$modelNames['singularCamelCase']."Ids']);
                        \$response['status'] = 'ok';
                        \$response['message'] = 'Posiciones guardadas';
                    }
                    else{
                        \$response['status'] = 'error';
                        \$response['error'] = 'noData';
                        \$response['errorMessage'] = 'noData';
                    }
                    echo json_encode(\$response);
		}
		catch (Exception \$ex)
		{
                    Errors::log('Error en ".$modelNames['plural']."Controller/actionSave',\$ex->getMessage(),'');
                    \$response['status'] = 'error';
                    \$response['error'] = 'unknown';
                    \$response['errorMessage'] = 'unknown';
                    echo json_encode(\$response);
		}
        }
        
        ";
    }
    
    //--------------------------------------------------------------------------
    //---------------------------------DATA-------------------------------------
    //--------------------------------------------------------------------------
    
    
$data = "<?php
    
    class ".$modelNames['plural']."Controller extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public \$layout='//layouts/column2';

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
				'actions'=>array('getArray','getAllArray','viewMain','viewAdd','viewEdit','add','save'".$positionsData.",'delete'".$searchThroughTablesFunctionNames."),
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
	 * @param integer \$id the ID of the model to be displayed
	 */
	public function actionViewMain(){
		try
		{
                    ".$positionsData2."
                    \$this->render('main'".$positionsData3.");
		}
		catch (Exception \$ex)
		{
			Errors::log('Error en ".$modelNames['plural']."Controller/actionViewMain',\$ex->getMessage(),'');
			\$this->redirect('/site/userError');
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer \$id the ID of the model to be displayed
	 */
	public function actionViewAdd()
	{
		try
		{
                    ".$actionViewAddGetSelectModels."
                    \$this->render('add',array(".$actionViewAddArrayHTML."));
		}
		catch (Exception \$ex)
		{
			Errors::log('Error en ".$modelNames['plural']."Controller/actionViewAdd',\$ex->getMessage(),'');
			\$this->redirect('/site/userError');
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer \$id the ID of the model to be displayed
	 */
	public function actionViewEdit(\$id=0)
	{
		try
		{
                    ".$actionViewEditGetSelectModels."
                    \$this->render('edit',array(".$actionViewEditArrayHTML."));
		}
		catch (Exception \$ex)
		{
			Errors::log('Error en ".$modelNames['plural']."Controller/actionViewEdit',\$ex->getMessage(),'');
			\$this->redirect('/site/userError');
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer \$id the ID of the model to be displayed
	 */
	public function actionAdd()
	{
                \$response = array();
		try
		{
                    if(isset(\$_POST['".$modelNames['singularCamelCase']."']) && is_array(\$_POST['".$modelNames['singularCamelCase']."'])){
                        ".$actionAddArrayName." = \$_POST['".$modelNames['singularCamelCase']."'];
                        if(".$actionAddIssetVerification."){
                            ".$actionAddUniqueColumnsCheck."
                                ".$actionAddCreate."
                                if(!\$".$modelNames['singularCamelCase']."->hasErrors()){
                                    ".$actionAddManyToThis."
                                    ".$actionAddFiles."

                                    \$response['status'] = 'ok';
                                    \$response['message'] = ".$modelNames['plural']."::getModelName('singular') . ' agregado.';
                                    \$response['id'] = \$".$modelNames['singularCamelCase']."->id;
                                    
                                    Logs::log('Se creó el ".$modelNames['singularSpaces']." '.\$".$modelNames['singularCamelCase']."->id);
                                }
                                else{
                                    \$response['status'] = 'error';
                                    \$response['error'] = 'errorSaving".$modelNames['singular']."';
                                    \$response['errorMessage'] = HelperFunctions::getErrorsFromModel(\$".$modelNames['singularCamelCase'].");
                                }
                            ".$actionAddUniqueColumnsException."
                        }
                        else{
                            \$response['status'] = 'error';
                            \$response['error'] = 'invalidData';
                            \$response['errorMessage'] = 'invalidData';
                        }
                    }
                    else{
                        \$response['status'] = 'error';
                        \$response['error'] = 'noData';
                        \$response['errorMessage'] = 'noData';
                    }
                    echo json_encode(\$response);
		}
		catch (Exception \$ex)
		{
                    Errors::log('Error en ".$modelNames['singular']."Controller/actionAdd',\$ex->getMessage(),'');
                    \$response['status'] = 'error';
                    \$response['error'] = 'unknown';
                    \$response['errorMessage'] = 'unknown';
                    echo json_encode(\$response);
		}
	}
        
	public function actionSave()
	{
                \$response = array();
		try{
                    if(isset(\$_POST['".$modelNames['singularCamelCase']."']) && is_array(\$_POST['".$modelNames['singularCamelCase']."'])){
                        ".$actionSaveArrayName." = \$_POST['".$modelNames['singularCamelCase']."'];
                        if(".$actionSaveIssetVerification."){
                            \$".$modelNames['singularCamelCase']." = ".$modelNames['plural']."::get(".$actionSaveArrayName."['id']);
                            if(isset(\$".$modelNames['singularCamelCase']."->id)){
                                ".$actionSaveUniqueColumnsCheck."
                                    ".$actionSaveUpdateAttributes."
                                    if(!$".$modelNames['singularCamelCase']."->hasErrors()){
                                        ".$actionSaveManyToThis."
                                        ".$actionSaveFiles."
                                        \$response['status'] = 'ok';
                                        \$response['message'] = ".$modelNames['plural']."::getModelName('singular') . ' guardado.';

                                        Logs::log('Se editó el ".$modelNames['singularSpaces']." '.\$".$modelNames['singularCamelCase']."->id);
                                    }
                                    else{
                                        \$response['status'] = 'error';
                                        \$response['error'] = 'ErrorSaving".$modelNames['singular']."';
                                        \$response['errorMessage'] = HelperFunctions::getErrorsFromModel(\$".$modelNames['singularCamelCase'].");
                                    }
                                ".$actionSaveUniqueColumnsException."
                            }
                            else{
                                \$response['status'] = 'error';
                                \$response['error'] = 'No".$modelNames['singular']."WithId';
                                \$response['errorMessage'] = 'No".$modelNames['singular']."WithId';
                            }
                        }
                        else{
                            \$response['status'] = 'error';
                            \$response['error'] = 'invalidData';
                            \$response['errorMessage'] = 'invalidData';
                        }
                    }
                    else{
                        \$response['status'] = 'error';
                        \$response['error'] = 'noData';
                        \$response['errorMessage'] = 'noData';
                    }
                    echo json_encode(\$response);
		}
		catch (Exception \$ex)
		{
                    Errors::log('Error en ".$modelNames['plural']."Controller/actionSave',\$ex->getMessage(),'');
                    \$response['status'] = 'error';
                    \$response['error'] = 'unknown';
                    \$response['errorMessage'] = 'unknown';
                    echo json_encode(\$response);
		}
	}
        
        ".$positionsData4."
        
        public function actionGetArray(){
            try{
                if(isset(\$_POST['id']) && is_numeric(\$_POST['id'])){
                    \$".$modelNames['singularCamelCase']." = ".$modelNames['plural']."::get(\$_POST['id']);
                    if(isset(\$".$modelNames['singularCamelCase']."->id)){
                        \$".$modelNames['singularCamelCase']."Array = HelperFunctions::modelToArray(\$".$modelNames['singularCamelCase'].");
                        ".$actionGetArrayManyToThis."
                        ".$actionGetArraySingleFiles."
                        ".$actionGetArrayFiles."
                        \$response['status'] = 'ok';
                        \$response['".$modelNames['singularCamelCase']."'] = \$".$modelNames['singularCamelCase']."Array;
                    }
                    else{
                        \$response['status'] = 'error';
                        \$response['error'] = 'No".$modelNames['singular']."WithId';
                        \$response['errorMessage'] = 'No".$modelNames['singular']."WithId';
                    }
                }
                else{
                    \$response['status'] = 'error';
                    \$response['error'] = 'invalidData';
                    \$response['errorMessage'] = 'invalidData';
                }
                echo json_encode(\$response);
            }
            catch (Exception \$ex){
                Errors::log('Error en ".$modelNames['plural']."Controller/actionGetArray',\$ex->getMessage(),'');
                \$response['status'] = 'error';
                \$response['error'] = 'unknown';
                \$response['errorMessage'] = 'unknown';
                echo json_encode(\$response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                \$".$modelNames['pluralCamelCase']."Array = array();
                \$".$modelNames['pluralCamelCase']." = ".$modelNames['plural']."::getAll();
                foreach(\$".$modelNames['pluralCamelCase']." as \$".$modelNames['singularCamelCase'].")
                    \$".$modelNames['pluralCamelCase']."Array[] = HelperFunctions::modelToArray(\$".$modelNames['singularCamelCase'].");
                
                \$response['".$modelNames['pluralCamelCase']."'] = \$".$modelNames['pluralCamelCase']."Array;
                \$response['status'] = 'ok';
                
                echo json_encode(\$response);
            }
            catch (Exception \$ex){
                Errors::log('Error en ".$modelNames['plural']."Controller/actionGetAllArray',\$ex->getMessage(),'');
                \$response['status'] = 'error';
                \$response['error'] = 'unknown';
                \$response['errorMessage'] = 'unknown';
                echo json_encode(\$response);
            }
        }
        
	public function actionDelete()
	{
                \$response = array();
		try{
                    if(isset(\$_POST['id']) && is_numeric(\$_POST['id'])){
                        \$".$modelNames['singularCamelCase']." = ".$modelNames['plural']."::get(\$_POST['id']);
                        if(isset(\$".$modelNames['singularCamelCase']."->id)){
                            \$".$modelNames['singularCamelCase']."->delete".$modelNames['singular']."();
                            \$response['status'] = 'ok';
                            \$response['message'] = ".$modelNames['plural']."::getModelName('singular') . ' eliminado.';
                                    
                            Logs::log('Se eliminó el ".$modelNames['singularSpaces']." '.\$_POST['id']);
                        }
                        else{
                            \$response['status'] = 'error';
                            \$response['error'] = 'no".$modelNames['singular']."WithId';
                            \$response['errorMessage'] = 'no".$modelNames['singular']."WithId';
                        }
                    }
                    else{
                        \$response['status'] = 'error';
                        \$response['error'] = 'noData';
                        \$response['errorMessage'] = 'noData';
                    }
                    echo json_encode(\$response);
		}
		catch (Exception \$ex)
		{
                    Errors::log('Error en ".$modelNames['plural']."Controller/actionDelete',\$ex->getMessage(),'');
                    \$response['status'] = 'error';
                    \$response['error'] = 'unknown';
                    \$response['errorMessage'] = 'unknown';
                    echo json_encode(\$response);
		}
	}
        ".$searchThroughTablesFunctions."
}
?>";
?>