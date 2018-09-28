<?php
class AmazonHandler
{
	public static function fileExists($name)
	{
                error_reporting(0);
                Yii::import('application.extensions.*');
		include_once Yii::app()->params['amazon']['sdkdir'];
		$s3 = new AmazonS3(array('key'=>Yii::app()->params['amazon']['key'],'secret'=>Yii::app()->params['amazon']['secret']));
                $s3->disable_ssl_verification();
		$bucket = Yii::app()->params['amazon']['bucket'];
		
		return $s3->if_object_exists($bucket, $name);
	}
        
	public static function saveFile($path, $name, $public)
	{
                error_reporting(0);
                Yii::import('application.extensions.*');
		include_once Yii::app()->params['amazon']['sdkdir'];
                
		$s3 = new AmazonS3(array('key'=>Yii::app()->params['amazon']['key'],'secret'=>Yii::app()->params['amazon']['secret']));
                $s3->disable_ssl_verification();
		$bucket = Yii::app()->params['amazon']['bucket'];
		
                $extension = explode('.',$name);
                $extension = $extension[1];
                switch($extension){
                    case 'jpg':
                        $type = 'image/jpg';
                        break;
                    case 'jpeg':
                        $type = 'image/jpeg';
                        break;
                    case 'bmp':
                        $type = 'image/bmp';
                        break;
                    case 'gif':
                        $type = 'image/gif';
                        break;
                    case 'png':
                        $type = 'image/png';
                        break;
                    case 'sql':
                        $type = 'text/sql';
                        break;
                }
                
                $permission = AmazonS3::ACL_PRIVATE;
                if($public==1)
                   $permission = AmazonS3::ACL_PUBLIC;
                
		$response = $s3->create_object($bucket, $name, array(
			'fileUpload' => $path,
			'acl' => $permission,
			'contentType' => $type,
		));
                
		if($response->isOk())
                    return true;
                else
                    return false;
	}
        
        public static function deleteFile($name)
	{
            //error_reporting(0);
                Yii::import('application.extensions.*');
		include Yii::app()->params['amazon']['sdkdir'];
		$s3 = new AmazonS3(array('key'=>Yii::app()->params['amazon']['key'],'secret'=>Yii::app()->params['amazon']['secret']));
                //$s3->disable_ssl_verification();
		$bucket = Yii::app()->params['amazon']['bucket'];
		
		$response = $s3->delete_object($bucket, $name);
                
		
		if($response->isOk())
			return true;
                else
                    return false;
	}
}

?>
