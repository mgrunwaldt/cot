<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "route_stops".
 *
 * @property int $id
 * @property int $route_id
 * @property int $stop_id
 * @property int $stop_number
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class RouteStops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route_stops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_id', 'stop_id', 'stop_number', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['route_id', 'stop_id', 'stop_number', 'deleted'], 'integer'],
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
            'route_id' => 'Route ID',
            'stop_id' => 'Stop ID',
            'stop_number' => 'Stop Number',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }

    public function createForDB(){
        $this->deleted = 0;
        $this->created_on = date("Y-m-d H:i:s");
        $this->updated_on = date("Y-m-d H:i:s");
        if($this->save())
            echo("OK");
        else print_r($this->getErrors());
    }

    public function updateForDb(){
        $this->updated_on = date("Y-m-d H:i:s");
        if($this->save())
            echo("OK");
        else print_r($this->getErrors());
    }

    public static function getFromRouteAndNumber($routeId,$stopNumber){
        $stop = RouteStops::find()->where(['route_id' => $routeId,'deleted' =>0, 'stop_number' => $stopNumber])->one();
        if($stop == null){
            Errors::log("Get RouteStop from Route and Number", "Route Id ".$routeId." - stopNumber ".$stopNumber);
            throw new NotFoundHttpException("No hay una parada para esta ruta y numero de parada");
        }
        return $stop;
    }
}
