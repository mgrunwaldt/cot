<?php

/**
 * This is the model class for table "administrator_login_attempts".
 *
 * The followings are the available columns in table 'administrator_login_attempts':
 * @property integer $id
 * @property string $email
 * @property datetime $created_on
 * @property boolean $success
 * @property string $ip
 * @property string $cookie
 * @property string $session
 */
 
class AdministratorLoginAttempts extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'AdministratorLoginAttempts';
                case 'singular': return 'AdministratorLoginAttempt';
                case 'pluralCamelCase': return 'administratorLoginAttempts';
                case 'singularCamelCase': return 'administratorLoginAttempt';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdministratorLoginAttempts the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'administrator_login_attempts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, created_on, success, ip, cookie, session, ', 'required'),
                        //array('email, created_on, success, ip, cookie, session, ', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
                        array('success, ', 'boolean'),
                        array('created_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('email, ', 'email'),
                        array('ip', 'length', 'max'=>32),
                        array('cookie', 'length', 'max'=>32),
                        array('session', 'length', 'max'=>32),
                        array('id, email, created_on, success, ip, cookie, session, ', 'safe', 'on'=>'search'),
                        
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
                        'email' => 'Email',
                        'created_on' => 'CreatedOn',
                        'success' => 'Success',
                        'ip' => 'Ip',
                        'cookie' => 'Cookie',
                        'session' => 'Session',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'email': return 'Email';
                        case 'created_on': return 'CreatedOn';
                        case 'success': return 'Success';
                        case 'ip': return 'Ip';
                        case 'cookie': return 'Cookie';
                        case 'session': return 'Session';
                        
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

		$criteria->compare('email',$this->email,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('success',$this->success);
                $criteria->compare('ip',$this->ip,true);
                $criteria->compare('cookie',$this->cookie,true);
                $criteria->compare('session',$this->session,true);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getConsecutiveFailedLoginAttemptsInLastHour($email){
            $oneHourAgo = HelperFunctions::addHoursToToday(-1);
            $administratorLoginAttempts = self::model()->findAll('email = :email AND created_on > :oneHourAgo ORDER BY created_on ASC',array('email'=>$email, 'oneHourAgo'=>$oneHourAgo));
            
            $consecutiveFailedLoginAttemptsInLastHour = array();
            foreach($administratorLoginAttempts as $administratorLoginAttempt)
                if($administratorLoginAttempt->success)
                    $consecutiveFailedLoginAttemptsInLastHour = array();
                else
                    $consecutiveFailedLoginAttemptsInLastHour[] = $administratorLoginAttempt;
            
            return $consecutiveFailedLoginAttemptsInLastHour;
        }
        
        public static function create($email, $success){
            $administratorLoginAttempt = new AdministratorLoginAttempts;
            $administratorLoginAttempt->email = $email;
            $administratorLoginAttempt->created_on = HelperFunctions::getDate();
            $administratorLoginAttempt->success = $success;
            
            $administratorLoginAttempt->ip = HelperFunctions::getIP();
            if($administratorLoginAttempt->ip==false || $administratorLoginAttempt->ip=='')
                $administratorLoginAttempt->ip = '-';
            
            $administratorLoginAttempt->cookie = CookieHandler::get('main');
            if($administratorLoginAttempt->cookie==false || $administratorLoginAttempt->cookie=='')
                $administratorLoginAttempt->cookie = '-';
            
            $administratorLoginAttempt->session = Yii::app()->session->sessionID;
            if($administratorLoginAttempt->session==false || $administratorLoginAttempt->session=='')
                $administratorLoginAttempt->session = '-';
            
            $administratorLoginAttempt->validate();
            if($administratorLoginAttempt->save())
                return $administratorLoginAttempt;
            else{
                Errors::log('Error en Models/AdministratorLoginAttempts/create','Error creating administratorLoginAttempt',print_r($administratorLoginAttempt->getErrors(),true));
                return $administratorLoginAttempt;
            }
        }
}
?>