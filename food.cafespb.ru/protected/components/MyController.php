<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MyController extends CController
{

    public $layout = '//layouts/column1';
    public $breadcrumbs = array();
    public $meta_kw = "Доставка еды";
    public $meta_descr = "Доставка еды";
    public $menu = 1;
    public $last_demands = array();
    public $cnt_demands = 50;
    public $cnt_obj = 12;
    public $is_new_window = 1;
    public $stat_demands = array();
    public $api_map = 'ALvLi08BAAAA3OxLKgIAtKJHbK7hf1d5eWz3yIRM0aHedgEAAAAAAAAAAAA0WUI611a5gtTKrFKiLbJulsw9Cg==';
        public $smtp = array(
        "host" => "smtp.cafespb.ru", //smtp сервер
        "debug" => 1, //отображение информации дебаггера (0 - нет вообще)
        "auth" => true, //сервер требует авторизации
        "port" => 25, //порт (по-умолчанию - 25)
        "sec" => 'tls',
        "username" => "ivan.petrunya@gmail.com", //имя пользователя на сервере
        "password" => "gbhjnt[ybrf", //пароль
     //  "addreply" => "admin@young-talents.ru", //ваш е-mail
    //    "replyto" => "admin@young-talents.ru" //e-mail ответа
    );

    function init()
    {
        parent::init();


    }

        public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

     /**
     * Загрузка записи модели.
     *
     * @param integer $id идентификатор
     *
     * @throws CHttpException
     * @return MyActiveRecord
     */
    public function loadModel($id)
    {
        $model = MyActiveRecord::model($this->model)->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Производит загрузку файлов и прикрепление их к модели.
     *
     * @param mixed $model модель
     */
    public function performUploads($model)
    {
        if (!empty($_FILES)) {
            foreach ($_FILES[$this->model]['name'] as $_attribute => $_file) {
                if (!empty($_file)) {
                    $model->$_attribute = CUploadedFile::getInstance($model, $_attribute);
                }
            }
        }
    }

    /**
     * Загружает файлы в соответствии с методом uploadTo.
     *
     * @param mixed $model модель
     *
     * @see MyActiveRecord::uploadTo()
     */
    public function performUploadsSaveToDisk($model)
    {
        if (!empty($_FILES)) {
            foreach ($_FILES[$this->model]['name'] as $_attribute => $_file) {
                if (!empty($_file)) {
                    $model->$_attribute->saveAs(MyFilesystem::makeDirs($model->uploadTo($_attribute)));
                }
            }
        }
    }

    /**
     * Ajax валидация.
     *
     * @param mixed $model инстанция модели или их массив
     */
    public function performAjaxValidation($model)
    {
        if (Yii::app()->getRequest()->isAjaxRequest && isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Записать flash сообщение в сессию.
     *
     * @param string $key   ключ
     * @param mixed  $value значение
     */
    public function setFlash($key, $value)
    {
        Yii::app()->user->setFlash($key, $value);
    }

    /**
     * Забрать flash сообщение из сессии.
     *
     * @param string $key ключ
     *
     * @return mixed сообщение
     */
    public function getFlash($key)
    {
        return Yii::app()->user->getFlash($key);
    }

    /**
     * Проверяет на наличии flash сообщения.
     *
     * @param string $key ключ
     *
     * @return boolean
     */
    public function hasFlash($key)
    {
        return Yii::app()->user->hasFlash($key);
    }

    /**
     * Возвращает название скрипта вида по типу действия
     *
     * @param string $action Тип действия
     *
     * @return string
     */
    public function getViewScriptNameByAction($action)
    {
        $class = get_class($action);
        if ($class == 'Copy') {
            $class = 'Create';
        }

        return strtolower($class);
    }

    /**
     * Возвращает переданные данные GET в контроллер.
     *
     * @return array
     */
    public function getActionParams()
    {
        return $_GET;
    }

    /**
     * Возвращает переданные данные POST в контроллер.
     *
     * @return array
     */
    public function getActionPostParams()
    {
        return $_POST;
    }

    public function getQuery($name, $defaultValue = null)
    {
        return Yii::app()->getRequest()->getQuery($name, $defaultValue);
    }

    public function getPost($name, $defaultValue = null)
    {
        return Yii::app()->getRequest()->getPost($name, $defaultValue);
    }
}