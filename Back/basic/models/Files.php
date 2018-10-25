<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $ref
 * @property string $name
 * @property string $url
 * @property string $original_name
 * @property int $file_type_id
 * @property int $size
 * @property int $width
 * @property int $height
 * @property string $hash
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref', 'name', 'url', 'original_name', 'file_type_id', 'size', 'width', 'height', 'hash', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['file_type_id', 'size', 'width', 'height', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['ref'], 'string', 'max' => 16],
            [['name', 'original_name'], 'string', 'max' => 64],
            [['url', 'hash'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'Ref',
            'name' => 'Name',
            'url' => 'Url',
            'original_name' => 'Original Name',
            'file_type_id' => 'File Type ID',
            'size' => 'Size',
            'width' => 'Width',
            'height' => 'Height',
            'hash' => 'Hash',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }
}
