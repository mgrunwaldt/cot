<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bus_routes".
 *
 * @property int $id
 * @property int $bus_id
 * @property int $route_id
 * @property int $is_active
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class BusRoutes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bus_routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bus_id', 'route_id', 'is_active', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['bus_id', 'route_id', 'is_active', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bus_id' => 'Bus ID',
            'route_id' => 'Route ID',
            'is_active' => 'Is Active',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }

    public static function getFromBusId($busId){
        $busRoute = BusRoutes::find()->where(['bus_id' => $busId,'is_active' =>1])->one();
        if($busRoute == null){
            Errors::log("Get Bus Route From Bus", "Bus Id ".$busId);
            throw new NotFoundHttpException("Este omnibus no tiene ruta asociada");
        }
        return $busRoute;
    }
}
