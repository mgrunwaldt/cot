<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /* SEO Vars */
    public $pageURL = 'http://chacrasdelassierras.com';
    public $pageTitle = 'Roberto';
    public $pageDescription = '';
    public $pageRobotsIndex = true;
    public $pageImages = array(
        '0' => 'http://chacrasdelassierras.com/files/facebookMeta.jpg',
    );

    public $administrator=false;
    public $message=false;
    public $isMobile=false;

    public function init() {
        try{
            $this->isMobile = HelperFunctions::isMobileBrowser();
            if(strlen(CookieHandler::get('main')) != 32)
                Cookies::create();
            if(!isset(Yii::app()->session['set']))
                Sessions::create();
            
            //if(isset(Yii::app()->session['session_user_id'])){
            //    $this->user=Users::getCurrent();
            //}
            //else 
            if(isset(Yii::app()->session['session_admin_id'])){
                $this->administrator = Administrators::getCurrentAdministrator();
            }
        }
        catch (Exception $ex)
        {
            Errors::log('Error en Controller/init',$ex->getMessage(),'');
        }
    }
}