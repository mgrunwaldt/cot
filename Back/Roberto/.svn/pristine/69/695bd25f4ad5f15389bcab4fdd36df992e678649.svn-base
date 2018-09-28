<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticateAdmin','on'=>'admin'),
			array('password', 'authenticateClientUser','on'=>'clientUser'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	public function authenticateAdmin($attribute,$params)
	{	
		$this->_identity=new UserIdentity($this->username,$this->password);
		if(!$this->_identity->authenticateAdmin())
			$this->addError('password','Incorrect username or password.');
	}

	public function authenticateClientUser($attribute,$params)
	{	
		$this->_identity=new UserIdentity($this->username,$this->password);
		if(!$this->_identity->authenticateClientUser())
			$this->addError('password','Incorrect username or password.');
	}

	public function loginAdmin()
	{
		if($this->_identity===null)
		{	
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	public function loginClientUser()
	{
		if($this->_identity===null)
		{	
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
