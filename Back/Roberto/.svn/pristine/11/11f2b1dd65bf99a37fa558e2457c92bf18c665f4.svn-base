<?php

/**
 * This is the model class for table "highlights".
 *
 * The followings are the available columns in table 'highlights':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $font_size
 * @property string $letter_spacing
 * @property string $link
 * @property boolean $mobile
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class Highlights extends CActiveRecord{
    
        public $highlightFile;
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Highlights';
                case 'singular': return 'Highlight';
                case 'pluralCamelCase': return 'highlights';
                case 'singularCamelCase': return 'highlight';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Highlights the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'highlights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, highlight_file_id, title, font_size, letter_spacing, link, mobile, created_on, updated_on, deleted, ', 'required'),
                        array('mobile, deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>255),
                        array('title', 'length', 'max'=>256),
                        array('font_size', 'length', 'max'=>8),
                        array('letter_spacing', 'length', 'max'=>8),
                        array('link', 'length', 'max'=>255),
                        array('id, name, highlight_file_id, title, font_size, letter_spacing, link, mobile, created_on, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'highlight_file_id' => 'HighlightFileId',
                        'title' => 'Title',
                        'font_size' => 'FontSize',
                        'letter_spacing' => 'LetterSpacing',
                        'link' => 'Link',
                        'mobile' => 'Mobile',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'name': return 'Name';
                        case 'highlight_file_id': return 'HighlightFileId';
                        case 'title': return 'Title';
                        case 'font_size': return 'FontSize';
                        case 'letter_spacing': return 'LetterSpacing';
                        case 'link': return 'Link';
                        case 'mobile': return 'Mobile';
                        case 'created_on': return 'CreatedOn';
                        case 'updated_on': return 'UpdatedOn';
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
                $criteria->compare('highlight_file_id',$this->highlight_file_id);
                $criteria->compare('title',$this->title,true);
                $criteria->compare('font_size',$this->font_size,true);
                $criteria->compare('letter_spacing',$this->letter_spacing,true);
                $criteria->compare('link',$this->link,true);
                $criteria->compare('mobile',$this->mobile);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $highlight = self::model()->findByPk($id);
            if(isset($highlight->id))
                return $highlight;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name, $highlight_file_id, $title, $font_size, $letter_spacing, $link, $mobile){
            $highlight = new Highlights;
            $highlight->name = $name;
            $highlight->highlight_file_id = $highlight_file_id;
            $highlight->title = $title;
            $highlight->font_size = $font_size;
            $highlight->letter_spacing = $letter_spacing;
            $highlight->link = $link;
            $highlight->mobile = $mobile;
            $highlight->created_on = HelperFunctions::getDate();
            $highlight->updated_on = HelperFunctions::getDate();
            $highlight->deleted = 0;
            if($highlight->save())
                return $highlight;
            else{
                Errors::log('Error en Models/Highlights/create','Error creating highlight',print_r($highlight->getErrors(),true));
                return $highlight;
            }
        }
            
        public function updateAttributes($name, $highlight_file_id, $title, $font_size, $letter_spacing, $link, $mobile){
            $this->name = $name;
            $this->highlight_file_id = $highlight_file_id;
            $this->title = $title;
            $this->font_size = $font_size;
            $this->letter_spacing = $letter_spacing;
            $this->link = $link;
            $this->mobile = $mobile;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Highlights/updateHighlight','Error updating highlight id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteHighlight(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Highlights/deleteHighlight','Error deleting highlight id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
    public function loadHighlightFile(){
            $this->highlightFile = Files::get($this->highlight_file_id);
        }
}
?>