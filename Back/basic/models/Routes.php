<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;




/**
 * This is the model class for table "routes".
 *
 * @property int $id
 * @property string $name
 * @property int $number
 * @property int $stop_radius
 * @property int $total_stops
 * @property string $created_on
 * @property string $updated_on
 * @property int $deleted
 */

class Routes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'number', 'stop_radius', 'total_stops', 'created_on', 'updated_on', 'deleted'], 'required'],
            [['number', 'stop_radius', 'total_stops', 'deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    public function actionImport()
    {
        $model = new Routes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function loadFromUpload($xmlArray){
        $this->number =  $xmlArray["RouteNo"];
        $this->name = $xmlArray["RouteName"];
        $this->stop_radius = $xmlArray["BusStopArea"];
        $this->total_stops = 0;
        $this->createForDB();
        $totalStops = 0;
        $stops = $xmlArray["StopData"];
        foreach ($stops as $stop){
            $totalStops++;
            $stopModel = new Stops();
            $stopModel->loadFromUpload($stop);
            $stopModel->createForDB();

            $routeStop = new RouteStops();
            $routeStop->route_id = $this->id;
            $routeStop ->stop_id = $stopModel->id;
            $routeStop->stop_number = $stop["No"];
            $routeStop->createForDB();


          //  $this->stop_number  = $stop["No"];


        }
        $this->total_stops = $totalStops;
        $this->updateForDb();

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'number' => 'Number',
            'stop_radius' => 'Stop Radius',
            'total_stops' => 'Total Stops',
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

    public static function getFromId($id){
        $route = Routes::findOne(['id' => $id]);
        if($route == null){
            Errors::log("Get Route From Id", "Route Id ".$id);
            throw new NotFoundHttpException("La ruta asociada a este bus es incorrecta");
        }
        return $route;
    }
}
