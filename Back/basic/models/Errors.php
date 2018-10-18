<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "errors".
 *
 * @property int $id
 * @property int $administrator_id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $aux
 * @property string $ip
 * @property string $browser
 * @property string $date
 */
class Errors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'errors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['administrator_id', 'user_id', 'title', 'message', 'aux', 'ip', 'browser', 'date'], 'required'],
            [['administrator_id', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'browser'], 'string', 'max' => 64],
            [['message', 'aux'], 'string', 'max' => 1024],
            [['ip'], 'string', 'max' => 32],
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
            'title' => 'Title',
            'message' => 'Message',
            'aux' => 'Aux',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'date' => 'Date',
        ];
    }
}
