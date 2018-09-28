<?php
    //--------------------------------------------------------------------------
    //---------------------------ColumnTypes------------------------------------
    //--------------------------------------------------------------------------
    $columnTypes = "* @property integer \$id";
    foreach($table['columns'] as $column){
        switch($column['type']){
            case BuilderTypes::$FIXED_STRING: case BuilderTypes::$STRING: case BuilderTypes::$EMAIL:
                $columnTypes .= "
 * @property string \$".$column['name'];
            break;
            case BuilderTypes::$FIXED_INT: case BuilderTypes::$INT:case BuilderTypes::$SELECT:
                $columnTypes .= "
 * @property integer \$".$column['name'];
            break;
            case BuilderTypes::$FIXED_FLOAT: case BuilderTypes::$FLOAT:
                $columnTypes .= "
 * @property float \$".$column['name'];
            break;
            case BuilderTypes::$CHECKBOX: case BuilderTypes::$FIXED_BOOLEAN: case BuilderTypes::$DELETED:
                $columnTypes .= "
 * @property boolean \$".$column['name'];
            break;
            case BuilderTypes::$DATE:
                $columnTypes .= "
 * @property date \$".$column['name'];
            break;
            case BuilderTypes::$DATETIME: case BuilderTypes::$CREATED_ON: case BuilderTypes::$UPDATED_ON:
                $columnTypes .= "
 * @property datetime \$".$column['name'];
            break;
        }
    }
    
    //--------------------------------------------------------------------------
    //-----------------------------Variables------------------------------------
    //--------------------------------------------------------------------------
    $variables = "";
    if(isset($table['manyToThis']))
        foreach($table['manyToThis'] as $manyToThis){
            $auxNames = $this->getModelNamesFromTableName($manyToThis['table']);
            $variables .= "
        public \$".$auxNames['pluralCamelCase'].';';
        }
        
    foreach($table['columns'] as $column){
        if($column['type']==BuilderTypes::$SINGLE_FILE){
            $columnNames = $this->getModelNamesFromTableName($column['name']);
            $variables .= "
        public \$".$columnNames['noIdCamelCase'].';';
        }
    }
        
        
    if(isset($table['files']))
        foreach($table['files'] as $file){
            $auxNames = $this->getModelNamesFromTableName($file['table']);
            $variables .= "
        public \$".$auxNames['pluralCamelCase'].';';
        }
    
    //--------------------------------------------------------------------------
    //------------------------------Rules---------------------------------------
    //--------------------------------------------------------------------------
    $rules = array();
    $rules['required'] = "";
    $rules['integer'] = "";
    $rules['float'] = "";
    $rules['boolean'] = "";
    $rules['date'] = "";
    $rules['datetime'] = "";
    $rules['emails'] = "";
    $rules['strings'] = array();
    $rules['search'] = "";
    
    foreach($table['columns'] as $column){
        $rules['required'] .= $column['name'].", ";
        $rules['search'] .= $column['name'].", ";
        switch($column['type']){
            case BuilderTypes::$FIXED_STRING: case BuilderTypes::$STRING:
                $textLength = $this->getColumnLength($table['name'],$column['name']);
                if($textLength!=0)
                    $rules['strings'][] = "array('".$column['name']."', 'length', 'max'=>".$textLength."),";
            break;
            case BuilderTypes::$FIXED_INT: case BuilderTypes::$INT:case BuilderTypes::$SELECT:
                $rules['integer'] .= $column['name'].", ";
            break;
            case BuilderTypes::$FIXED_FLOAT: case BuilderTypes::$FLOAT:
                $rules['float'] .= $column['name'].", ";
            break;
            case BuilderTypes::$CHECKBOX: case BuilderTypes::$FIXED_BOOLEAN: case BuilderTypes::$DELETED:
                $rules['boolean'] .= $column['name'].", ";
            break;
            case BuilderTypes::$DATE:
                $rules['date'] .= $column['name'].", ";
            break;
            case BuilderTypes::$DATETIME: case BuilderTypes::$CREATED_ON: case BuilderTypes::$UPDATED_ON:
                $rules['datetime'] .= $column['name'].", ";
            break;
            case BuilderTypes::$EMAIL:
                $rules['emails'] .= $column['name'].", ";
            break;
        }
    }
    
    if($rules['required']!="")
        $rules['required'] = "array('".$rules['required']."', 'required'),";
    if($rules['integer']!="")
        $rules['integer'] = "array('".$rules['integer']."', 'numerical', 'integerOnly'=>true),";
    if($rules['float']!="")
        $rules['float'] = "array('".$rules['float']."', 'numerical'),";
    if($rules['boolean']!="")
        $rules['boolean'] = "array('".$rules['boolean']."', 'boolean'),";
    if($rules['date']!="")
        $rules['date'] = "array('".$rules['date']."', 'date', 'format'=>'yyyy-MM-dd'),";
    if($rules['datetime']!="")
        $rules['datetime'] = "array('".$rules['datetime']."', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),";
    if($rules['emails']!="")
        $rules['emails'] = "array('".$rules['emails']."', 'email'),";
    if($rules['search']!="")
        $rules['search'] = "array('id, ".$rules['search']."', 'safe', 'on'=>'search'),";
    
    $rulesText = '';
    foreach($rules as $rule)
        if(is_array($rule))
            foreach($rule as $stringRule)
                $rulesText .= $stringRule ."
                        ";
        else
            if($rule!='')
                $rulesText .= $rule ."
                        ";
    
    //--------------------------------------------------------------------------
    //------------------------------Labels--------------------------------------
    //--------------------------------------------------------------------------
    $columnLabels = "'id' => 'ID',
                        ";
    foreach($table['columns'] as $column){
        $auxNames = $this->getModelNamesFromTableName($column['name']);
        $columnLabels .= "'".$auxNames['table']."' => '".$auxNames['plural']."',
                        ";
    }
    
    $columnCases = "case 'id': return 'ID';
                        ";
    foreach($table['columns'] as $column){
        $auxNames = $this->getModelNamesFromTableName($column['name']);
        $columnCases .= "case '".$auxNames['table']."': return '".$auxNames['plural']."';
                        ";
        
    }
    
    //--------------------------------------------------------------------------
    //------------------------------Search--------------------------------------
    //--------------------------------------------------------------------------
    $columnSearch = "";
    foreach($table['columns'] as $column){
        if($column['type']==BuilderTypes::$FIXED_STRING || $column['type']==BuilderTypes::$STRING || $column['type']==BuilderTypes::$EMAIL)
            $columnSearch .= "\$criteria->compare('".$column['name']."',\$this->".$column['name'].",true);
                ";
        else
            $columnSearch .= "\$criteria->compare('".$column['name']."',\$this->".$column['name'].");
                ";
    }
    
    //--------------------------------------------------------------------------
    //------------------------------Create--------------------------------------
    //--------------------------------------------------------------------------
    $create = 'public static function create(';
    foreach($table['columns'] as $column)
        if(BuilderTypes::canBeModifiedByUser($column['type']))
            $create .= "\$".$column['name'].", ";
    
    $create = substr($create, 0, strlen($create)-2);
    $create .= "){
            \$".$modelNames['singularCamelCase']." = new ".$modelNames['plural'].";";
    
    foreach($table['columns'] as $column)
        if(BuilderTypes::isFixed($column['type']))
            $create .= "
            \$".$modelNames['singularCamelCase']."->".$column['name']." = '".$column['typeValue']."';";
        else if($column['type']==BuilderTypes::$CREATED_ON || $column['type']==BuilderTypes::$UPDATED_ON)
            $create .= "
            \$".$modelNames['singularCamelCase']."->".$column['name']." = HelperFunctions::getDate();";
        else if($column['type']==BuilderTypes::$DELETED)
            $create .= "
            \$".$modelNames['singularCamelCase']."->".$column['name']." = 0;";
        else if($column['type']==BuilderTypes::$POSITION)
            $create .= "
            \$".$modelNames['singularCamelCase']."->".$column['name']." = 0;";
        else
            $create .= "
            \$".$modelNames['singularCamelCase']."->".$column['name']." = \$".$column['name'].";";
    
    $create .= "
            if(\$".$modelNames['singularCamelCase']."->save())
                return \$".$modelNames['singularCamelCase'].";
            else{
                Errors::log('Error en Models/".$modelNames['plural']."/create','Error creating ".$modelNames['singularCamelCase']."',print_r(\$".$modelNames['singularCamelCase']."->getErrors(),true));
                return \$".$modelNames['singularCamelCase'].";
            }
        }";
    
    //--------------------------------------------------------------------------
    //----------------------------Check Unique----------------------------------
    //--------------------------------------------------------------------------
    $checkUnique = "";
    $checkUniqueVariables = "";
    $checkUniqueConditions = "";
    $checkUniqueSQLVariables = "";
    $hasUnique = false;
    
    foreach($table['columns'] as $column)
        if($column['unique']=='1'){
            $checkUniqueVariables .= "\$".$column['name'].", ";
            $checkUniqueConditions .= $column['name']."=:".$column['name']."Var AND ";
            $checkUniqueSQLVariables .= "'".$column['name']."Var'=>\$".$column['name'].", ";
            $hasUnique = true;
        }
        
    if($hasUnique){
        $checkUniqueVariables = substr($checkUniqueVariables, 0, strlen($checkUniqueVariables)-2);
        $checkUniqueConditions = substr($checkUniqueConditions, 0, strlen($checkUniqueConditions)-5);
        $checkUniqueSQLVariables = substr($checkUniqueSQLVariables, 0, strlen($checkUniqueSQLVariables)-2);
        
        $checkUnique = "public static function checkUnique(".$checkUniqueVariables.", \$id=0){
            \$".$modelNames['pluralCamelCase']." = self::model()->findAll(\"".$checkUniqueConditions."\",array(".$checkUniqueSQLVariables."));
            if(count(\$".$modelNames['pluralCamelCase'].")>1)
                return false;
            else if(count(\$".$modelNames['pluralCamelCase'].")==1 && \$".$modelNames['pluralCamelCase']."[0]->id!=\$id)
                return false;
            return true;
        }";
    }
    
    
    
    
    
    
    //--------------------------------------------------------------------------
    //-------------------------UpdateAttributes---------------------------------
    //--------------------------------------------------------------------------
    $updateAttributes = "public function updateAttributes(";
    foreach($table['columns'] as $column)
        if(BuilderTypes::canBeModifiedByUser($column['type']))
            $updateAttributes .= "\$".$column['name'].", ";
    
    $updateAttributes = substr($updateAttributes, 0, strlen($updateAttributes)-2);
    $updateAttributes .= "){";
    
    foreach($table['columns'] as $column)
        if(BuilderTypes::isFixed($column['type']))
            $updateAttributes .= "
            \$this->".$column['name']." = '".$column['typeValue']."';";
        else if($column['type']==BuilderTypes::$UPDATED_ON)
            $updateAttributes .= "
            \$this->".$column['name']." = HelperFunctions::getDate();";
        else if(BuilderTypes::canBeModifiedByUser($column['type']))
            $updateAttributes .= "
            \$this->".$column['name']." = \$".$column['name'].";";
        
    $updateAttributes .= "
            if(\$this->save())
                return true;
            else{
                Errors::log('Error en Models/".$modelNames['plural']."/update".$modelNames['singular']."','Error updating ".$modelNames['singularCamelCase']." id:\$this->id', print_r(\$this->getErrors(),true));
                return false;
            }
        }";
    
    
    //--------------------------------------------------------------------------
    //--------------------------SavePositions-----------------------------------
    //--------------------------------------------------------------------------
    
    $positions = false;
    $positionsData = "";
    $positionsSQLOption = "";
    
    foreach($table['columns'] as $column)
        if($column['type']==BuilderTypes::$POSITION)
            $positions = true;
        
    if($positions){
        $positionsData = "
            
        public static function savePositions(\$".$modelNames['singularCamelCase']."Ids){
            \$counter = 0;
            foreach(\$".$modelNames['singularCamelCase']."Ids as \$".$modelNames['singularCamelCase']."Id){
                \$".$modelNames['singularCamelCase']." = self::get(\$".$modelNames['singularCamelCase']."Id);
                if(\$".$modelNames['singularCamelCase']."!=false){
                    \$".$modelNames['singularCamelCase']."->position = \$counter;
                    \$".$modelNames['singularCamelCase']."->save();
                    \$counter++;
                }
            }
        }
        
        ";
        $positionsSQLOption = " ORDER BY position ASC";
    }
    
    //--------------------------------------------------------------------------
    //------------------------------Delete--------------------------------------
    //--------------------------------------------------------------------------
    $delete = '';
    $hasDeleted = false;
    $deleteColumn = "";
    $hasUpdatedOn = false;
    $updatedOnColumn = "";
    $hasPosition = false;
    $positionColumn = "";
    $deletedSQLOption = "";
    $deletedSQLOptionAnd = "";
    
    foreach($table['columns'] as $column)
        if($column['type']==BuilderTypes::$DELETED){
            $hasDeleted = true;
            $deleteColumn = $column['name'];
        }
        else if($column['type']==BuilderTypes::$UPDATED_ON){
            $hasUpdatedOn = true;
            $updatedOnColumn = $column['name'];
        }
        else if($column['type']==BuilderTypes::$POSITION){
            $hasPosition = true;
            $positionColumn = $column['name'];
        }
    
    if($hasDeleted){
        $delete = "public function delete".$modelNames['singular']."(){
            \$this->".$deleteColumn." = 1;";
        if($hasUpdatedOn)
            $delete .= "
            \$this->".$updatedOnColumn." = HelperFunctions::getDate();";
        if($hasPosition)
            $delete .= "
            \$this->".$positionColumn." = 0;";
        
        $delete .= "
            if(\$this->save())
                return true;
            else{
                Errors::log('Error en Models/".$modelNames['plural']."/delete".$modelNames['singular']."','Error deleting ".$modelNames['singularCamelCase']." id:\$this->id', print_r(\$this->getErrors(),true));
                return false;
            }
        }";
        
        $deletedSQLOption = " AND ".$deleteColumn."=0";
        $deletedSQLOptionAnd = " AND ".$deleteColumn."=0";
    }
    else{
        $delete = "public function delete".$modelNames['singular']."(){
                if(\$this->delete())
                    return true;
                else{
                    Errors::log('Error en Models/".$modelNames['plural']."/delete".$modelNames['singular']."','Error deleting ".$modelNames['singularCamelCase']." id:\$this->id', print_r(\$this->getErrors(),true));
                    return false;
                }
            }";
    }
    
    
    
    //--------------------------------------------------------------------------
    //--------------------------LoadManyToThis----------------------------------
    //--------------------------------------------------------------------------
    $loadManyToThis = "";
    if(isset($table['manyToThis'])){
        foreach($table['manyToThis'] as $manyToThis){
            $auxNames = $this->getModelNamesFromTableName($manyToThis['table']);
            
            $positionAux = "";
            $deletedAux = "";
            
            foreach($manyToThis['columns'] as $column)
                if($column['type']==BuilderTypes::$POSITION)
                    $positionAux = " ORDER BY ".$column['name']." ASC";
                else if($column['type']==BuilderTypes::$DELETED)
                    $deletedAux = " AND ".$column['name']."=0";
            
            $loadManyToThis .= "
                
        public function load".$auxNames['plural']."(){
            \$".$auxNames['pluralCamelCase']." = ".$auxNames['plural']."::model()->findAll('".$manyToThis['key']."=:".$modelNames['singularCamelCase']."Id ".$deletedAux." ".$positionAux."',array('".$modelNames['singularCamelCase']."Id'=>\$this->id));
            if(count(\$".$auxNames['pluralCamelCase'].")>0)
                \$this->".$auxNames['pluralCamelCase']." = \$".$auxNames['pluralCamelCase'].";
            else 
                \$this->".$auxNames['pluralCamelCase']." = array();
        }";
        }
    }
    
    
    //--------------------------------------------------------------------------
    //----------------------------LoadFiles-------------------------------------
    //--------------------------------------------------------------------------
    $loadFiles = '';
    if(isset($table['files'])){
        foreach($table['files'] as $file){
            $auxNames = $this->getModelNamesFromTableName($file['table']);
            
            $loadFiles .= "
                
        public function load".$auxNames['plural']."(){
            \$this->".$auxNames['pluralCamelCase']." = array();
            \$".$auxNames['pluralCamelCase']." = ".$auxNames['plural']."::model()->findAll('".$file['key']."=:".$modelNames['singularCamelCase']."Id AND deleted=0 ORDER BY position ASC',array('".$modelNames['singularCamelCase']."Id'=>\$this->id));
            foreach(\$".$auxNames['pluralCamelCase']." as \$".$auxNames['singularCamelCase']."){
                    \$file = Files::get(\$".$auxNames['singularCamelCase']."->file_id);
                    if(\$file!==false)
                        \$this->".$auxNames['pluralCamelCase']."[] = \$file;
            }
        }";
        }
    }
    
    //--------------------------------------------------------------------------
    //------------------------SearchThroughTables-------------------------------
    //--------------------------------------------------------------------------
    $searchThroughTablesFunctions = "";
    
    if(isset($table['searchThroughTables'])){
        foreach($table['searchThroughTables'] as $searchThroughTable){
                $tableNames = self::getModelNamesFromTableName($searchThroughTable['table']);
                $columnNames = self::getModelNamesFromTableName($searchThroughTable['through']);
                $searchThroughTablesFunctions .= "
            public function getAllFrom".$tableNames['singular']."(\$".$columnNames['pluralCamelCase']."){
                return self::model()->findAll('".$columnNames['table']."=:".$columnNames['pluralCamelCase'].$deletedSQLOptionAnd."',array('".$columnNames['pluralCamelCase']."'=>\$".$columnNames['pluralCamelCase']."));
            }
                ";
        }
    }
    
    //--------------------------------------------------------------------------
    //--------------------------LoadSingleFiles---------------------------------
    //--------------------------------------------------------------------------
    $loadSingleFiles = "";
    
    foreach($table['columns'] as $column){
        $columnNames = $this->getModelNamesFromTableName($column['name']);
        if($column['type']==BuilderTypes::$SINGLE_FILE){
            $loadSingleFiles = "
    public function load".$columnNames['noId']."(){
            \$this->".$columnNames['noIdCamelCase']." = Files::get(\$this->".$column['name'].");
        }";
        }
    }
    
        
$data = "<?php

/**
 * This is the model class for table \"".$modelNames['table']."\".
 *
 * The followings are the available columns in table '".$modelNames['table']."':
 ".$columnTypes."
 */
 
class ".$modelNames['plural']." extends CActiveRecord{
    ".$variables."
        
        
        public static function getModelName(\$type){
            switch(\$type){
                case 'plural': return '".$modelNames['plural']."';
                case 'singular': return '".$modelNames['singular']."';
                case 'pluralCamelCase': return '".$modelNames['pluralCamelCase']."';
                case 'singularCamelCase': return '".$modelNames['singularCamelCase']."';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return ".$modelNames['plural']." the static model class
	 */
	public static function model(\$className=__CLASS__){
		return parent::model(\$className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return '".$modelNames['table']."';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			".$rulesText."
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			".$columnLabels."
		);
	}
        
        
	public static function getAttributeName(\$name){
            switch(\$name){
                ".$columnCases."
                default: return '';
            }
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		\$criteria=new CDbCriteria;

		".$columnSearch."

		return new CActiveDataProvider(get_class(\$this), array(
			'criteria'=>\$criteria,
		));
	}
        
        public static function get(\$id){
            \$".$modelNames['singularCamelCase']." = self::model()->findByPk(\$id);
            if(isset(\$".$modelNames['singularCamelCase']."->id))
                return \$".$modelNames['singularCamelCase'].";
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0".$deletedSQLOption.$positionsSQLOption."');
        }
        
        ".$create."
            
        ".$updateAttributes."
            
        ".$checkUnique."
            
        ".$positionsData."
            
        ".$delete.$loadManyToThis.$loadFiles."
            
        ".$searchThroughTablesFunctions."
            
        ".$loadSingleFiles."
}
?>";
?>