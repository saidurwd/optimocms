<?php

class ContentCategoryController extends BackEndController {

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
                'actions' => array('*'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'view', 'ordering'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionOrdering() {
        set_time_limit(0);
        //for path
        $parent = ContentCategory::model()->findAll(array('condition' => 'parent_id=0 OR parent_id IS NULL'));
        foreach ($parent as $key => $values) {
            Yii::app()->db->createCommand('UPDATE {{content_category}} SET `path` = CONCAT("0.",' . $values["id"] . ') WHERE id=' . (int) $values["id"])->execute();
        }
        $parent1 = ContentCategory::model()->findAll(array('condition' => 'parent_id=0 OR parent_id IS NULL'));
        foreach ($parent1 as $key => $values1) {
            $parent2 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values1["id"]));
            foreach ($parent2 as $key => $values2) {
                Yii::app()->db->createCommand('UPDATE {{content_category}} SET `path` = CONCAT("' . $values1["path"] . '",".",' . $values2["id"] . ') WHERE id=' . (int) $values2["id"])->execute();

                $parent3 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values2["id"]));
                foreach ($parent3 as $key => $values3) {
                    Yii::app()->db->createCommand('UPDATE {{content_category}} SET `path` = CONCAT("' . $values2["path"] . '",".",' . $values3["id"] . ') WHERE id=' . (int) $values3["id"])->execute();

                    $parent4 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values3["id"]));
                    foreach ($parent4 as $key => $values4) {
                        Yii::app()->db->createCommand('UPDATE {{content_category}} SET `path` = CONCAT("' . $values3["path"] . '",".",' . $values4["id"] . ') WHERE id=' . (int) $values4["id"])->execute();
                    }
                }
            }
        }

        //for alias
        $parent = ContentCategory::model()->findAll(array('condition' => 'parent_id=0 OR parent_id IS NULL'));
        foreach ($parent as $key => $values) {
            Yii::app()->db->createCommand('UPDATE {{content_category}} SET `alias` = "' . $values["title"] . '" WHERE id=' . (int) $values["id"])->execute();
        }
        $parent1 = ContentCategory::model()->findAll(array('condition' => 'parent_id=0 OR parent_id IS NULL'));
        foreach ($parent1 as $key => $values1) {
            $parent2 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values1["id"]));
            foreach ($parent2 as $key => $values2) {
                Yii::app()->db->createCommand('UPDATE {{content_category}} SET `alias` = CONCAT("' . $values1["alias"] . '","/","' . $values2["title"] . '") WHERE id=' . (int) $values2["id"])->execute();

                $parent3 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values2["id"]));
                foreach ($parent3 as $key => $values3) {
                    Yii::app()->db->createCommand('UPDATE {{content_category}} SET `alias` = CONCAT("' . $values2["alias"] . '","/","' . $values3["title"] . '") WHERE id=' . (int) $values3["id"])->execute();

                    $parent4 = ContentCategory::model()->findAll(array('condition' => 'parent_id = ' . (int) $values3["id"]));
                    foreach ($parent4 as $key => $values4) {
                        Yii::app()->db->createCommand('UPDATE {{content_category}} SET `alias` = CONCAT("' . $values3["alias"] . '","/","' . $values4["title"] . '") WHERE id=' . (int) $values4["id"])->execute();
                    }
                }
            }
        }

        Yii::app()->user->setFlash('success', "Category ordering was updated successfully.");
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

        $model = new ContentCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ContentCategory'])) {
            $model->attributes = $_POST['ContentCategory'];
            $model->created_time = new CDbExpression('NOW()');
            $model->created_by = Yii::app()->user->id;
            if (empty($model->alias)) {
                $model->alias = str_replace(' ', '-', strtolower($model->title));
            } else {
                $model->alias = str_replace(' ', '-', strtolower($model->alias));
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Saved successfully');
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

        if (isset($_POST['ContentCategory'])) {
            $model->attributes = $_POST['ContentCategory'];
            $model->modified_time = new CDbExpression('NOW()');
            $model->modified_by = Yii::app()->user->id;
            $model->alias = str_replace(' ', '-', strtolower($model->title));
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Saved successfully');
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
            //check if there any dependancy
            $total_sub_category = ContentCategory::getNumberOfSubCategory($id);
            $total_content = ContentCategory::getNumberOfContent($id);
            if ($total_sub_category <= 0 && $total_content <= 0) {
                $this->loadModel($id)->delete();
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->redirect(array('admin'));
        $dataProvider = new CActiveDataProvider('ContentCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new ContentCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ContentCategory']))
            $model->attributes = $_GET['ContentCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ContentCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'content-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
