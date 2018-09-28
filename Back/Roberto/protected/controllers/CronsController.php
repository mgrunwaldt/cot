<?php

class CronsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('execute'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\') && in_array(AdministratorRoles::$OWNER,Yii::app()->user->adminRoles)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	public function actionExecute()
	{
            try{
                $ip = HelperFunctions::getIP();
                if($ip=='192.111.139.94' || true){
                    $crons = Crons::getAll();

                    $date = HelperFunctions::getDate();
                    $dateArray = explode('-',$date);

                    $time = explode(' ',$dateArray[2]);
                    $time = $time[1];
                    $timeArray = explode(':',$time);

                    $hours = $timeArray[0];
                    $minutes = $timeArray[1];

                    $hourMinutes = $hours.':'.$minutes;
                    
                    foreach($crons as $cron){
                        
                        $secondsBetweenDates = abs(HelperFunctions::secondsBetweenDates($date, $cron->last_execution));
                        $minutesBetweenDates = $secondsBetweenDates/60;
                        $execute = false;
                        
                        //if date is not set
                        
                        if($cron->from=='0' && $cron->to=='0'){
                            //if its set to run in every ocassion, or minutes have passed
                            if($cron->every==0 || $minutesBetweenDates>$cron->every){
                                $execute = true;
                            }
                        }
                        //if date is set
                        else{
                            //if we are between ranges
                            if(strcmp($cron->from, $hourMinutes)<=0 && strcmp($cron->to, $hourMinutes)>0){
                                //if it was not executed in the last 12 hours
                                if($minutesBetweenDates>12*60){
                                    $execute = true;
                                }
                            }
                            //if we are outside ranges
                            else{
                                //but more than a day has passed
                                if($minutesBetweenDates>24*60){
                                    Alerts::log('Cron executed by daily timeout','Cron',$cron->name);
                                    $execute = true;
                                }
                            }
                        }
                        
                        if($execute){
                            call_user_func($cron->function,$cron->parameter);
                            $cron->executions++;
                            $cron->last_execution = $date;
                            $cron->save();
                        }
                    }
                }
                else{
                    Alerts::log('Crons/ActionExecute','From different','IP:'.$ip);
                    return false;
                }
            }
            catch (Exception $ex)
            {
                    Errors::log("Error en /CronsController/actionExecute",$ex->getMessage(),'');
                    Alerts::log("Error en /CronsController/actionExecute",$ex->getMessage(),'');
                    return false;
            }
        }
}
