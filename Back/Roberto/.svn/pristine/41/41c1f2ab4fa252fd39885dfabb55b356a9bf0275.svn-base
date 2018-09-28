<?php
  
$data = "<?php

/**
 * This is the model class for table \"".$file['table']."\".
 *
 * The followings are the available columns in table 'sport_files':
 * @property integer \$id
 * @property integer \$".$file['key']."
 * @property integer \$file_id
 * @property integer \$position
 * @property date \$updated_on
 * @property boolean \$deleted
 */
 
class ".$fileNames['plural']." extends CActiveRecord{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ".$fileNames['plural']." the static model class
	 */
	public static function model(\$className=__CLASS__)
	{
		return parent::model(\$className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '".$fileNames['table']."';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('".$file['key'].", file_id, position, updated_on, deleted', 'required'),
			array('".$file['key'].", file_id, position', 'numerical', 'integerOnly'=>true),
			array('updated_on', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('deleted', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ".$file['key'].", file_id, position, updated_on, deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'".$file['key']."' => '".$modelNames['singular']."',
			'file_id' => 'File',
			'position' => 'Position',
			'updated_on' => 'Updated On',
			'deleted' => 'Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		\$criteria=new CDbCriteria;

		\$criteria->compare('id',\$this->id);
		\$criteria->compare('".$file['key']."',\$this->".$file['key'].");
		\$criteria->compare('file_id',\$this->file_id);
		\$criteria->compare('position',\$this->position);
		\$criteria->compare('updated_on',\$this->updated_on);
		\$criteria->compare('deleted',\$this->deleted,true);

		return new CActiveDataProvider(get_class(\$this), array(
			'criteria'=>\$criteria,
		));
	}
        
        public static function getBy".$modelNames['singular']."AndFileId($".$modelNames['singularCamelCase']."Id, \$fileId){
            \$file = ".$fileNames['plural']."::model()->find('".$file['key']."='.\$".$modelNames['singularCamelCase']."Id.' AND file_id='.\$fileId);
            if(isset(\$file->id))
                return \$file;
            else
                return false;
        }
        
        public static function getAllFrom".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."Id){
            return ".$fileNames['plural']."::model()->findAll('".$modelNames['singularCamelCase']."_id='.\$".$modelNames['singularCamelCase']."Id);
        }
        
        public static function update".$modelNames['singular']."(\$".$modelNames['singularCamelCase']."Id, \$files, \$new){
            
            if(!\$new)
                foreach(\$files as \$file)
                    if(\$file['deleted']==1 && \$file['id']!=0){
                        \$existing".$fileNames['singular']." = self::getBy".$modelNames['singular']."AndFileId(\$".$modelNames['singularCamelCase']."Id, \$file['id']);
                        if(\$existing".$fileNames['singular']."!=false){
                            \$existing".$fileNames['singular']."->deleted = 1;
                            \$existing".$fileNames['singular']."->position = 0;
                            \$existing".$fileNames['singular']."->save();
                        }
                    }
            
            \$position = 1;
            foreach(\$files as \$file)
                if(isset(\$file['id']) && is_numeric(\$file['id']) && isset(\$file['name']) && isset(\$file['file_type_id']) && \$file['deleted']==0){
                    \$fileAux = Files::get(\$file['id']);
                    if(isset(\$fileAux->id)){
                        \$fileAux->name = \$file['name'];
                        if(FileTypes::validFileType(\$file['file_type_id']))
                            \$fileAux->file_type_id = \$file['file_type_id'];
                        \$fileAux->updated_on = HelperFunctions::getDate();
                        \$fileAux->save();
                        
                        \$".$fileNames['singularCamelCase']."Aux = ".$fileNames['plural']."::getBy".$modelNames['singular']."AndFileId(\$".$modelNames['singularCamelCase']."Id, \$file['id']);
                        if(\$".$fileNames['singularCamelCase']."Aux===false)
                            \$".$fileNames['singularCamelCase']."Aux = new ".$fileNames['plural'].";

                        \$".$fileNames['singularCamelCase']."Aux->".$file['key']." = \$".$modelNames['singularCamelCase']."Id;
                        \$".$fileNames['singularCamelCase']."Aux->file_id = \$file['id'];
                        \$".$fileNames['singularCamelCase']."Aux->position = \$position;
                        \$".$fileNames['singularCamelCase']."Aux->updated_on = HelperFunctions::getDate();
                        \$".$fileNames['singularCamelCase']."Aux->deleted = 0;
                        \$".$fileNames['singularCamelCase']."Aux->save();
                        \$position++;
                    }
                }
        }
}
?>";
?>