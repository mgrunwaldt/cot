<?php

/**
 * This is the model class for table "crons".
 *
 * The followings are the available columns in table 'crons':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $function
 * @property string $parameter
 * @property string $from
 * @property string $to
 * @property integer $every
 * @property integer $just_once
 * @property integer $executions
 * @property date $last_execution
 * @property date $active
 */
class Crons extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Crons the static model class
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
		return 'crons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, function, from, to, every, executions, last_execution, active', 'required'),
			array('every, executions, just_once', 'numerical', 'integerOnly'=>true),
			array('last_execution', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('name, from, to', 'length', 'max'=>32),
			array('function', 'length', 'max'=>64),
			array('description', 'length', 'max'=>256),
			array('parameter', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, function, from, to, every, executions, last_execution', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'description' => 'Description',
			'function' => 'Function (ex: Orders::checkExpirationDates)',
			'parameter' => 'Parameter (ex: hello world)',
			'from' => 'From (ex: 16:30, 0 for always)',
			'to' => 'To (ex: 16:35, 0 for always)',
			'every' => 'Every (ex: 10 every ten minutes, 0 for always)',
			'just_once' => 'Execute Only One Time',
			'executions' => 'Executions',
			'last_execution' => 'Last Execution',
			'active' => 'Active',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('function',$this->function,true);
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('from',$this->from);
		$criteria->compare('to',$this->to);
		$criteria->compare('every',$this->every);
		$criteria->compare('just_once',$this->just_once);
		$criteria->compare('executions',$this->executions);
		$criteria->compare('last_execution',$this->last_execution);
		$criteria->compare('active',$this->last_execution);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getAll(){
            return Crons::model()->findAll('active=1 AND (just_once=0 OR (just_once=1 AND executions=0))');
        }
        
        /*public static function check(){
            Logs::log('Cron working '.HelperFunctions::getDate());
        }*/
}