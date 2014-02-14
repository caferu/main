<?php

class BusyDatesController extends MyController
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
                  'users' => array('@'),
            ),
            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

        public function actionIndex()
    {
        // if (empty($this->demand))
        //    throw new CHttpException(404, Yii::t('ru','The requested page does not exist.'));

        $this->menu = 5;
        $this->layout = 'column2';
        $this->pageTitle = 'Занятые даты. Общегородская банкетная база';
        $model_date = new BusyDates('search');
        $model_date->busy_date = date('d-m-Y');
        $param = Yii::app()->getRequest()->getParam('BusyDates');
        if (!empty($param)) {
            $newDate = new BusyDates;
            $newDate->attributes = $param;
            $newDate->id_user = Yii::app()->user->getState('id_user');
            $newDate->busy_date = date('Y-m-d', strtotime($param['busy_date']));
            $newDate->save();
        }
        $busy_dates = BusyDates::model()->findAll(array('condition' => " busy_date>='" . date('Y-m-d') . "' ", 'order' => 'busy_date ASC'));
        $renderVars = array('model_date' => $model_date, 'busy_dates' => $busy_dates);
        $this->render('index', $renderVars);
    }


       public function actionDelete($id)
    {
        $date = $this->loadModel($id);
        $date->delete();
        $this->redirect('/busyDates/index');

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
        $model = BusyDates::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
