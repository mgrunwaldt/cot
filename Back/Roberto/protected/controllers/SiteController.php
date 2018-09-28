<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
        
		try{
                    $highlights = Highlights::getAll($this->isMobile);
                    foreach($highlights as $highlight)
                        $highlight->loadHighlightFile();
                    
                    $projects = Projects::getAll();
                    foreach($projects as $project)
                        $project->loadPreviewFile();
                    
                    $categories = Categories::getAll();
                    
                    if($this->isMobile){
                        $this->layout = 'mainMobile';
                        $this->render('indexMobile',array('highlights'=>$highlights, 'projects'=>$projects, 'categories'=>$categories));
                    }else{
                        $this->render('index',array('highlights'=>$highlights, 'projects'=>$projects, 'categories'=>$categories));
                    }
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionIndex",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
        /*
	public function actionTest(){
        
		try{
			$this->renderPartial('test',array());
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionIndex",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
*/
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
            //$this->renderPartial('error', $error);
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->renderPartial('error', $error);
	    }
	}
	

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		try
		{
                    $redirectTo = '/';
                    if(isset(Yii::app()->session['session_admin_id']))
                        $redirectTo = '/Administrators/viewLogin';
                    else if(isset(Yii::app()->session['session_client_user_id']))
                        $redirectTo = '/ClientUsers/viewLogin';

                    //session_start();
                    session_destroy();
                    Yii::app()->user->logout();
                    $this->redirect($redirectTo);
                
		}
		catch (Exception $ex)
		{
			Errors::log("Error en UsersController/actionLogout",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
	}
        
        public function actionViewLocation(){
            try{
                if($this->isMobile)
                    $this->layout = 'mobile';
                $this->render('location');
            } catch (Exception $ex) {
                Errors::log("Error en SiteController/actionViewLocation", $ex->getMessage(), '');
                $this->redirect('/Site/userError');
            }
        }
        
        public function actionViewSpirit(){
            try{
                
                if($this->isMobile)
                    $this->layout = 'mobile';
                $this->render('spirit');
            } catch (Exception $ex) {
                Errors::log("Error en SiteController/actionViewSpirit", $ex->getMessage(), '');
                $this->redirect('/Site/userError');
            }
        }
        
        public function actionViewServices(){
            try{
            
                if($this->isMobile)
                    $this->layout = 'mobile';
                $this->render('services');
            } catch (Exception $ex) {
                Errors::log("Error en SiteController/actionViewServices", $ex->getMessage(), '');
                $this->redirect('/Site/userError');
            }
        }
        
        public function actionViewInvestment(){
            try{
                $ranches = Ranches::getAll();
            
                if($this->isMobile)
                    $this->layout = 'mobile';
                $this->render('investments', array('ranches'=>$ranches));
            } catch (Exception $ex) {
                Errors::log("Error en SiteController/actionViewInvestments", $ex->getMessage(), '');
                $this->redirect('/Site/userError');
            }
        }
    
    
    //public function actionAux2(){
        //Administrators::create("chino@roberto.uy", "Santiago", "Tarallo", 123, 1, 1, "chinoMoon");
        //Administrators::create("nacho@roberto.uy", "Ignacio", "Iccardi", 123, 1, 1, "nachoMoon");
    //}
}
?>