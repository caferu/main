<?php

class GroupsController extends MyController {


    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login', 'logout'),
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

    public function actionIndex() {
        $this->menu = 3;
        $common = new DemandGroups('search');
        $common->b_public = 1;
        $my_groups = new DemandGroups('search');
        $my_groups->id_user = Yii::app()->user->getState('id_user');
        $my_groups->b_public = 0;
        $pager = array(
            'class' => 'DefaultLinkPager',
            'cssFile' => CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'),
            'header' => '',
            'firstPageLabel' => 'Первая',
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'lastPageLabel' => 'Последняя',
        );
        $this->render('index', array(
            'pager' => $pager,
            'common' => $common,
            'my_groups' => $my_groups
        ));
    }

    public function actionAdd() {
        $model = new DemandGroups;
        if (isset($_GET['DemandGroups'])) {
            $model->attributes = $_GET['DemandGroups'];
            $model->id_user = Yii::app()->user->getState('id_user');
            if ($model->save()) {
                print 1;
            }
        } else {
            $this->renderPartial('_form', array('model' => $model));
        }
    }

    public function actionUpdate() {
        $id = (isset($_GET['id'])) ? $_GET['id'] : $_GET['DemandGroups']['id'];
        $model = $this->loadModel($id);
        if (isset($_GET['DemandGroups'])) {
            $model->attributes = $_GET['DemandGroups'];
            if ($model->save()) {
                print 1;
            }
        } else {
            $this->renderPartial('_form', array('model' => $model));
        }
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        DemandGroupsObjects::model()->deleteAll('id_group=:id', array(':id' => $id));
        if ($model->delete()) {
            print 1;
        }
    }

    public function actionView($id) {
        $sql = "SELECT DISTINCT b.id, b.c_name FROM cf_address_relation a, cf_dict_district b
                WHERE a.is_district=b.id AND a.is_region=78  ORDER BY b.c_name";
        $command = Yii::app()->db->createCommand($sql);
        $districts = $command->queryAll();
        $podbor = new Goods('obj_podbor');
        //var_dump($_GET);
        $model = $this->loadModel($id);
        $this->renderPartial('view', array(
            'model' => $model, 'districts' => $districts, 'podbor' => $podbor
        ));
    }

    public function actionGetResto($id, $point = null) {
        $model = $this->loadModel($id);
        $conn = Yii::app()->db;
        $sql = "SELECT id_object from cf_demand_groups_objects where id_group=" . $id;
        $objects = $conn->createCommand($sql)->queryColumn();
        if (!empty($objects)) {
            $conn = Yii::app()->db_old;
            $sql = "SELECT id,c_name from goods where id in (" . implode(',', $objects) . ")";
            $obj = $conn->createCommand($sql)->queryAll();
        }
        print json_encode(array('success' => true, 'objects' => $obj, 'editable' => (int) $model->editable));
    }

    public function actionAddRestos($id_group) {
        $a_resto = $_GET['goods'];
        if (!empty($a_resto)) {
            foreach ($a_resto as $v) {
                $model = new DemandGroupsObjects;
                $model->id_object = $v;
                $model->id_group = $id_group;
                $model->save();
            }
        }
        print json_encode(array('success' => true));
    }

    public function actionDelResto($id_group) {
        $id_object = $_GET['id_object'];
        $model = DemandGroupsObjects::model()->find("id_group = :d AND id_object = :o", array(":d" => $id_group, ":o" => $id_object));
        if ($model->delete())  print json_encode(array('success' => true));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function loadModel($id) {
        $model = DemandGroups::model()->findByPk((int) $id);
        if ($model===null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}