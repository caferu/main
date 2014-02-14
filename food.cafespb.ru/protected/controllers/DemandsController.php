<?php

class DemandsController extends MyController
{


    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                  'actions' => array('login', 'logout','approve','cancel'),
                  'users' => array('*'),
            ),
            array('allow',
                  'users' => array('@'),
            ),
            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->menu = 1;
        Yii::import('application.web.widgets.pagers.*');
         Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'));
        $pager = array(
            'class' => 'DefaultLinkPager',
            'cssFile' => CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'),
            'header' => '',
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
        );
        $this->layout = 'column1';
        $model = new FoodDemands('search');
        $model->unsetAttributes();
        if (isset($_GET['FoodDemands']))
            $model->attributes = $_GET['FoodDemands'];
        $renderVars = array(
            'model' => $model, 'pager'=>$pager
        );
        $this->render('index', $renderVars);
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['FoodDemands'])) {
             $model->attributes = $_POST['FoodDemands'];
            if ($model->save()) echo 1; exit;
        }
        $this->renderPartial('_form', array(
                                  'model' => $model,
                             ));

    }

    public function actionCancel($id)
    {
        $model = FoodDemands::model()->find("mark='".$id."'");
        $model->food_demand_status_id = 5;
        $model->save();
        $this->render('linkStatus', array(
                               'model' => $model,
                                             'message' => 'Заказ отменен'
                             ));

    }

    public function actionApprove($id)
    {
        $model = FoodDemands::model()->find("mark='".$id."'");
        $model->food_demand_status_id = 2;
        $model->save();
        $this->render('linkStatus', array(
                               'model' => $model,
                                             'message' => 'Заказ принят'
                             ));

    }


    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function loadModel($id)
    {
        $model = FoodDemands::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}