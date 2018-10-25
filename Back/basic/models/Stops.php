<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;


/**
 * This is the model class for table "stops".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $latitude
 * @property string $longitude
 * @property int $stop_type
 * @property string $arriving_text
 * @property string $arrived_text
 * @property string $leaving_text
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */
class Stops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'latitude', 'longitude', 'stop_type', 'arriving_text', 'arrived_text', 'leaving_text', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['stop_type', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'short_name'], 'string', 'max' => 256],
            [['arriving_text', 'arrived_text', 'leaving_text'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'stop_type' => 'Stop Type',
            'arriving_text' => 'Arriving Text',
            'arrived_text' => 'Arrived Text',
            'leaving_text' => 'Leaving Text',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'deleted' => 'Deleted',
        ];
    }

    public function loadFromUpload($stop){
        $this->name =  $stop["Name"];
        $this->short_name  = $stop["ShortName"];
        $this->latitude  = $stop["Lat"];
        $this->longitude  = $stop["Lon"];
        $this->stop_type  = $stop["StopType"];

        $this->arriving_text = "Estamos llegando a: ".$this->short_name;
        $this->arrived_text = "Llegamos a: ".$this->short_name;
        $this->leaving_text = "Salimos de : ".$this->short_name;

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
    public static function getFromId($id){
        $stop = Stops::findOne(['id'=>$id]);
        if($stop == null){
            Errors::log("Get Stop From Id", "Stop Id ".$id
            );
            throw new NotFoundHttpException("No existe parada con este id");
        }
        return $stop;
    }
}
