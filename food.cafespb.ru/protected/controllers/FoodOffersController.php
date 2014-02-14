<?php
/**
 * Контроллер для управления моделью FoodOffers
 *
 * @author     Undefined
 * @package Controllers
 * @throws     CHttpException
 */
class FoodOffersController extends MyController
{
    /**
     * Название класса модели.
     *
     * @var string $model
     */
    public $model = 'FoodOffers';
    public $menu = 3;

    /**
     * Возвращает параметры доступа к контроллеру
     *
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'users' => array('@')
            ),
            array(
                'deny',
                'users' => array('*')
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
            //  'delete' => 'intranet.components.actions.Delete'
        );
    }

    public function onAdminBeforeRender()
    {
        //   $item = FoodVendors::model()->findAll();
        //   foreach ($item as $k=>$v) {
        //    $fileName = '/home/u90408/cafespb.ru/www/'.$v->uploadTo('logo');
        //    azzrael_resize($fileName, $fileName);
        //   print $fileName;
        //   }
        /*  $files = scandir($_SERVER['DOCUMENT_ROOT'] . '/data/food');
        foreach ($files as $file) {
            // d($file);

            if (strpos($file, 'xml') > 0) {

                $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/data/food/' . $file, "r");
                $data = fread($fp, 800000);
                fclose($fp);
                $xml = new SimpleXMLElement($data);
                foreach ($xml->shop->categories->category as $v) {
                    $cat = FoodCategories::model()->findByPk($v['id']);
                    if (!empty($cat)) {
                        $cat->name = $v[0];
                        $cat->save();
                    } else {
                        $cat = new FoodCategories();
                        $cat->id = $v['id'];
                        $cat->name = $v[0];
                        $cat->save();
                    }
                }

                $vId = $xml->shop->offers->offer[0]->vendor;
                $vendor = FoodVendors::model()->findByAttributes(array('identity' => $vId));
                if (empty($vendor)) {
                    $vendor = new FoodVendors();
                    $vendor->name = $vId;
                    $vendor->identity = $vId;
                    $vendor->save();
                }
                $delPrice = $xml->shop->offers->offer[0]->local_delivery_cost;
                $vendor->delivery_price = (int)$delPrice;
                $vendor->updated_at = date('c');
                $vendor->save();


                FoodOffers::model()->deleteAll('vendor_id=' . $vendor->id);
                foreach ($xml->shop->offers->offer as $v) {
                    $offer = new FoodOffers();
                    $offer->id = $v['id'];
                    $offer->name = $v->name;
                    $offer->category_id = $v->categoryId;
                    $offer->price = (int)$v->price;
                    $offer->picture = $v->picture;
                    $offer->store = ($v->store == 'true') ? 1 : 0;
                    $offer->pickup = ($v->pickup == 'true') ? 1 : 0;
                    $offer->delivery = ($v->delivery == 'true') ? 1 : 0;
                    $offer->vendor_id = $vendor->id;
                    $offer->description = $v->description;
                    $offer->url = $v->url;
                    if (!$offer->save()) d($offer->errors);
                }
            }
        }*/
        /* $criteria = new CDbCriteria;
        $criteria->order = 'id ASC';
        $offers = FoodOffers::model()->findAll('id > 4500 and id<=5000');
        foreach ($offers as $v) {
            $arr = explode('/', $v->picture);
            $name = $arr[count($arr) - 1];


            $fileName = '/home/u90408/cafespb.ru/www/' . $v->uploadTo('picture');
            $fileName2 = $fileName . $name;
            $fileName3 = $fileName . 'small/' . $name;
            if (!file_exists($fileName2)) {
                $file = @file_get_contents($v->picture);
                if (!empty($file)) {
                    print $v->id . '; ';
                    MyFilesystem::makeDirs($fileName);
                    MyFilesystem::makeDirs($fileName . 'small/');

                    $f = fopen($fileName2, 'w');
                    fwrite($f, $file);
                    fclose($f);
                    azzrael_resize($fileName2, $fileName3);
                }
            }
        }*/
        /* $item  = FoodVendors::model()->findAll();
        foreach ($item as $v){
            $v->setScenario('search');
            $v->url = Translite::rusencode($v->short_name);
            $v->save();
        }*/
        $this->breadcrumbs = array(
            'Меню'
        );
    }

    public function actionUpload()
    {
        Yii::import('application.extensions.EAjaxUpload.FileUploader');

        $uploader = new FileUploader(array(
                                          'xml',
                                     ));
        $dir = MyFilesystem::makeDirs('data/xml/');
        $result = $uploader->handleUpload($dir);

        if (isset($result['success']) && $result['success'] === true) {
            $fp = fopen($dir . $result['filename'], "r");
            $data = fread($fp, 800000);
            fclose($fp);
            $xml = new SimpleXMLElement($data);
            foreach ($xml->shop->categories->category as $v) {
                $cat = FoodCategories::model()->findByPk($v['id']);
                if (!empty($cat)) {
                    $cat->name = $v[0];
                    $cat->save();
                } else {
                    $cat = new FoodCategories();
                    $cat->id = $v['id'];
                    $cat->name = $v[0];
                    $cat->save();
                }
            }

            $vId = $xml->shop->offers->offer[0]->vendor;
            $vendor = FoodVendors::model()->findByAttributes(array('identity' => $vId));
            if (empty($vendor)) {
                $vendor = new FoodVendors();
                $vendor->name = $vId;
                $vendor->identity = $vId;
                $vendor->url = Translite::rusencode($vId);
                $vendor->save();
            }
            $delPrice = $xml->shop->offers->offer[0]->local_delivery_cost;
            $vendor->delivery_price = (int)$delPrice;
            $vendor->updated_at = date('c');
            $vendor->save();


            FoodOffers::model()->deleteAll('vendor_id=' . $vendor->id);
            foreach ($xml->shop->offers->offer as $v) {
                $offer = new FoodOffers();
                $offer->name = $v->name;
                $offer->category_id = $v->categoryId;
                $offer->price = (int)$v->price;
                $offer->picture = $v->picture;
                $offer->store = ($v->store == 'true') ? 1 : 0;
                $offer->pickup = ($v->pickup == 'true') ? 1 : 0;
                $offer->delivery = ($v->delivery == 'true') ? 1 : 0;
                $offer->vendor_id = $vendor->id;
                $offer->description = $v->description;
                $offer->url = $v->url;
                if (!$offer->save()) d($offer->errors);
            }
            $result['vendor'] = $vendor->name;
            $result = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        }

        echo $result; // it's array

    }
}

function azzrael_resize($imgname, $outfile)
{

    // новые размеры
    $neww = 142;
    $newh = 142;
    // качество выходного jpeg
    $quality = 100;

    $size = getimagesize($imgname);

    switch ($size["mime"]) {

        case "image/jpeg":
            $im = imagecreatefromjpeg($imgname); //jpeg file
            break;

        case "image/gif":
            $im = imagecreatefromgif($imgname); //gif file
            break;

        case "image/png":
            $im = imagecreatefrompng($imgname); //png file
            break;

        default:
            $im = false;
            break;
    }

    if (!$im) return false;

    $width_orig = $size[0];
    $height_orig = $size[1];

    $ratio_orig = $width_orig / $height_orig;

    if ($neww / $newh > $ratio_orig) {
        $new_height = $neww / $ratio_orig;
        $new_width = $neww;
    } else {
        $new_width = $newh * $ratio_orig;
        $new_height = $newh;
    }

    // поэкспериментируйте, эти коэффициенты определяют какой кусок исходника масштабировать
    // а какой обрезать - в этом вся умность функции собственно
    // но и нагрузка на GD соответственно
    $ky = 0;
    $kx = 0.5;
    $x_mid = $new_width * $kx;
    $y_mid = $new_height * $ky;

    $process = imagecreatetruecolor(round($new_width), round($new_height));
    $thumb = imagecreatetruecolor($neww, $newh);

    imagecopyresampled($process, $im, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid - ($neww * $kx)), ($y_mid - ($newh * $ky)), $neww, $newh, $neww, $newh);

    imagejpeg($thumb, $outfile, $quality);

    imagedestroy($process);
    imagedestroy($im);

    return true;
}
