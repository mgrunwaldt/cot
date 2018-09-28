<?php
    //--------------------------------------------------------------------------
    //---------------------------ColumnTypes------------------------------------
    //--------------------------------------------------------------------------
    $columnTypes = "* @property integer \$id";
    foreach($manyToThis['columns'] as $column){
        switch($column['type']){
            case BuilderTypes::$FIXED_STRING: case BuilderTypes::$STRING: case BuilderTypes::$EMAIL:
                $columnTypes .= "
 * @property string \$".$column['name'];
            break;
            case BuilderTypes::$FIXED_INT: case BuilderTypes::$INT: case BuilderTypes::$POSITION:
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
    
    foreach($manyToThis['columns'] as $column){
        $rules['required'] .= $column['name'].", ";
        $rules['search'] .= $column['name'].", ";
        switch($column['type']){
            case BuilderTypes::$FIXED_STRING: case BuilderTypes::$STRING:
                $rules['strings'][] = "array('".$column['name']."', 'length', 'max'=>".$this->getColumnLength($manyToThis['table'],$column['name'])."),";
            break;
            case BuilderTypes::$FIXED_INT: case BuilderTypes::$INT:  case BuilderTypes::$POSITION:
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
    foreach($manyToThis['columns'] as $column){
        $auxNames = $this->getModelNamesFromTableName($column['name']);
        $columnLabels .= "'".$auxNames['table']."' => '".$auxNames['plural']."',
                        ";
        
    }
    
    $columnCases = "case 'id': return 'ID';
                        ";
    foreach($manyToThis['columns'] as $column){
        $auxNames = $this->getModelNamesFromTableName($column['name']);
        $columnCases .= "case '".$auxNames['table']."': return '".$auxNames['plural']."';
                        ";
    }
    
    //--------------------------------------------------------------------------
    //------------------------------Search--------------------------------------
    //--------------------------------------------------------------------------
    $columnSearch = "";
    foreach($manyToThis['columns'] as $column){
        if($column['type']==BuilderTypes::$FIXED_STRING || $column['type']==BuilderTypes::$STRING || $column['type']==BuilderTypes::$EMAIL)
            $columnSearch .= "\$criteria->compare('".$column['name']."',\$this->".$column['name'].",true);
                ";
        else
            $columnSearch .= "\$criteria->compare('".$column['name']."',\$this->".$column['name'].");
                ";
    }
    
    //--------------------------------------------------------------------------
    //------------------------------Update--------------------------------------
    //--------------------------------------------------------------------------
    $update = "";
    $updateDelete = "";
    $updateFixedVars = "";
    $update .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$manyToThis['key']." = \$".$modelNames['singularCamelCase']."Id;
                ";
    foreach($manyToThis['columns'] as $column){
        if($column['name']!=$manyToThis['key']){
            if(BuilderTypes::isFixed($column['type']))
                $updateFixedVars .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = '".$column['typeValue']."';
                ";
            if($column['type']==BuilderTypes::$DELETED)
                $updateFixedVars .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = 0;
                ";
            else if($column['type']==BuilderTypes::$CREATED_ON)
                $updateFixedVars .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = HelperFunctions::getDate();
                ";
            else if($column['type']==BuilderTypes::$UPDATED_ON)
                $update .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = HelperFunctions::getDate();
                ";
            else if($column['type']==BuilderTypes::$POSITION)
                $update .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = \$position;
                ";
            else if(BuilderTypes::canBeModifiedByUser($column['type']))
                $update .= "\$".$manyToThisNames['singularCamelCase']."Aux->".$column['name']." = \$".$manyToThisNames['singularCamelCase']."['".$column['name']."'];
                ";
        }
    }
        
    $deleted = false;
    $deletedColumn = '';
    $updatedOn = false;
    $updatedOnColumn = '';
    $position = false;
    $positionColumn = '';
    foreach($manyToThis['columns'] as $column)
        if($column['type']==BuilderTypes::$DELETED){
            $deleted = true;
            $deletedColumn = $column['name'];
        }
        else if($column['type']==BuilderTypes::$UPDATED_ON){
            
        }
        else if($column['type']==BuilderTypes::$POSITION){
            $updatedOn = true;
            $updatedOnColumn = $column['name'];
        }
            
    if($deleted){
        $updateDelete = "   
            if(!\$new)
                foreach(\$".$manyToThisNames['pluralCamelCase']." as \$".$manyToThisNames['singularCamelCase'].")
                    if(\$".$manyToThisNames['singularCamelCase']."['deleted']==1 && \$".$manyToThisNames['singularCamelCase']."['id']!=0){
                        \$existing".$manyToThisNames['singular']." = ".$manyToThisNames['plural']."::get(\$".$manyToThisNames['singularCamelCase']."['id']);
                        \$existing".$manyToThisNames['singular']."->".$deletedColumn." = 1;
                ";
        if($position)
            $updateDelete .= " 
                            \$existing".$manyToThisNames['singular']."->".$positionColumn." = 0;";
        if($updatedOn)
            $updateDelete .= " 
                            \$existing".$manyToThisNames['singular']."->".$updatedOnColumn." = HelperFunctions::getDate();";
        $updateDelete .= " 
                            \$existing".$manyToThisNames['singular']."->save();
                        }";
    }else{
        $updateDelete = "   
            if(!\$new)
                foreach(\$".$manyToThisNames['pluralCamelCase']." as \$".$manyToThisNames['singularCamelCase'].")
                    if(\$".$manyToThisNames['singularCamelCase']."['deleted']==1 && \$".$manyToThisNames['singularCamelCase']."['id']!=0){
                        \$existing".$manyToThisNames['singular']." = ".$manyToThisNames['plural']."::get(\$".$manyToThisNames['singularCamelCase']."['id']);
                        \$existing".$manyToThisNames['singular']."->delete();
                    }
            ";
    }
        
$data = "<?php

/**
 * This is the model class for table \"".$manyToThisNames['table']."\".
 *
 * The followings are the available columns in table '".$manyToThisNames['table']."':
 ".$columnTypes."
 */
 
class ".$manyToThisNames['plural']." extends CActiveRecord{
        
        
        public static function getModelName(\$type){
            switch(\$type){
                case 'plural': return '".$manyToThisNames['plural']."';
                case 'singular': return '".$manyToThisNames['singular']."';
                case 'pluralCamelCase': return '".$manyToThisNames['pluralCamelCase']."';
                case 'singularCamelCase': return '".$manyToThisNames['singularCamelCase']."';
                default: return '';
            }
        }
	/**
	 * Returns the static model of the specified AR class.
	 * @return ".$manyToThisNames['plural']." the static model class
	 */
	public static function model(\$className=__CLASS__){
		return parent::model(\$className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return '".$manyToThisNames['table']."';
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
            \$".$manyToThisNames['singularCamelCase']." = ".$manyToThisNames['plural']."::model()->findByPk(\$id);
            if(isset(\$".$manyToThisNames['singularCamelCase']."->id))
                return \$".$manyToThisNames['singularCamelCase'].";
            else
                return false;
        }
        
        public static function getAllFrom".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."Id){
            return ".$manyToThisNames['plural']."::model()->findAll('".$modelNames['singularCamelCase']."_id='.\$".$modelNames['singularCamelCase']."Id);
        }
        
        public static function update".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."Id, \$".$manyToThisNames['pluralCamelCase'].", \$new){
            ".$updateDelete."
            \$position = 1;
            foreach(\$".$manyToThisNames['pluralCamelCase']." as \$".$manyToThisNames['singularCamelCase'].")
                if(\$".$manyToThisNames['singularCamelCase']."['deleted']==0){
                    \$".$manyToThisNames['singularCamelCase']."Aux = ".$manyToThisNames['plural']."::get(\$".$manyToThisNames['singularCamelCase']."['id']);
                    if(\$".$manyToThisNames['singularCamelCase']."Aux===false){
                        \$".$manyToThisNames['singularCamelCase']."Aux = new ".$manyToThisNames['plural'].";
                        ".$updateFixedVars."
                    }

                    ".$update."
                    \$".$manyToThisNames['singularCamelCase']."Aux->save();
                    \$position++;
                }
        }
}
?>";
?>