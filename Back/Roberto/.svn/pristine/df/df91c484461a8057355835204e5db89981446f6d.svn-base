<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property integer $id
 * @property integer $ref
 * @property string $name
 * @property string $url
 * @property string $original_name
 * @property integer $file_type_id
 * @property integer $size
 * @property integer $width
 * @property integer $height
 * @property string $hash
 * @property date $created_on
 * @property date $updated_on
 * @property string $deleted
 */
class Files extends CActiveRecord
{
        public $file;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Files the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            return array(
                array('file', 'file', 'types'=>'jpg, gif, png, jpeg, zip, mpg, mpeg, mp4, mov, doc, xml, xls, ppt, pps, pdf, rar, docx, xlsx','on'=>'sportFiles', 'wrongType'=>'El tipo del archivo es incorrecto'),
		array('ref, name, original_name, file_type_id, url, size, width, height, hash, created_on, updated_on, deleted', 'safe'),
                array('ref, original_name, file_type_id, size, hash, created_on, updated_on, deleted', 'unsafe', 'on'=>'show'),
            );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ref' => 'Ref',
			'name' => 'Name',
			'url' => 'URL',
			'original_name' => 'Original Name',
			'file_type_id' => 'File Type',
			'size' => 'Size',
			'width' => 'Width',
			'height' => 'Height',
			'hash' => 'Hash',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
			'deleted' => 'Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ref',$this->ref,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('original_name',$this->original_name,true);
		$criteria->compare('file_type_id',$this->file_type_id);
		$criteria->compare('size',$this->size);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('updated_on',$this->updated_on);
		$criteria->compare('deleted',$this->deleted,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $file = Files::model()->findByPk($id);
            if(isset($file->id))
                return $file;
            else
                return false;
        }
        
        public static function getByHash($hash){
            $file = Files::model()->find('hash=:hash',array('hash'=>$hash));
            if(isset($file->id))
                return $file;
            else
                return false;
        }
        
        public static function getByURL($url){
            $file = Files::model()->find('url=:url',array('url'=>$url));
            if(isset($file->id))
                return $file;
            else
                return false;
        }
        
        public static function addYoutubeVideo($url, $ref){
            $file = new Files;
            
            $url = explode('v=',$url);
            $url = $url[count($url)-1];
            $url = explode('&',$url);
            $youtubeVideoId = $url[0];
            
            $existingFile = Files::getByURL($youtubeVideoId);
            if(isset($existingFile->id)){
                return $existingFile;
            }
            else{
                $youtubeDataURL = 'https://www.googleapis.com/youtube/v3/videos';
                $youtubeVideoData = json_decode(HelperFunctions::getRequest($youtubeDataURL, array('id'=>$youtubeVideoId,'key'=>Yii::app()->params['google']['key'],'part'=>'snippet')));
                
                if(isset($youtubeVideoData->items[0]->snippet->title)){
                    $file->name = substr($youtubeVideoData->items[0]->snippet->title,0,128);
                    $file->original_name = $file->name;
                    $file->url = $youtubeVideoId;
                    $file->file_type_id = FileTypes::$YOUTUBE_VIDEO;
                    $file->hash = '0';
                    $file->height = 0;
                    $file->width = 0;
                    $file->ref = $ref;
                    $file->size = 0;
                    $file->created_on = HelperFunctions::getDate();
                    $file->updated_on = $file->created_on;
                    if($file->save())
                        return $file;
                    else
                        return false;
                }
                else
                    return false;
            }
        }
        
        
        public static function reduceImage($fileId, $width, $height, $folder){
            $file = Files::get($fileId);
            
            if($file!=false){
                $finalWidth = 0;
                $finalHeight = 0;
                $nameArray = explode('.', $file->name); 
                $extension = $nameArray[1];
                $name = HelperFunctions::genRandomString(20).'.'.$extension;
                
                if($width=='auto' && $height=='auto'){
                    $finalWidth = $file->width;
                    $finalHeight = $file->height;
                }
                else if($width=='auto'){
                    $finalHeight = $height;
                    $finalWidth = $file->width * $finalHeight / $file->height;
                }
                else if($height=='auto'){
                    $finalWidth = $width;
                    $finalHeight = $file->height * $finalWidth / $file->width;
                }
                else{
                    $finalWidth = $width;
                    $finalHeight = $height;
                }
            
                $inputPath = Yii::app()->basePath.'/../public_html'.$file->url;
                $outputPath = Yii::app()->basePath.'/../public_html/images/'.$folder.'/'.$name;
                
                if(file_exists($inputPath)){
                    $imagickImage = new Imagick();
                    $imagickImage->readimage($inputPath);
                    $imagickImage->resizeimage($finalWidth, $finalHeight, imagick::FILTER_LANCZOS, 1);
                    $auxPath = Yii::app()->basePath.'/../public_html/images/tmp/'.HelperFunctions::genRandomString(20).'.png';
                    $imagickImage->writeimage($auxPath);
                    
                    $imageReducer = ImageReducers::getLeastUsed();
                    
                    $url = "https://api.tinypng.com/shrink";
                    $options = array(
                      "http" => array(
                        "method" => "POST",
                        "header" => array(
                          "Content-type: image/png",
                          "Authorization: Basic " . base64_encode("api:".$imageReducer->key)
                        ),
                        "content" => file_get_contents($auxPath)
                      ),
                      "ssl" => array(
                        //Uncomment below if you have trouble validating our SSL certificate.
                        //   Download cacert.pem from: http://curl.haxx.se/ca/cacert.pem
                        "cafile" => Yii::app()->basePath.'/cacert.cer',
                        "verify_peer" => true
                      )
                    );

                    $imageReducer->used();
                    $result = fopen($url, "r", false, stream_context_create($options));
                    
                    if ($result) {
                      foreach ($http_response_header as $header) {
                        if (substr($header, 0, 10) === "Location: ") {
                          file_put_contents($outputPath, fopen(substr($header, 10), "rb", false));
                          
                          $hash = md5_file($outputPath);
                          $file = Files::getByHash($hash);
                          if($file===false)
                            $file = Files::create($name, $name, '/images/'.$folder.'/'.$name, FileTypes::$IMAGE, $folder."File");
                          return $file;
                        }
                      }
                    } else {
                      return false;
                    }
                }
            }
            return false;
        }
        
        public static function create($name, $originalName, $url, $file_type_id, $ref){
            $file = new Files;
            $file->name = $name;
            $file->original_name = $originalName;
            $file->url = $url;
            $file->file_type_id = $file_type_id;
            $file->ref = $ref;
            
            $localPath = Yii::app()->basePath.'/../public_html'.$url;
            $file->hash = md5_file($localPath);
            $file->size = filesize($localPath);
            list($width, $height, $type, $attr) = getimagesize($localPath);
            $file->width = $width;
            $file->height = $height;
            
            $file->created_on = HelperFunctions::getDate();
            $file->updated_on = $file->created_on;
            
            if($file->save())
                return $file;
            else
                return $file;
        }
}