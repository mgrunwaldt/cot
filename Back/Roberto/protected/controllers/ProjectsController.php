<?php

class ProjectsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('getArray', 'getAllArray', 'viewMain', 'viewAdd', 'viewEdit', 'add', 'save', 'delete', 'getAllFromCategoryArray'),
                'users' => array('@'),
                'expression' => 'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\')',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewMain() {
        try {

            $this->render('main');
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionViewMain', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewAdd() {
        try {
            $categories = Categories::getAll();

            $this->render('add', array('categories' => $categories,));
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionViewAdd', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewEdit($id = 0) {
        try {
            $projects = Projects::getAll();
            $categories = Categories::getAll();

            $this->render('edit', array('id' => $id, 'projects' => $projects, 'categories' => $categories));
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionViewEdit', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionAdd() {
        $response = array();
        try {
            if (isset($_POST['project']) && is_array($_POST['project'])) {
                $projectArray = $_POST['project'];
                if (isset($projectArray['name']) && isset($projectArray['client']) && isset($projectArray['description']) && isset($projectArray['preview_file_id']) && isset($projectArray['category_id']) && isset($projectArray['active'])) {

                    $project = Projects::create($projectArray['name'], $projectArray['client'], $projectArray['description'], $projectArray['preview_file_id'], $projectArray['category_id'], $projectArray['active']);
                    if (!$project->hasErrors()) {

                        $projectFiles = array();
                        if (isset($projectArray['projectFiles']) && is_array($projectArray['projectFiles']))
                            $projectFiles = $projectArray['projectFiles'];
                        ProjectFiles::updateProject($project->id, $projectFiles, true);



                        $response['status'] = 'ok';
                        $response['message'] = Projects::getModelName('singular') . ' agregado.';
                        $response['id'] = $project->id;

                        Logs::log('Se creó el Project ' . $project->id);
                    }
                    else {
                        $response['status'] = 'error';
                        $response['error'] = 'errorSavingProject';
                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($project);
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'noData';
                $response['errorMessage'] = 'noData';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ProjectController/actionAdd', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionSave() {
        $response = array();
        try {
            if (isset($_POST['project']) && is_array($_POST['project'])) {
                $projectArray = $_POST['project'];
                if (isset($projectArray['id']) && is_numeric($projectArray['id']) && isset($projectArray['name']) && isset($projectArray['client']) && isset($projectArray['description']) && isset($projectArray['preview_file_id']) && isset($projectArray['category_id']) && isset($projectArray['active'])) {
                    $project = Projects::get($projectArray['id']);
                    if (isset($project->id)) {

                        $project->updateAttributes($projectArray['name'], $projectArray['client'], $projectArray['description'], $projectArray['preview_file_id'], $projectArray['category_id'], $projectArray['active']);
                        if (!$project->hasErrors()) {

                            $projectFiles = array();
                            if (isset($projectArray['projectFiles']) && is_array($projectArray['projectFiles']))
                                $projectFiles = $projectArray['projectFiles'];
                            ProjectFiles::updateProject($project->id, $projectFiles, false);


                            $response['status'] = 'ok';
                            $response['message'] = Projects::getModelName('singular') . ' guardado.';

                            Logs::log('Se editó el Project ' . $project->id);
                        }
                        else {
                            $response['status'] = 'error';
                            $response['error'] = 'ErrorSavingProject';
                            $response['errorMessage'] = HelperFunctions::getErrorsFromModel($project);
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'NoProjectWithId';
                        $response['errorMessage'] = 'NoProjectWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'noData';
                $response['errorMessage'] = 'noData';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionSave', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionGetArray() {
        try {
            if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                $project = Projects::get($_POST['id']);
                if (isset($project->id)) {
                    $projectArray = HelperFunctions::modelToArray($project);


                    $project->loadPreviewFile();
                    $projectArray['previewFile'] = HelperFunctions::modelToArray($project->previewFile);


                    $project->loadProjectFiles();
                    $projectArray['projectFiles'] = array();
                    foreach ($project->projectFiles as $projectFil)
                        $projectArray['projectFiles'][] = HelperFunctions::modelToArray($projectFil);
                    $response['status'] = 'ok';
                    $response['project'] = $projectArray;
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'NoProjectWithId';
                    $response['errorMessage'] = 'NoProjectWithId';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'invalidData';
                $response['errorMessage'] = 'invalidData';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionGetArray', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionGetAllArray() {
        try {
            $projectsArray = array();
            $projects = Projects::getAll();
            foreach ($projects as $project)
                $projectsArray[] = HelperFunctions::modelToArray($project);

            $response['projects'] = $projectsArray;
            $response['status'] = 'ok';

            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionGetAllArray', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionDelete() {
        $response = array();
        try {
            if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                $project = Projects::get($_POST['id']);
                if (isset($project->id)) {
                    $project->deleteProject();
                    $response['status'] = 'ok';
                    $response['message'] = Projects::getModelName('singular') . ' eliminado.';

                    Logs::log('Se eliminó el Project ' . $_POST['id']);
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'noProjectWithId';
                    $response['errorMessage'] = 'noProjectWithId';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'noData';
                $response['errorMessage'] = 'noData';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionDelete', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionGetAllFromCategoryArray() {
        if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
            $response = array();
            $projectsArray = array();
            $category_id = $_POST['category_id'];
            $projects = Projects::model()->getAllFromCategory($category_id);
            foreach ($projects as $project) {
                $projectsArray[] = HelperFunctions::modelToArray($project);
            }
            $response['status'] = 'ok';
            $response['projects'] = $projectsArray;

            echo(json_encode($response));
        }
    }

    public function actionView($id, $name) {
        try {
            $this->layout = 'main';
            $project = Projects::get($id);
            $catId = $project->category_id;
            $projectCat = Categories::get($catId);
            $projectCatStr = (string) $projectCat->name;
            if (isset($project->id)) {
                if ($name == HelperFunctions::prepareToLink($project->name)) {
                    $project->loadPreviewFile();
                    $project->loadProjectFiles();

                    if ($this->isMobile) {
                        $this->layout = 'mainMobile';
                        $this->render('view', array('project' => $project, 'category' => $projectCatStr,'mobile'=>"1"));
                    } else {
                        $this->render('view', array('project' => $project, 'category' => $projectCatStr,'mobile'=>"0"));
                    }

                    
                } else {
                    $this->redirect('/projects/view/' . $project->id . '/' . HelperFunctions::prepareToLink($project->name));
                }
            } else {
                $this->redirect('/site/userError');
            }
        } catch (Exception $ex) {
            Errors::log('Error en ProjectsController/actionView', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /* public function actionViewMobile($id, $name){
      try{
      $this->layout = 'main';
      $project = Projects::get($id);
      $catId = $project->category_id;
      $projectCat = Categories::get($catId);
      $projectCatStr = (string)$projectCat->name;
      if(isset($project->id)){
      if($name == HelperFunctions::prepareToLink($project->name)){
      $project->loadPreviewFile();
      $project->loadProjectFiles();
      $this->render('viewMobile', array('project'=>$project, 'category'=>$projectCatStr));
      }else{
      $this->redirect('/Projects/viewMobile/'.$project->id.'/'.HelperFunctions::prepareToLink($project->name));
      }
      }else{
      $this->redirect('/site/userError');
      }
      }catch(Exception $ex){
      Errors::log('Error en ProjectsController/actionView',$ex->getMessage(),'');
      $this->redirect('/site/userError');
      }
      } */
}

?>