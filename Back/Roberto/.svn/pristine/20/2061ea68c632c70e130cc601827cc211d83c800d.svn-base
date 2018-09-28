<?php

/**
 * This is the model class for table "administrator_files".
 *
 * The followings are the available columns in table 'sport_files':
 * @property integer $id
 * @property integer $administrator_id
 * @property integer $file_id
 * @property integer $position
 * @property date $updated_on
 * @property boolean $deleted
 */
 
class AdministratorFiles extends CActiveRecord{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdministratorFiles the static model class
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
		return 'administrator_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('administrator_id, file_id, position, updated_on, deleted', 'required'),
                        array('administrator_id, file_id, position, updated_on, deleted', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
			array('administrator_id, file_id, position', 'numerical', 'integerOnly'=>true),
			array('updated_on', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('deleted', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, administrator_id, file_id, position, updated_on, deleted', 'safe', 'on'=>'search'),
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
			'administrator_id' => 'Administrator',
			'file_id' => 'File',
			'position' => 'Position',
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
		$criteria->compare('administrator_id',$this->administrator_id);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('updated_on',$this->updated_on);
		$criteria->compare('deleted',$this->deleted,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getByAdministratorAndFileId($administratorId, $fileId){
            $file = AdministratorFiles::model()->find('administrator_id=:administratorId AND file_id=:fileId', array('administratorId'=>$administratorId,'fileId'=>$fileId));
            if(isset($file->id))
                return $file;
            else
                return false;
        }
        
        public static function getAllFromAdministrator($administratorId){
            return AdministratorFiles::model()->findAll('administrator_id=:administratorId',array('administratorId'=>$administratorId));
        }
        
        public static function updateAdministrator($administratorId, $files, $new){
            
            if(!$new){
                $existingAdministratorFiles = AdministratorFiles::getAllFromAdministrator($administratorId);
                foreach($existingAdministratorFiles as $existingAdministratorFile){
                    $deleted = true;
                    foreach($files as $file)
                        if($existingAdministratorFile->file_id==$file['id'])
                            $deleted = false;
                    
                    if($deleted){
                        $existingAdministratorFile->deleted = 1;
                        $existingAdministratorFile->position = 0;
                        $existingAdministratorFile->validate();
                        $existingAdministratorFile->save();
                    }
                }
            }
            
            $position = 1;
            foreach($files as $file){
                if(isset($file['id']) && is_numeric($file['id']) && isset($file['name']) && isset($file['file_type_id'])){
                    $fileAux = Files::get($file['id']);
                    if(isset($fileAux->id)){
                        $fileAux->name = $file['name'];
                        if(FileTypes::validFileType($file['file_type_id']))
                            $fileAux->file_type_id = $file['file_type_id'];
                        $fileAux->updated_on = HelperFunctions::getDate();
                        $fileAux->validate();
                        $fileAux->save();
                        
                        $administratorFileAux = AdministratorFiles::getByAdministratorAndFileId($administratorId, $file['id']);
                        if($administratorFileAux===false)
                            $administratorFileAux = new AdministratorFiles;

                        $administratorFileAux->administrator_id = $administratorId;
                        $administratorFileAux->file_id = $file['id'];
                        $administratorFileAux->position = $position;
                        $administratorFileAux->updated_on = HelperFunctions::getDate();
                        $administratorFileAux->deleted = 0;
                        $administratorFileAux->validate();
                        $administratorFileAux->save();
                        $position++;
                    }
                }
            }
        }
}
?>