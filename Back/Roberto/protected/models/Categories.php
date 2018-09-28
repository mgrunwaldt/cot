<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property integer $id
 * @property string $name
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $active
 * @property boolean $deleted
 */
 
class Categories extends CActiveRecord{
    
        public $iconFile;
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Categories';
                case 'singular': return 'Category';
                case 'pluralCamelCase': return 'categories';
                case 'singularCamelCase': return 'category';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, position, icon_file_id, created_on, updated_on, active, deleted, ', 'required'),
                        array('active, deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>256),
                        array('id, name, position, icon_file_id, created_on, updated_on, active, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'position' => 'Position',
                        'icon_file_id' => 'IconFileId',
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
                        case 'position': return 'Position';
                        case 'icon_file_id': return 'IconFileId';
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
                $criteria->compare('position',$this->position);
                $criteria->compare('icon_file_id',$this->icon_file_id);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('active',$this->active);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $category = self::model()->findByPk($id);
            if(isset($category->id))
                return $category;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0 ORDER BY position ASC');
        }
        
        public static function create($name, $icon_file_id, $active){
            $category = new Categories;
            $category->name = $name;
            $category->position = 0;
            $category->icon_file_id = $icon_file_id;
            $category->created_on = HelperFunctions::getDate();
            $category->updated_on = HelperFunctions::getDate();
            $category->active = $active;
            $category->deleted = 0;
            if($category->save())
                return $category;
            else{
                Errors::log('Error en Models/Categories/create','Error creating category',print_r($category->getErrors(),true));
                return $category;
            }
        }
            
        public function updateAttributes($name, $icon_file_id, $active){
            $this->name = $name;
            $this->icon_file_id = $icon_file_id;
            $this->updated_on = HelperFunctions::getDate();
            $this->active = $active;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Categories/updateCategory','Error updating category id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public static function savePositions($categoryIds){
            $counter = 0;
            foreach($categoryIds as $categoryId){
                $category = self::get($categoryId);
                if($category!=false){
                    $category->position = $counter;
                    $category->save();
                    $counter++;
                }
            }
        }
        
        
            
        public function deleteCategory(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            $this->position = 0;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Categories/deleteCategory','Error deleting category id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
    public function loadIconFile(){
            $this->iconFile = Files::get($this->icon_file_id);
        }
        
}
?>