<?php

/**
 * This is the model class for table "contact_messages".
 *
 * The followings are the available columns in table 'contact_messages':
 * @property integer $id
 * @property string $name
 * @property string $reply_address
 * @property string $message
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class ContactMessages extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'ContactMessages';
                case 'singular': return 'ContactMessag';
                case 'pluralCamelCase': return 'contactMessages';
                case 'singularCamelCase': return 'contactMessag';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContactMessages the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'contact_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, reply_address, message, created_on, updated_on, deleted, ', 'required'),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>128),
                        array('reply_address', 'length', 'max'=>128),
                        array('message', 'length', 'max'=>512),
                        array('id, name, reply_address, message, created_on, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'reply_address' => 'ReplyAddress',
                        'message' => 'Message',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'name': return 'Name';
                        case 'reply_address': return 'ReplyAddress';
                        case 'message': return 'Message';
                        case 'created_on': return 'CreatedOn';
                        case 'updated_on': return 'UpdatedOn';
                        case 'deleted': return 'Deleted';
                        
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

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
                $criteria->compare('reply_address',$this->reply_address,true);
                $criteria->compare('message',$this->message,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $contactMessag = self::model()->findByPk($id);
            if(isset($contactMessag->id))
                return $contactMessag;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name, $reply_address, $message){
            $contactMessag = new ContactMessages;
            $contactMessag->name = $name;
            $contactMessag->reply_address = $reply_address;
            $contactMessag->message = $message;
            $contactMessag->created_on = HelperFunctions::getDate();
            $contactMessag->updated_on = HelperFunctions::getDate();
            $contactMessag->deleted = 0;
            if($contactMessag->save())
                return $contactMessag;
            else{
                Errors::log('Error en Models/ContactMessages/create','Error creating contactMessag',print_r($contactMessag->getErrors(),true));
                return $contactMessag;
            }
        }
            
        public function updateAttributes($name, $reply_address, $message){
            $this->name = $name;
            $this->reply_address = $reply_address;
            $this->message = $message;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/ContactMessages/updateContactMessag','Error updating contactMessag id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteContactMessag(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/ContactMessages/deleteContactMessag','Error deleting contactMessag id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
}
?>