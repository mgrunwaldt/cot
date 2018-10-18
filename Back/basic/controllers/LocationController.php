<?php

namespace app\controllers;

use app\models\Buses;
use app\models\BusRoutes;
use app\models\Routes;
use app\models\RouteStops;
use app\models\Stops;
use http\Exception\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;


class LocationController extends \yii\web\Controller
{
    private static $INSIDE_RADIOUS = 50;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionUpdateBus(){
       // Yii::$app->request->post() ;
        $response = array();
        try{
            if(isset($_GET['latitude'])&&isset($_GET['longitude'])&&isset($_GET['deviceId'])&&isset($_GET['previousDistance'])){
                $lat = $_GET['latitude'];
                $long = $_GET['longitude'];
                $deviceId = $_GET['deviceId'];
                $previousDistance = $_GET['previousDistance'];
                $bus =  Buses::find()->where(['device_id' => $deviceId,'deleted' =>0])->one();
                if(isset($bus->id)){
                    $busRoute = BusRoutes::find()->where(['bus_id' => $bus->id,'is_active' =>1])->one();
                    if(isset($busRoute->id)){
                        $route = Routes::findOne(['id' => $busRoute->route_id]);
                        if(isset($route->id)){
                            $routeStops = RouteStops::findAll(['route_id' => $route->id]);
                            if(count($routeStops) != 0){
                                $minDistance = 100000000000000;
                                $minDistanceStop = null;
                                $minDistanceRouteStop = null;
                                foreach ($routeStops as $routeStop){
                                    $stop = Stops::findOne(['id'=>$routeStop->stop_id]);
                                    if($stop != null){
                                        $distance = LocationController::vincentyGreatCircleDistance($lat,$long,$stop->latitude,$stop->longitude);
                                        if($distance < $minDistance){
                                            $minDistance = $distance;
                                            $minDistanceStop = $stop;
                                            $minDistanceRouteStop = $routeStop;

                                        }
                                    }
                                    else{
                                        //ERRORS LOG
                                        throw new NotFoundHttpException("Hay una parada incorrecta");
                                    }
                                }
                                if($minDistance < LocationController::$INSIDE_RADIOUS){
                                    if($minDistanceRouteStop->stop_number == $route->total_stops){
                                        $response["data"]["showAnimation"] = 5;
                                    }
                                    else $response["data"]["showAnimation"] = 2;
                                    $response["data"]["previousDistance"] = $minDistance;
                                }
                                else if($minDistance < $route->stop_radius){
                                    if($previousDistance == 0 || $minDistance < $previousDistance){
                                        if($minDistanceRouteStop->stop_number == $route->total_stops){
                                            $response["data"]["showAnimation"] = 4;
                                        }
                                        else $response["data"]["showAnimation"] = 1;
                                    }

                                    else {
                                        $response["data"]["showAnimation"] = 3;
                                    }
                                    $response["data"]["previousDistance"] = $minDistance;
                                }
                                else{
                                    $response["data"]["showAnimation"] = 0;
                                    $response["data"]["previousDistance"] = 0;
                                }
                                $response["data"]["stopName"] = $minDistanceStop->short_name;
                                //falta siguiente y anterior


                            }
                            else{
                                //ERRORS LOG
                                throw new NotFoundHttpException("Esta ruta no tiene paradas");
                            }
                        }
                        else{
                            //ERRORS LOG
                            throw new NotFoundHttpException("La ruta asociada a este bus es incorrecta");
                        }
                    }
                    else{
                        //ERRORS LOG
                        throw new NotFoundHttpException("Este omnibus no tiene ruta asociada");
                    }
                }
                else{
                    //ERRORS LOG
                    throw new NotFoundHttpException("No existe un dispositivo con este ID asociado a un omnibus");
                }
            }
            else{
                //ERRORS LOG
                throw new \InvalidArgumentException("Debes enviar latitud longitud ultima distancia y device");
            }
        }
        catch (\Exception $ex){
            //ERRORS LOG
            throw new ServerErrorHttpException("Ocurrió un error inesperado, mensaje - ".$ex->getMessage());
        }
        return json_encode($response);
    }

    private static function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

}
