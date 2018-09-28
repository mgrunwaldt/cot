<?php

/**
 * This is the model class for table "web_texts".
 *
 * The followings are the available columns in table 'web_texts':
 * @property integer $id
 * @property string $name
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class WebTexts extends CActiveRecord{
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return WebTexts the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'web_texts';
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
            $webText = self::model()->findByPk($id);
            if(isset($webText->id))
                return $webText;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
         public static function getAllArray(){
            $webTexts=self::model()->findAll('id>0 AND deleted=0');
            
            $result=array();
            
            foreach($webTexts as $text){               
                
                $result[]=array('id'=>$text->id,
                                'name'=>$text->name,                                   
                                    );
            }
            
            return $result;
        }
        
        
        public static function create($name){
            
            $webText = new WebTexts;
            $webText->name = $name;
            $webText->updated_on = HelperFunctions::getDate();
            $webText->deleted = 0;
            
            if($webText->save())
                return $webText;
            else{
                Errors::log('Error en Models/WebTexts/create','Error creating webText',print_r($webText->getErrors(),true));
                return $webText;
            }
        }
            
        public function updateAttributes($name){
            $this->name = $name;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WebTexts/updateWebText','Error updating webText id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        public function deleteWebText(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WebTexts/deleteWebText','Error deleting webText id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
        
        
        public static function getValueByName($name){
            
            $language_id= Languages::$SPANISH;
            if(isset(Yii::app()->session['session_lang_id']) && is_numeric(Yii::app()->session['session_lang_id']))
                $language_id = Yii::app()->session['session_lang_id'];
            else
                Yii::app()->session['session_lang_id'] = $language_id;
            
            $webText=WebTexts::model()->find("name='".$name."'");
            
            if(isset($webText->id)){
                $languageWebText=LanguageWebTexts::model()->find("web_text_id=".$webText->id." AND language_id=".$language_id);
                
                if(isset($languageWebText->id)){
                    return $languageWebText->value;
                }
            }
        }
     
        public static function getValueById($id){
            
            $languageWebText=LanguageWebTexts::model()->find("web_text_id=".$id." AND language_id=".Yii::app()->session['session_lang_id']);
  
            if(isset($languageWebText->id))
                return $languageWebText->value;
            
        }
        
}
?>