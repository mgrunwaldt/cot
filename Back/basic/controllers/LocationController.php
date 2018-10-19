<?php

namespace app\controllers;

use app\models\Buses;
use app\models\BusRoutes;
use app\models\Routes;
use app\models\RouteStops;
use app\models\Stops;
use app\helpers\HelperFunctions;
use Codeception\Lib\Generator\Helper;
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
                $bus =  Buses::getFromDevice($deviceId);
                $busRoute = BusRoutes::getFromBusId($bus->id);
                $route = Routes::getFromId($busRoute->route_id);
                $routeStops = RouteStops::findAll(['route_id' => $route->id]);
                if(count($routeStops) != 0){
                    $minDistance = 100000000000000;
                    $minDistanceStop = null;
                    $minDistanceRouteStop = null;
                    foreach ($routeStops as $routeStop){
                        $stop = Stops::getFromId($routeStop->stop_id);
                        $distance = HelperFunctions::distanceBetweenPoints($lat,$long,$stop->latitude,$stop->longitude);
                        if($distance < $minDistance){
                            $minDistance = $distance;
                            $minDistanceStop = $stop;
                            $minDistanceRouteStop = $routeStop;
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
                throw new \InvalidArgumentException("Debes enviar latitud longitud ultima distancia y device");
            }
        }
        catch (\Exception $ex){
            //ERRORS LOG
            throw new ServerErrorHttpException("Ocurrió un error inesperado, mensaje - ".$ex->getMessage());
        }
        return json_encode($response);
    }



}
