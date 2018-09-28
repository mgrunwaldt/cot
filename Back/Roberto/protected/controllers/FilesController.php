<?php

class FilesController extends Controller
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('getFiles','getFileManagerHTML','addURLFile','viewUploadFile','uploadFile'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        
	public function actionGetFiles(){
            $response = array();
            try{
                $files = array();
                if(isset($_POST['files']) && is_array($_POST['files'])){
                    foreach($_POST['files'] as $fileId){
                        if(is_numeric($fileId) && $fileId>0){
                            $auxFile = Files::get($fileId);
                            $files[] = HelperFunctions::modelToArray($auxFile);
                        }
                    }
                }
                $response['status'] = 'ok';
                $response['files'] = $files;
                echo json_encode($response);
            }
            catch(Exception $ex)
            {
                Errors::log("Error en FilesController/actionGetFiles",$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
	public function actionGetFileManagerHTML()
	{
            $response = array();
            try{
                if(isset($_POST['instanceId'])){
                    $instanceId = $_POST['instanceId'];
                    $response['html'] = $this->renderPartial('manager',array('instanceId'=>$instanceId),true);
                    $response['status'] = 'ok';
                }
                else{
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
                echo json_encode($response);
            }
            catch(Exception $ex)
            {
                Errors::log("Error en FilesController/actionGetFileManagerHTML",$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
	}
        
	public function actionViewUploadFile($ref=null, $status=null, $instanceId=null, $file=null, $error=null)
	{
            try{
                if($file==null)
                    $file = new Files;
                
                if($error==null)
                    $error = '';
                
                if($status==null)
                    $status = '';
                
                if(isset($_GET['ref']) && isset($_GET['instanceId'])){
                    $ref = $_GET['ref'];
                    $instanceId = $_GET['instanceId'];
                }
                
                if($ref!=null && $instanceId!=null){
                    $file->ref = $ref;
                    $this->renderPartial('uploadFile', array('status'=>$status,'file'=>$file,'instanceId'=>$instanceId,'error'=>$error));            
                }
                else{
                    $invalidRequest = HelperFunctions::purify(print_r($_GET, true));
                    Errors::log("Error en FilesController/actionViewUploadFile",'Invalid Variable',$invalidRequest);
                    echo('Error');
                }
            }
            catch(Exception $ex)
            {
                    Errors::log("Error en FilesController/actionViewUploadFile",$ex->getMessage(),'');
                    echo('Error');
            }
	}
            
        
        /**
	 * Upload File
	 */
	public function actionUploadFile()
	{
           // try{
                $ref = null;
                $instanceId = null;
                $model = new Files;
                $status = '';
                
                if(isset($_FILES['Files']) && isset($_POST['ref']) && isset($_POST['instanceId']) && isset($_POST['originalName'])){
                    $instanceId = $_POST['instanceId'];
                    $ref = $_POST['ref'];
                    $model->attributes=$_FILES['Files'];
                    $model->file=CUploadedFile::getInstance($model,'file');
                    
                    switch($ref){
                        case 'sportImage':
                                $model->setScenario('sportImage');
                        break;
                    }
                    
                    $model->validate();
                    if(!$model->hasErrors('file')){
                        $random = HelperFunctions::genRandomString(20);
                        $extension = $model->file->getExtensionName();
                        $name = $random.'.'.$extension;
                        $localPath = Yii::app()->basePath.'/../public_html/files/tmp/'.$name;
                        if($ref=="benefitPublicationFile"){
                            $localPath = Yii::app()->basePath.'/../public_html/files/benefitPublications/'.$name;
                        }
                        else if($ref=="deviceFile"){
                            $localPath = Yii::app()->basePath.'/files/samsungDeviceFiles/'.$name;
                        }
                        
                        $model->file->saveAs($localPath);
                        $hash = md5_file($localPath);
                        
                        $existingFile = Files::getByHash($hash);
                        if($existingFile===false){
                            if(Yii::app()->params['useAmazonS3']){
                                if(AmazonHandler::saveFile($localPath, 'tmp/'.$name, true)){
                                    unlink($localPath);
                                    $model->url = Yii::app()->params['amazon']['bucketDir'].'tmp/'.$name;
                                }
                                else{
                                    $status = 'error';
                                    $error = 'Amazon Error';
                                    $model = new Files;
                                }
                            }
                            else{
                                $model->url = '/files/tmp/'.$name;
                                if($ref=="benefitPublicationFile"){
                                    $model->url = '/files/benefitPublications/'.$name;
                                }
                                else if($ref=="deviceFile"){
                                    $model->url = '/files/samsungDeviceFiles/'.$name;
                                }
                            }
                            
                            $model->ref = $ref;
                            $model->name = $name;
                            $originalName = explode('\\', $_POST['originalName']);
                            $originalName = $originalName[count($originalName)-1];
                            $model->original_name = $originalName;
                            $model->file_type_id = FileTypes::getTypeFromExtension($extension);
                            $model->size = filesize($localPath);

                            if($model->file_type_id==FileTypes::$IMAGE){
                                list($width, $height, $type, $attr) = getimagesize($localPath);
                                $model->width = $width;
                                $model->height = $height;
                            }
                            else{
                                $model->width = 0;
                                $model->height = 0;
                            }

                            $model->hash = $hash;
                            $model->created_on = HelperFunctions::getDate();
                            $model->updated_on = $model->created_on;

                            if($model->save()){
                                $status = 'ok';
                                $error = '';
                            }
                            else{
                                $status = 'error';
                                $error = print_r($model, true);
                                $model = new Files;
                            }
                        }
                        else{
                            $status = 'ok';
                            $error = '';
                            $model = $existingFile;
                        }
                    }
                    else{
                        $status = 'error';
                        $error = $model->getError('file');
                        $model = new Files;
                    }
                }
                else{
                    $status = 'error';
                    $error = 'Invalid Data';
                    $model = new Files;
                }
                $this->actionViewUploadFile($ref, $status, $instanceId, $model, $error);
            /*}
            catch(Exception $ex)
            {
                $status = 'error';
                $error = $ex->getMessage();
            }*/
	}
        
        /**
	 * Upload File
	 */
	public function actionAddURLFile()
	{
            try{
                $response = array();
                if(isset($_POST['fileURL']) && isset($_POST['fileType']) && is_numeric($_POST['fileType']) && isset($_POST['ref'])){
                    $file = false;
                    switch($_POST['fileType']){
                        case FileTypes::$YOUTUBE_VIDEO:
                            $file = Files::addYoutubeVideo($_POST['fileURL'], $_POST['ref']);
                        break;
                    }
                    if($file!==false){
                        $response['status'] = 'ok';
                        $response['file'] = HelperFunctions::modelToArray($file);
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'invalidFiletype';
                        $response['errorMessage'] = 'invalidFiletype';
                    }
                }
                else{
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
                echo json_encode($response);
            }
            catch(Exception $ex)
            {
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                Errors::log("Error en FilesController/addURLFile",$ex->getMessage(),'');
                echo json_encode($response);
            }
	}
        
}
