<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $id
 * @property string $name
 * @property string $client
 * @property string $description
 * @property integer $category_id
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $active
 * @property boolean $deleted
 */
 
class Projects extends CActiveRecord{
    
        public $previewFile;
        public $projectFiles;
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Projects';
                case 'singular': return 'Project';
                case 'pluralCamelCase': return 'projects';
                case 'singularCamelCase': return 'project';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'projects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, client, description, preview_file_id, category_id, created_on, updated_on, active, deleted, ', 'required'),
                        array('category_id, ', 'numerical', 'integerOnly'=>true),
                        array('active, deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>256),
                        array('client', 'length', 'max'=>128),
                        array('id, name, client, description, preview_file_id, category_id, created_on, updated_on, active, deleted, ', 'safe', 'on'=>'search'),
                        
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id' => 'ID',
                        'name' => 'Name',
                        'client' => 'Client',
                        'description' => 'Description',
                        'preview_file_id' => 'PreviewFileId',
                        'category_id' => 'CategoryId',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'active' => 'Active',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'name': return 'Name';
                        case 'client': return 'Client';
                        case 'description': return 'Description';
                        case 'preview_file_id': return 'PreviewFileId';
                        case 'category_id': return 'CategoryId';
                        case 'created_on': return 'CreatedOn';
                        case 'updated_on': return 'UpdatedOn';
                        case 'active': return 'Active';
                        case 'deleted': return 'Deleted';
                        
                default: return '';
            }
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
                $criteria->compare('client',$this->client,true);
                $criteria->compare('description',$this->description,true);
                $criteria->compare('preview_file_id',$this->preview_file_id);
                $criteria->compare('category_id',$this->category_id);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('active',$this->active);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $project = self::model()->findByPk($id);
            if(isset($project->id))
                return $project;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name, $client, $description, $preview_file_id, $category_id, $active){
            $project = new Projects;
            $project->name = $name;
            $project->client = $client;
            $project->description = $description;
            $project->preview_file_id = $preview_file_id;
            $project->category_id = $category_id;
            $project->created_on = HelperFunctions::getDate();
            $project->updated_on = HelperFunctions::getDate();
            $project->active = $active;
            $project->deleted = 0;
            if($project->save())
                return $project;
            else{
                Errors::log('Error en Models/Projects/create','Error creating project',print_r($project->getErrors(),true));
                return $project;
            }
        }
            
        public function updateAttributes($name, $client, $description, $preview_file_id, $category_id, $active){
            $this->name = $name;
            $this->client = $client;
            $this->description = $description;
            $this->preview_file_id = $preview_file_id;
            $this->category_id = $category_id;
            $this->updated_on = HelperFunctions::getDate();
            $this->active = $active;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Projects/updateProject','Error updating project id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteProject(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Projects/deleteProject','Error deleting project id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
                
        public function loadProjectFiles(){
            $this->projectFiles = array();
            $projectFiles = ProjectFiles::model()->findAll('project_id=:projectId AND deleted=0 ORDER BY position ASC',array('projectId'=>$this->id));
            foreach($projectFiles as $projectFil){
                    $file = Files::get($projectFil->file_id);
                    if($file!==false)
                        $this->projectFiles[] = $file;
            }
        }
            
        
            public function getAllFromCategory($categoryId){
                return self::model()->findAll('category_id=:categoryId AND deleted=0',array('categoryId'=>$categoryId));
            }
                
            
        
    public function loadPreviewFile(){
            $this->previewFile = Files::get($this->preview_file_id);
        }
}
?>