<?php

class MassmailController extends BackEndController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    protected function beforeAction($action) {
        $access = $this->checkAccess(Yii::app()->controller->id, Yii::app()->controller->action->id);
        if ($access == 1) {
            return true;
        } else {
            Yii::app()->user->setFlash('error', "You are not authorized to perform this action!");
            $this->redirect(array('/site/noaccess'));
        }
    }

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'send'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'send'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionSend($id) {
        $model = $this->loadModel($id);
        $criteria = '';
        if (!empty($model->user_group)) {
            $criteria .= ' AND t.group_id=' . $model->user_group;
        }
        if (!empty($model->user_status)) {
            $criteria .= ' AND t.status=' . $model->user_status;
        }
        $mailList = Yii::app()->db->createCommand()
                ->select('t.email')
                ->from('{{user}} t')
                ->where('t.email IS NOT NULL' . $criteria)
                ->join('{{user_profile}}', 't.id = {{user_profile}}.user_id')
                ->queryAll();

        $bccList = '';
        foreach ($mailList as $key => $values) {
            $bccList .= $values["email"] . ',';
        }
        //print $bccList; exit;
        $to = Yii::app()->params['adminEmail'];
        $subject = $model->subject;
        $message = $model->message_body;
        $fromName = Yii::app()->params['Companyname'];
        $fromMail = Yii::app()->params['adminEmail'];
        Massmail::sendMail($to, $subject, $message, $fromName, $fromMail, $bccList);
        Yii::app()->user->setFlash('success', 'Mail has been sent successfully!');
        $this->redirect(array('admin'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Massmail;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Massmail'])) {
            $model->attributes = $_POST['Massmail'];
            $model->created_on = new CDbExpression('NOW()');
            $model->created_by = Yii::app()->user->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Mass Mail has been created successfully');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Massmail'])) {
            $model->attributes = $_POST['Massmail'];
            $model->modified_on = new CDbExpression('NOW()');
            $model->modified_by = Yii::app()->user->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Mass Mail has been updated successfully');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Massmail');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Massmail('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Massmail'])) {
            $model->attributes = $_GET['Massmail'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Massmail the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Massmail::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Massmail $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'massmail-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}