<?php
/**
 * Created by IntelliJ IDEA.
 * User: execut
 * Date: 30.09.11
 * Time: 13:34
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');
class MyDropDownImagesMulti extends CJuiInputWidget
{
    public $data;
    public $isShowEmptyOptions = true;
    public function run()
    {
        list($name, $id)        = $this->resolveNameID();
        $data   = $this->data;
        $values = $this->value;
        echo '<table class="my-dropdownimagemulti" id="' . $id . '"><tr><td>';
        $nbr     = 0;
        $newData = array();
        ksort($data);
        $has = false;
        foreach ($data as $pageNbr => $list) {
            if (!isset($data[$nbr])) {
                $newData[$nbr] = array();
            }

            foreach ($list as $row) {
                $newData[$nbr][] = $row;
            }

            if (isset($values[$pageNbr])) {
                echo '<div class="my-dropdownimagemulti-item">';
                $options = array(
                    'name'    => $name . '[' . (string)$nbr . ']',
                    'data'    => $list,
                    'options' => array(
                        'isShowEmptyOption' => $this->isShowEmptyOptions,
                        'label'             => $nbr + 1
                    )
                );

                if (isset($values[$pageNbr])) {
                    $options['value'] = $values[$pageNbr];
                }

                echo $this->widget('application.zii.widgets.jui.MyDropDownImages', $options, true);
                echo '<div class="my-dropdownimagemulti-button-delete"></div></div>';
                $has = true;
            }

            $nbr++;
        }

        if (!$has) {
            Yii::import('application.zii.widgets.jui.MyDropDownImages');
            MyDropDownImages::registerScripts();
        }

        echo '</td><td><div class="my-dropdownimagemulti-button-add"></div></td></tr></table>';
        $basePath = dirname(__FILE__) . '/assets/' . get_class($this);
        $app      = Yii::app();
        $baseUrl  = $app->getAssetManager()->publish($basePath);
        $cs       = $app->getClientScript();
        $cs->registerCssFile($baseUrl . '/myDropDownImagesMulti.css');
        $cs->registerScriptFile($baseUrl . '/myDropDownImagesMulti.js', CClientScript::POS_END);
        $dataJSON = CJSON::encode($newData);
        $js       = "$('#{$id}').dropDownImagesMulti({data: $dataJSON, name: '$name'});";
        $cs->registerScript(__CLASS__ . '#' . $this->id, $js);
    }
}
