<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administrators".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property int $administrator_role_id
 * @property int $administrator_file_id
 * @property int $active
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class Administrators extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administrators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name', 'last_name', 'phone', 'administrator_role_id', 'administrator_file_id', 'created_on', 'updated_on'], 'required'],
            [['administrator_role_id', 'administrator_file_id', 'active', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['email'], 'string', 'max' => 64],
            [['password', 'name', 'last_name'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'administrator_role_id' => 'Administrator Role ID',
            'administrator_file_id' => 'Administrator File ID',
            'active' => 'Active',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }
}
