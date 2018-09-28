<?php

/**
 * This is the model class for table "project_files".
 *
 * The followings are the available columns in table 'sport_files':
 * @property integer $id
 * @property integer $project_id
 * @property integer $file_id
 * @property integer $position
 * @property date $updated_on
 * @property boolean $deleted
 */
 
class ProjectFiles extends CActiveRecord{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectFiles the static model class
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
		return 'project_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, file_id, position, updated_on, deleted', 'required'),
			array('project_id, file_id, position', 'numerical', 'integerOnly'=>true),
			array('updated_on', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('deleted', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, project_id, file_id, position, updated_on, deleted', 'safe', 'on'=>'search'),
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
			'project_id' => 'Project',
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
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('updated_on',$this->updated_on);
		$criteria->compare('deleted',$this->deleted,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getByProjectAndFileId($projectId, $fileId){
            $file = ProjectFiles::model()->find('project_id='.$projectId.' AND file_id='.$fileId);
            if(isset($file->id))
                return $file;
            else
                return false;
        }
        
        public static function getAllFromProject($projectId){
            return ProjectFiles::model()->findAll('project_id='.$projectId);
        }
        
        public static function updateProject($projectId, $files, $new){
            
            if(!$new)
                foreach($files as $file)
                    if($file['deleted']==1 && $file['id']!=0){
                        $existingProjectFil = self::getByProjectAndFileId($projectId, $file['id']);
                        if($existingProjectFil!=false){
                            $existingProjectFil->deleted = 1;
                            $existingProjectFil->position = 0;
                            $existingProjectFil->save();
                        }
                    }
            
            $position = 1;
            foreach($files as $file)
                if(isset($file['id']) && is_numeric($file['id']) && isset($file['name']) && isset($file['file_type_id']) && $file['deleted']==0){
                    $fileAux = Files::get($file['id']);
                    if(isset($fileAux->id)){
                        $fileAux->name = $file['name'];
                        if(FileTypes::validFileType($file['file_type_id']))
                            $fileAux->file_type_id = $file['file_type_id'];
                        $fileAux->updated_on = HelperFunctions::getDate();
                        $fileAux->save();
                        
                        $projectFilAux = ProjectFiles::getByProjectAndFileId($projectId, $file['id']);
                        if($projectFilAux===false)
                            $projectFilAux = new ProjectFiles;

                        $projectFilAux->project_id = $projectId;
                        $projectFilAux->file_id = $file['id'];
                        $projectFilAux->position = $position;
                        $projectFilAux->updated_on = HelperFunctions::getDate();
                        $projectFilAux->deleted = 0;
                        $projectFilAux->save();
                        $position++;
                    }
                }
        }
}
?>