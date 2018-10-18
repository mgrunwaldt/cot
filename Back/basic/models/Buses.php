<?php

namespace app\models;

use Yii;

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
}
