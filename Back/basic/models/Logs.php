<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property int $administrator_id
 * @property int $user_id
 * @property int $provider_id
 * @property string $text
 * @property string $ip
 * @property string $browser
 * @property string $date
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['administrator_id', 'user_id', 'provider_id', 'text', 'ip', 'browser', 'date'], 'required'],
            [['administrator_id', 'user_id', 'provider_id'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 512],
            [['ip'], 'string', 'max' => 32],
            [['browser'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'administrator_id' => 'Administrator ID',
            'user_id' => 'User ID',
            'provider_id' => 'Provider ID',
            'text' => 'Text',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'date' => 'Date',
        ];
    }
}
