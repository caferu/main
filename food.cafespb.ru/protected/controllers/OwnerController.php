<?php

class OwnerController extends Controller
{
    public $resto;

    public function init()
    {
        if (!empty($_GET['id'])) {
            $this->resto = SResto::model()->findByAttributes(array('c_metka' => $_GET['id']));
            if (!empty($this->resto)) Yii::app()->user->setState('resto', $this->resto);
            else $this->redirect('site/index');
        }
        if (isset(Yii::app()->user->resto)) {
            $this->resto = Yii::app()->user->resto;
        }
        parent::init();
    }

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
                  'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        // if (empty($this->demand))
        //    throw new CHttpException(404, Yii::t('ru','The requested page does not exist.'));

        $this->layout = 'owner';
        $this->pageTitle = $this->resto->c_name. '. Общегородская банкетная база';
        $model_date = new BusyDates('search');
        $model_date->id_object = $this->resto->id;
        $model_date->busy_date = date('d-m-Y');
        $param = Yii::app()->getRequest()->getParam('BusyDates');
        if (!empty($param)) {
            $newDate = new BusyDates;
            $newDate->attributes = $param;
            $newDate->busy_date = date('Y-m-d', strtotime($param['busy_date']));
            $newDate->save();
        }
        $busy_dates = BusyDates::model()->findAll(array('condition' => "id_object=" . $this->resto->id . " and busy_date>='" . date('Y-m-d') . "' and id_user is null", 'order' => 'busy_date ASC'));
        $renderVars = array('model_date' => $model_date, 'busy_dates' => $busy_dates);
        $this->render('index', $renderVars);
    }

   public function actionDeleteBusyDate($idDate)
    {
        $date = BusyDates::model()->findByPk($idDate);
        $date->delete();
        $this->redirect('/owner?id='.$this->resto->c_metka);

    }


}
 
