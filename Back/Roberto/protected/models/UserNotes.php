<?php

/**
 * This is the model class for table "user_notes".
 *
 * The followings are the available columns in table 'user_notes':
 * @property integer $id
 * @property string $text
 * @property integer $administrator_id
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class UserNotes extends CActiveRecord{
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Notas de Usuario';
                case 'singular': return 'Nota de Usuario';
                case 'pluralCamelCase': return 'notasDeUsuario';
                case 'singularCamelCase': return 'notaDeUsuario';
                default: return '';
            }
        }
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserNotes the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'user_notes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, text, administrator_id, created_on, updated_on, deleted, ', 'required'),
                        array('administrator_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, user_id, text, administrator_id, created_on, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'user_id' => 'UserId',
                        'text' => 'Text',
                        'administrator_id' => 'AdministratorId',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'user_id': return 'UserId';
                        case 'text': return 'Text';
                        case 'administrator_id': return 'AdministratorId';
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

		$criteria->compare('user_id',$this->user_id);
                $criteria->compare('text',$this->text,true);
                $criteria->compare('administrator_id',$this->administrator_id);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $userNot = UserNotes::model()->findByPk($id);
            if(isset($userNot->id))
                return $userNot;
            else
                return false;
        }
        
        public static function getAllFromUser($userId){
            return UserNotes::model()->findAll('user_id='.$userId);
        }
        
        public static function updateUser($userId, $userNotes, $new, $administratorId){
               
            $position = 1;
            foreach($userNotes as $userNot)
                if($userNot['deleted']==0){
                    $userNotAux = UserNotes::get($userNot['id']);
                    if($userNotAux===false){
                        $userNotAux = new UserNotes;
                        $userNotAux->administrator_id = $administratorId;
                $userNotAux->created_on = HelperFunctions::getDate();
                $userNotAux->deleted = 0;
                
                    }

                    $userNotAux->user_id = $userId;
                $userNotAux->text = $userNot['text'];
                $userNotAux->updated_on = HelperFunctions::getDate();
                
                    $userNotAux->save();
                    $position++;
                }
        }
}
?>