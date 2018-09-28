<?php

/**
 * This is the model class for table "sessions".
 *
 * The followings are the available columns in table 'sessions':
 * @property integer $id
 * @property string $session
 * @property string $cookie
 * @property string $ip
 * @property string $browser
 * @property string $referrer
 * @property date $date
 */
class Sessions extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Sessions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sessions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, cookie, ip, browser, referrer, created_on', 'required'),
            //array('code, cookie, ip, browser, referrer, created_on', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
            array('created_on', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('code, cookie', 'length', 'max' => 32),
            array('ip', 'length', 'max' => 16),
            array('browser', 'length', 'max' => 128),
            array('referrer', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, cookie, ip, browser, referrer, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'cookie' => 'Cookie',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'referrer' => 'Referrer',
            'created_on' => 'Created on',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('cookie', $this->cookie, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('browser', $this->browser, true);
        $criteria->compare('referrer', $this->referrer, true);
        $criteria->compare('created_on', $this->created_on);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public static function create() {
        $session = new Sessions;
        $session->code = Yii::app()->session->sessionID;
        $session->cookie = CookieHandler::get('main');
        $session->ip = HelperFunctions::getIP();
        if(!HelperFunctions::isBot($session->ip)){
            $session->browser = HelperFunctions::getBrowser();
            $session->referrer = substr(HelperFunctions::getReferrer(), 0, 256);
            $session->created_on = HelperFunctions::getDate();
            if ($session->ip != '192.252.218.60'){
                $session->validate();
                if ($session->save()) {
                    Yii::app()->session['set'] = true;
                    return true;
                } else
                    Errors::log('Error in Models/Sessions/Create', 'Error saving Session', 'Errors:' . print_r($session->getErrors(), true));
            }
        }
    }

    public static function getAll() {
        return self::model()->findAll('id>0');
    }

}