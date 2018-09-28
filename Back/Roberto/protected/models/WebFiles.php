<?php

/**
 * This is the model class for table "web_files".
 *
 * The followings are the available columns in table 'web_files':
 * @property integer $id
 * @property string $name
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class WebFiles extends CActiveRecord{
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return WebFiles the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'web_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, updated_on, deleted, ', 'required'),
                        array('deleted, ', 'boolean'),
                        array('updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>100),
                        array('id, name, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
			'id' => 'ID',
                        'name' => 'Name',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $webFil = self::model()->findByPk($id);
            if(isset($webFil->id))
                return $webFil;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name){
            $webFil = new WebFiles;
            $webFil->name = $name;
            $webFil->updated_on = HelperFunctions::getDate();
            $webFil->deleted = 0;
            if($webFil->save())
                return $webFil;
            else{
                Errors::log('Error en Models/WebFiles/create','Error creating webFil',print_r($webFil->getErrors(),true));
                return $webFil;
            }
        }
            
        public function updateAttributes($name){
            $this->name = $name;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WebFiles/updateWebFil','Error updating webFil id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        public function deleteWebFil(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WebFiles/deleteWebFil','Error deleting webFil id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
        
        
        public static function getPathById($id){
             $languageWebFile=LanguageWebFiles::model()->find("web_file_id=".$id." AND language_id=".Yii::app()->session['session_lang_id']);
  
            if(isset($languageWebFile->id)){
                
                $file=Files::model()->findByPk($languageWebFile->file_id);
               
                if(isset($file->id)){
                    return $file->url;
                }
            
            }   
        
        }
        
}
?>