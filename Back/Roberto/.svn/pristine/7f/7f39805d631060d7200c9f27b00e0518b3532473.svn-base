<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $category_id
 * @property integer $ranch_id
 * @property boolean $added_to_mailchimp
 * @property datetime $updated_on
 * @property datetime $created_on
 * @property boolean $deleted
 */
 
class Users extends CActiveRecord{
    
        public $ranch;
        public $userNotes;
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Usuarios';
                case 'singular': return 'Usuario';
                case 'pluralCamelCase': return 'usuarios';
                case 'singularCamelCase': return 'usuario';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, phone, category_id, ranch_id, added_to_mailchimp, updated_on, created_on, deleted, ', 'required'),
                        array('category_id, ranch_id', 'numerical', 'integerOnly'=>true),
                        array('deleted,added_to_mailchimp, ', 'boolean'),
                        array('updated_on, created_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('email, ', 'email'),
                        array('name', 'length', 'max'=>128),
                        array('phone', 'length', 'max'=>128),
                        array('id, name, email, phone, category_id, ranch_id, added_to_mailchimp, updated_on, created_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'name' => 'Nombre',
                        'email' => 'Email',
                        'phone' => 'Teléfono',
                        'category_id' => 'Categoría',
                        'ranch_id' => 'Chacra',
                        'added_to_mailchimp' => 'Agregado a mailchimp',
                        'updated_on' => 'Fecha de actualización',
                        'created_on' => 'Fecha de creación',
                        'deleted' => 'Eliminado',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'name': return 'Nombre';
                        case 'email': return 'Email';
                        case 'phone': return 'Teléfono';
                        case 'category_id': return 'Categoría';
                        case 'ranch_id': return 'Chacra';
                        case 'added_to_mailchimp': return 'Agregado a mailchimp';
                        case 'updated_on': return 'Fecha de actualización';
                        case 'created_on': return 'Fecha de creación';
                        case 'deleted': return 'Eliminado';
                        
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
                $criteria->compare('email',$this->email,true);
                $criteria->compare('phone',$this->phone,true);
                $criteria->compare('category_id',$this->category_id);
                $criteria->compare('ranch_id',$this->ranch_id,true);
                $criteria->compare('added_to_mailchimp',$this->added_to_mailchimp,true);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $user = self::model()->findByPk($id);
            if(isset($user->id))
                return $user;
            else
                return false;
        }
        
        public static function getByEmail($email){
            $user = self::model()->find('id > 0 AND email = :email AND deleted = 0',
                    array('email'=>$email));
            if(isset($user->id))
                return $user;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name, $email, $phone, $category_id, $ranch_id){
            $user = new Users;
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->category_id = $category_id;
            $user->ranch_id = $ranch_id;
            $user->added_to_mailchimp = 0;
            $user->updated_on = HelperFunctions::getDate();
            $user->created_on = HelperFunctions::getDate();
            $user->deleted = 0;
            if($user->save())
                return $user;
            else{
                Errors::log('Error en Models/Users/create','Error creating user',print_r($user->getErrors(),true));
                return $user;
            }
        }
            
        public function updateAttributes($name, $email, $phone, $category_id, $ranch_id){
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->category_id = $category_id;
            $this->ranch_id = $ranch_id;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Users/updateUser','Error updating user id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        public function deleteUser(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Users/deleteUser','Error deleting user id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
                
        public function loadUserNotes(){
            $userNotes = UserNotes::model()->findAll('user_id=:userId  AND deleted=0 ',array('userId'=>$this->id));
            if(count($userNotes)>0)
                $this->userNotes = $userNotes;
            else 
                $this->userNotes = array();
        }
                
        public function loadRanch(){
            $this->ranch = Ranches::get($this->ranch_id);
        }
                
        public static function getCurrent(){
            return false;
        }
}
?>