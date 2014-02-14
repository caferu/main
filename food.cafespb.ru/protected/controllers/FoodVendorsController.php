<?php
/**
 * Контроллер для управления моделью FoodVendors
 *
 * @author     Undefined
 * @package Controllers
 * @throws     CHttpException
 */
class FoodVendorsController extends MyController
{
    /**
     * Название класса модели.
     *
     * @var string $model
     */
    public $model = 'FoodVendors';

    public $menu = 2;

    /**
     * Возвращает параметры доступа к контроллеру
     *
     * @return array
     */
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

    /**
     * Возвращает список действий
     *
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'intranet.components.actions.RedirectToAdmin',
            'admin' => 'intranet.components.actions.Admin',
            'create' => 'intranet.components.actions.Create',
            'update' => 'intranet.components.actions.Update',
             'delete' => 'intranet.components.actions.Delete'
        );
    }

    /**
     * Загружает файлы в соответствии с методом uploadTo.
     *
     * @param mixed $model модель
     *
     * @see Messages::uploadTo()
     */
    public function performUploadsSaveToDisk($model)
    {
        if (!empty($_FILES)) {
            foreach ($_FILES[$this->model]['name'] as $_attribute => $_file) {
                if (!empty($_file)) {
                    $newName = Translite::rusencode($_file);
                    $fileName = dirname(__FILE__) . '/../../../cafespb.ru/' . $model->uploadTo($_attribute);
                    $model->$_attribute->saveAs(MyFilesystem::makeDirs($fileName));
                     $model->setAttribute($_attribute, $newName);
                    $image = new Imagick ($fileName);
                    $height = $image->getImageHeight();
                    $width = $image->getImageWidth();
                    if ($height < $width)
                        $image->scaleImage(142, 0);
                    else
                        $image->scaleImage(0, 142);
                    $model->setAttribute($_attribute, $newName);
                    $fileName = dirname(__FILE__) . '/../../../cafespb.ru/' . $model->uploadTo($_attribute);
                    $image->writeImage($fileName);
                    $image->clear();
                    $image->destroy();




                    $model->save();

                }
            }
        }
    }

    public function onUpdateBeforeRender($params)
    {
        $model = $params['model'];
        $this->breadcrumbs = array(
            'Рестораны' => array('foodVendors/admin'),
            $model->name,
        );
        return $params;
    }

    public function onAdminBeforeRender($params)
    {
        $this->breadcrumbs = array(
            'Рестораны'
        );
       // var_dump($params['model']->attributes);
        return $params;
    }

    public function onUpdateAfterSave($params)
    {
        $model = $params['model'];
        FoodVendorsTypes::model()->deleteAll('vendor_id=' . $model->id);
        //
        FoodVendorsMetro::model()->deleteAll('vendor_id=' . $model->id);
        FoodVendorsKitchens::model()->deleteAll('vendor_id=' . $model->id);


        if (!empty($_POST['FoodVendors']['types'])) {
            foreach ($_POST['FoodVendors']['types'] as $v) {
                $mod = new FoodVendorsTypes();
                $mod->vendor_id = $model->id;
                $mod->type_id = $v;
                $mod->save();
            }
        }

        if (!empty($_POST['FoodVendors']['districts'])) {
            $old = $model->districts;

            $new = $_POST['FoodVendors']['districts'];
            if (!empty($old)) {
                foreach ($old as $v) {
                    //   var_dump($model->id); exit;
                    if (!in_array($v->id, $new)) FoodVendorsDistricts::model()->deleteByPk(array("vendor_id" => $model->id, "district_id" => $v->id));
                }
            }

            foreach ($new as $v) {
                $has = false;
                if (!empty($old)) {
                    foreach ($old as $vv) {
                        if ($vv->id == $v) $has = true;
                    }
                }
                if (!$has) {
                    $mod = new FoodVendorsDistricts();
                    $mod->vendor_id = $model->id;
                    $mod->district_id = $v;
                    $mod->save();
                }
            }
        } else {
            FoodVendorsDistricts::model()->deleteAll('vendor_id=' . $model->id);
        }

        if (!empty($_POST['FoodVendors']['metro'])) {
            foreach ($_POST['FoodVendors']['metro'] as $v) {
                $mod = new FoodVendorsMetro();
                $mod->vendor_id = $model->id;
                $mod->metro_id = $v;
                $mod->save();
            }
        }

        if (!empty($_POST['FoodVendors']['kitchens'])) {
            foreach ($_POST['FoodVendors']['kitchens'] as $v) {
                $mod = new FoodVendorsKitchens();
                $mod->vendor_id = $model->id;
                $mod->kitchen_id = $v;
                $mod->save();
            }
        }
        $params['model'] = $model;
        $this->redirect(array('admin'));

        return $params;
    }

    public function actionTiming($id)
    {

        $model = $this->loadModel($id);
        $this->breadcrumbs = array(
            'Рестораны' => array('foodVendors/admin'),
            $model->name . ' - Тайминг'
        );
        if (!empty($_POST['foodVendorsDistricts'])) {
            foreach ($_POST['foodVendorsDistricts'] as $k => $v) {
                $m = FoodVendorsDistricts::model()->find('district_id=' . $k . ' and vendor_id=' . $id);
                if (!empty($m)) {
                    $m->condition_id = $v;
                    $m->save();
                }
            }
            $this->setFlash('default', 'Изменения успешно внесены');
        }
        $this->render('timing', array('model' => $model));
    }

    public function actionAddCondition($id)
    {
        $model = new FoodVendorsConditions('search');
        $model->vendor_id = $id;
        if (!empty($_POST['FoodVendorsConditions'])) {
            $model->attributes = $_POST['FoodVendorsConditions'];
            if ($model->save()) $this->redirect(array('foodVendors/timing', 'id' => $id));
        }
        $this->renderPartial('condition', array('model' => $model));
    }

    public function actionEditCondition($id)
    {
        $model = FoodVendorsConditions::model()->findByPk($id);
        if (!empty($_POST['FoodVendorsConditions'])) {
            $model->attributes = $_POST['FoodVendorsConditions'];
            if ($model->save()) $this->redirect(array('foodVendors/timing', 'id' => $model->vendor_id));
        }
        $this->renderPartial('condition', array('model' => $model));
    }

    public function actionDeleteCondition($id)
    {
        $model = FoodVendorsConditions::model()->findByPk($id);
        $model->delete();
        $this->redirect(array('foodVendors/timing', 'id' => $model->vendor_id));
    }
}
