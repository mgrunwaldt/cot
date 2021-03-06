<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;


/**
 * This is the model class for table "buses".
 *
 * @property int $id
 * @property int $number
 * @property string $plate
 * @property int $file_id
 * @property int $device_id
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class Buses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'plate', 'file_id', 'device_id', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['number', 'file_id', 'device_id', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['plate'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'plate' => 'Plate',
            'file_id' => 'File ID',
            'device_id' => 'Device ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }

    public static function getFromDevice($deviceId){
        $bus =  Buses::find()->where(['device_id' => $deviceId,'deleted' =>0])->one();
        if($bus == null){
            Errors::log("Get Bus From Device", "Device Id ".$deviceId);
            throw new NotFoundHttpException("No existe un dispositivo con este ID asociado a un omnibus");
        }
        return $bus;
    }
}
