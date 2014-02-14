<?php
/**
 * Created by IntelliJ IDEA.
 * User: execut
 * Date: 30.09.11
 * Time: 13:34
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');
class MyImageDynamicClipper extends CJuiInputWidget
{
    public $data;
    public $images = array();
    public $ratio  = 1;

    public $value            = array();
    protected $_loadedImages    = array();
    public $thumbnailsFolder = 'uploads/pdf/pages/thumbnails/photos';
    public $previewWidth     = 300;

    public function run()
    {
        list($name, $id)       = $this->resolveNameID();
        $value = $this->value;
        $value = $this->checkValue($value);
        if ($this->hasModel()) {
            $name = CHtml::resolveName($this->model, $this->attribute);
        }

        $currentImageUrl = $this->images[$value['currentImageNbr']];

        $basePath = dirname(__FILE__) . '/assets/MyImageDynamicClipper';

        $app     = Yii::app();
        $baseUrl = $app->getAssetManager()->publish($basePath);
        $cs      = $app->getClientScript();
        $cs->registerCssFile($baseUrl . '/myImageDynamicClipper.css');
        $cs->registerScriptFile($baseUrl . '/myImageDynamicClipper.js', CClientScript::POS_END);

        $current = 0;
        foreach ($this->images as $imageId => $imageUrl) {
            $image        = $this->getImage($imageId);
            $newImageUrl  = $this->thumbnailsFolder . '/' . $imageId . '.' . $image->ext;
            $newImagePath = Yii::app()->basePath . '/../' . $newImageUrl;
            if (!file_exists($newImagePath)) {
                MyFilesystem::makeDirs($newImagePath);
                $image->resize(100, 80, Image::HEIGHT);
                $image->save($newImageUrl);
            }

            $imagesParams[$current] = array(
                'id'        => $imageId,
                'thumbnail' => $newImageUrl,
                'url'       => $imageUrl
            );
            $current++;
        }

        $inputsHtml = '';
        foreach ($value as $key => $val) {
            $inputsHtml .= CHtml::hiddenField($name . '[' . $key . ']', $val, array(
                'id'    => $id . '-' . $key,
                'value' => $val
            ));
        }

        if (!isset($this->htmlOptions['style'])) {
            $styleString = '';
        } else {
            $styleString = $this->htmlOptions['style'] . ';';
        }

        $styleString .= 'overflow: hidden';
        $matches     = array();
        preg_match('/width: ?(\d+(.\d+)?)px/', $styleString, $matches);
        $prevW   = $matches[1];
        $matches = array();
        preg_match('/height: ?(\d+(.\d+)?)px/', $styleString, $matches);
        $prevH = $matches[1];

        $matches = array();
        preg_match('/top: ?(\d+(.\d+)?)px/', $styleString, $matches);
        $top = $matches[1];

        $matches = array();
        preg_match('/left: ?(\d+(.\d+)?)px/', $styleString, $matches);
        $left = $matches[1];

        if (!empty($value['currentImageNbr'])) {
            $image = $this->getImage($value['currentImageNbr']);
            if ($value['w'] / $value['h'] > $prevW / $prevH) {
                $h1 = $prevW / $value['w'] * $value['h'];
                $w1 = $prevW;
            } else {
                $w1 = $prevH / $value['h'] * $value['w'];
                $h1 = $prevH;
            }

            $styleString .= ';width: ' . $w1 . 'px' . ';height: ' . $h1 . 'px' . ';top: ' . ($top + ($prevH - $h1) / 2) . 'px' . ';left: ' . ($left + ($prevW - $w1) / 2) . 'px';

            $rx = $w1 / $value['w'];
            $ry = $h1 / $value['h'];

            $w = round($rx * $this->previewWidth);
            $h = round($ry * $image->height / $image->width * $this->previewWidth);

            $imgStyle = 'width:' . $w . 'px;height:' . $h . 'px;margin-top:-' . ($value['y'] * $ry)
                 . 'px;margin-left:-' . ($value['x'] * $rx) . 'px';
        }

        if (empty($currentImageUrl)) {
            $src = 'images/pdf/image-block/pix.jpg';
        } else {
            $src = $currentImageUrl;
        }

        $img = CHtml::tag('img', array(
            'src'   => $src,
            'style' => $imgStyle
        ));

        echo CHtml::tag('div', array(
            'style' => $styleString,
            'class' => 'MyImageDynamicClipper',
            'id'    => $id
        ), $inputsHtml . $img);

        $params = array(
            'value'         => $value,
            'images'        => $imagesParams,
            'ratio'         => $this->ratio,
            'initialElSize' => array(
                't' => $top,
                'l' => $left,
                'w' => $prevW,
                'h' => $prevH
            )
        );

        $JSONParams = CJSON::encode($params);
        $js         = "$('#{$id}').imageDynamicClipper($JSONParams);";
        $cs->registerScript(__CLASS__ . '#' . $this->id, $js);

        return $id;
    }

    protected function getImage($imageId)
    {
        if (!isset($this->_loadedImages[$imageId])) {
            $image                         = Yii::app()->image->load($this->images[$imageId]);
            $this->_loadedImages[$imageId] = $image;
        }

        return $this->_loadedImages[$imageId];
    }

    protected function checkValue($values)
    {
        if (!empty($values['currentImageNbr'])) {
            $currentImageNbr = $values['currentImageNbr'];
            if (empty($values['x'])) {
                $values['x'] = 0;
            }

            if (empty($values['y'])) {
                $values['y'] = 0;
            }

            if (empty($values['w'])) {
                $image = $this->getImage($currentImageNbr);
                if (!empty($values['h'])) {
                    /**
                     * @TODO Недоделано
                     */
                } else {
                    if ($image->width < $image->height * $this->ratio) {
                        $values['w'] = $image->width / ($image->height * $this->ratio) * $this->previewWidth;
                        $values['h'] = $this->previewWidth * $this->ratio;
                    } else {
                        $values['w'] = $this->previewWidth * $this->ratio;
                        $values['h'] = $image->height / ($image->width / $this->ratio) * $this->previewWidth;
                    }
                }
            } else {
                if (!empty($values['h'])) {
                    /**
                     * @TODO Недоделано
                     */
                }
            }
        }

        $keys = array(
            'x',
            'y',
            'w',
            'h',
            'currentImageNbr'
        );
        foreach ($values as $key => $value) {
            if (!in_array($key, $keys)) {
                unset($values[$key]);
            } else if ($key !== 'currentImageNbr') {
                $values[$key] = (int)$values[$key];
            }
        }

        return $values;
    }
}
