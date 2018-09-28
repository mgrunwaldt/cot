<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property integer $id
 * @property integer $administrator_id
 * @property integer $user_id
 * @property integer $provider_id
 * @property string $text
 * @property string $ip
 * @property string $browser
 * @property string $date
 */
class Logs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('administrator_id, user_id, provider_id', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>512),
			array('ip', 'length', 'max'=>32),
			array('browser', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, administrator_id, user_id, provider_id, text, ip, browser, date', 'safe', 'on'=>'search'),
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
			'administrator_id' => 'Administrator',
			'user_id' => 'User',
			'provider_id' => 'Provider',
			'text' => 'Text',
			'ip' => 'Ip',
			'browser' => 'Browser',
			'date' => 'Date',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('administrator_id',$this->administrator_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('browser',$this->browser,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function log($text){
            $log = new Logs;
            $log->administrator_id = 0;
            $log->user_id = 0;
            $log->provider_id = 0;
            $log->ip = HelperFunctions::getIP();
            $log->browser = HelperFunctions::getBrowser();
            $log->date = HelperFunctions::getDate();
            $log->text = $text;
            
            if(isset(Yii::app()->session['session_admin_id']))
                $log->administrator_id = Yii::app()->session['session_admin_id'];
            if(isset(Yii::app()->session['session_user_id']))
                $log->user_id = Yii::app()->session['session_user_id'];
            if(isset(Yii::app()->session['session_provider_id']))
                $log->provider_id = Yii::app()->session['session_provider_id'];
            
            $log->validate();
            if(!$log->save()){
                print_r($log->getErrors());
                $error="";
                foreach($log->getErrors() as $err)
                    $error.=$err[0];
                Errors::log($error,'','');
            }
            
        }
}