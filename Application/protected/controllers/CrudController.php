<?php

class CrudController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
                array('allow',  // allow authenticated
                    'users'=>array('@'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $module = $this->getModuleName();
        if (!Yii::app()->user->checkAccess('view'.$module,
                array('company' => 1))) {
            throw new CHttpException(404,'Access denied.');
        }

        $this->render('view',array(
                'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $module = $this->getModuleName();
        $model=new $module;

        if (!Yii::app()->user->checkAccess('create'.$module)) {
            throw new CHttpException(404,'Access denied.');
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[$module])) {
                $model->attributes=$_POST[$module];
                $this->beforeSave($model);
                if($model->validate() and $model->save()) {
                    $this->afterSave($model);
                    $this->redirect(array('view','id'=>$model->id));
                }
        }

        $this->render('create',array(
                'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $module = $this->getModuleName();
        $model=$this->loadModel($id);

        if (!Yii::app()->user->checkAccess('update'.$module, 
                array('company' => 1))) {
            throw new CHttpException(404,'Access denied.');
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[$module]))
        {
                $model->attributes=$_POST[$module];
                $this->beforeSave($model);
                if($model->save()) {
                    $this->afterSave($model);
                    $this->redirectAfterSave($model);
                }
        }

        $this->render('update',array(
                'model'=>$model,
        ));
    }
    protected function redirectAfterSave($model)
    {
        $this->redirect(array('index'));
    }

    protected function beforeSave($model)
    {

    }
    protected function afterSave($model)
    {

    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $this->delete($model);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteItems()
    {
        $module = $this->getModuleName();
        $selectedIds = Yii::app()->request->getParam('selectedIds', array());

        foreach ($selectedIds as $id) {
             $model = $this->loadModel($id);
             $this->delete($model);
        }

        $this->redirect(Yii::app()->request->getUrlReferrer());
    }

    protected function delete($model)
    {
        $module = $this->getModuleName();
        if (!Yii::app()->user->checkAccess('delete'.$module,
                array('company' => 1))) {
            throw new CHttpException(404,'Access denied.');
        }

        $model->delete();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $module = $this->getModuleName();

        if (!Yii::app()->user->checkAccess('index'.$module)) {
            throw new CHttpException(404,'Access denied.');
        }

        $model=new $module('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[$module]))
                $model->attributes=$_GET[$module];

        $this->render('index',array(
                'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $module = $this->getModuleName();

        $model=$module::model()->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
    }
}
