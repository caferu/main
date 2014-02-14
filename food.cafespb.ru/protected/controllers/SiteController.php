<?php

class SiteController extends MyController
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

    public function getViewed($id_tape)
    {
        $sql = 'Select count(*) from cf_messages where id_tape=' . $id_tape . ' and status=1';
        $cnt = Yii::app()->db->createCommand($sql)->queryScalar();
        $sql = 'Select count(a.id) from cf_messages a, cf_viewed_messages b
                where a.id=b.id_message and b.id_user=' . Yii::app()->user->id_user . ' and a.id_tape=' . $id_tape . ' and a.status=1';
        $cnt_read = Yii::app()->db->createCommand($sql)->queryScalar();
        $read = $cnt - $cnt_read;
        return $read;
    }

    public function actionIndex()
    {

        $read = array();
        $read[3] = $this->getViewed(3);
        $read[4] = $this->getViewed(4);
        $read[9] = $this->getViewed(9);

        $news = new Messages('search');
        $news->id_tape = 3;

        $resto = new Messages('search');
        $resto->id_tape = 4;

        $bonus = new Messages('search');
        $bonus->id_tape = 9;

        $pager = array(
            'class' => 'DefaultLinkPager',
            'cssFile' => CHtml::asset(Yii::getPathOfAlias('application.web.widgets.pagers.pager') . '.css'),
            'header' => '',
            'firstPageLabel' => 'Первая',
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'lastPageLabel' => 'Последняя',
        );
        // $resto=Messages::model()->actual()->findAllByAttributes(array('id_tape'=>2));
        $demands = new Demands();
        $this->menu = 1;
        $this->render('index', array(
                                    'news' => $news, 'resto' => $resto, 'demands' => $demands,
                                    'pager' => $pager, 'read' => $read, 'bonus' => $bonus
                               ));
    }

    public function actionPreferences()
    {
        $model = Preferences::model()->findByPk(Yii::app()->user->id_user);
        if (!empty($_POST['Preferences'])) {
            $model->attributes = $_POST['Preferences'];
            $model->save();
        }
        $this->render('preferences', array(
                                          'model' => $model
                                     ));
    }

    public function actionEditUser()
    {
        $folder = '/home/u90408/basespb.ru/www/imgupload/staff/';
        $model = Users::model()->findByPk(Yii::app()->user->id_user);
        if (!empty($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if (!empty($_FILES['file']['tmp_name'])) {
                $upl2 = new FotoUploader('file');
                if ($upl2->upload_basespb_users($folder)) {
                    $model->c_photo = $upl2->new_name;
                }
            }
            if ($model->save()) $this->redirect('user');
        }
        $this->render('edit_user', array(
                                        'model' => $model
                                   ));
    }

    public function actionUser()
    {
        $model = Users::model()->findByPk(Yii::app()->user->id_user);
        //  var_dump($model); exit;
        $this->render('user', array(
                                   'model' => $model
                              ));
    }

    public function actionPage()
    {
        if (!empty($_GET['id'])) {
            $model = Messages::model()->findByPk($_GET['id']);
        }
        if (!empty($_GET['url'])) {
            $model = Messages::model()->findByAttributes(array('c_url' => $_GET['url']));
        }
        $viewed = ViewedMessages::model()->findByAttributes(array('id_message' => $model->id, 'id_user' => Yii::app()->user->id_user));
        if (empty($viewed)) {
            $vm = new ViewedMessages();
            $vm->id_message = $model->id;
            $vm->id_user = Yii::app()->user->id_user;
            $vm->save();
        }
        $this->meta_kw = (empty($model->c_meta_kwords)) ? $this->meta_kw : $model->c_meta_kwords;
        $this->meta_descr = (empty($model->c_meta_descr)) ? $this->meta_descr : $model->c_meta_descr;
        $this->pageTitle = (empty($model->c_meta_title)) ? $model->c_header . ' | Общегородская банкетная служба'
                : $model->c_meta_title;
        $this->render('page', array(
                                   'model' => $model
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


    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        $this->layout = 'enter';
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()){
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionViewResto($id)
    {
        $this->menu = 4;
        $this->layout = 'column1';
        $model = SResto::model()->findByPk($id);

        $view = 'resto';
        if (isset($_GET['debug'])) $view = 'resto2';
        $this->pageTitle = $model->l_name . '. ' . $this->pageTitle;
        $this->breadcrumbs = array(
            $model->l_name,
        );
        $this->render($view, array('model' => $model));
    }

    public function actionGetPhotos($id, $type)
    {
        $model = SResto::model()->findByPk($id);
        $images = Images::model()->findAll('id_object=' . $id . ' and is_image_type=' . $type);
        $Type = DictImageType::model()->findByPk($type);
        if (!empty($images)) {
            foreach ($images as $v) {
                $arr = $v->attributes;
                if (empty($arr['c_name'])) {
                    $arr['c_name'] = '';
                }
                $photos[] = $arr;
            }
        }
        print json_encode(array('success' => true, 'photos' => $photos, 'name' => $model->l_name, 'address' => $model->addr, 'type' => $Type->c_name));
    }
}