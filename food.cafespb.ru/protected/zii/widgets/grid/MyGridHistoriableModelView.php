<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.zii.widgets.grid.MyGridHistoriableDataColumn');
Yii::import('application.web.widgets.pagers.MyLinkPager');
/**
 * Грид для отображения истории значений модели.
 *
 * Пример:
 * <code>
 * $this->widget('application.zii.widgets.grid.MyGridHistoriableView', array(
 *     'modelName' => 'Histories',
 *     'fk' => $model->id,
 *     'model' => 'Contact',
 *     'attribute'=>'name'
 * ));
 * </code>
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyGridHistoriableModelView extends CGridView
{
    /**
     * Шаблон по которому будет строиться грид.
     *
     * @var string
     */
    public $template = '{items}{pager}';

    /**
     * Название модели.
     *
     * @var string
     */
    public $modelName;

    /**
     * Значение внешнего ключа.
     *
     * @var integer
     */
    public $fk;

    /**
     * Название модели, историю кот. отображаем.
     *
     * @var string
     */
    public $model;

    /**
     * Аттрибуты для отображение.
     *
     * @var array
     */
    public $attributes;

    /**
     * Настройки пагинатора
     *
     * @var array
     */
    public $pager = array('class' => 'MyLinkPager');

    /**
     * Включена ли пагинация
     *
     * @var boolean
     */
    public $enablePagination = true;

    /**
     * Инициализация.
     */
    public function init()
    {
        $basePath            = dirname(__FILE__) . '/assets/' . get_class($this);
        $this->baseScriptUrl = Yii::app()->getAssetManager()->publish($basePath);

        $criteria            = new CDbCriteria;
        $criteria->addCondition('fk_id='.$this->fk);
        $criteria->addCondition("model='".$this->model."'");
        if (!empty($this->attributes)){
               $criteria->addInCondition('attribute', $this->attributes);
        }
        $criteria->order = 't.id DESC';

        $this->dataProvider = new CActiveDataProvider($this->modelName, array('criteria' => $criteria));
        parent::init();
    }

    /**
     * Инициализация колонок.
     */
    public function initColumns()
    {

        $this->columns = array(
            array(
                'name'  => 'attribute',
                'class' => 'MyGridHistoriableDataColumn',
                'value' => 'MyActiveRecord::attributeLabel($data->model, $data->attribute)',
            ),
            array(
                'name'  => 'old_value',
                'class' => 'MyGridHistoriableDataColumn',
            ),
            array(
                'name'  => 'new_value',
                'class' => 'MyGridHistoriableDataColumn',
            ),
             array(
                'name'  => 'created_at',
                 'class' => 'MyGridHistoriableDataColumn',
                'htmlOptions' => array( 'style' => 'text-align:center'),
            ),
             array(
                'name'  => 'staff_id',
                'class' => 'MyGridHistoriableDataColumn',
                'htmlOptions' => array( 'style' => 'text-align:center'),
                'value' => '$data->staff',
            ),
        );

        $id = $this->getId();

        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = array(
                    'name'  => $column,
                    'class' => 'CDataColumn',
                );
            }

            $column = Yii::createComponent($column, $this);

            if ($column->id === null) {
                $column->id = $id . '_c' . $i;
            }

            $this->columns[$i] = $column;
        }

        foreach ($this->columns as $column) {
            $column->init();
        }
    }

    /**
     * Производится отрисовка нижней части datagrid
     */
    public function renderBottom()
    {
        echo '<table class="grid-bottom" width="100%"><tr><td>';
        $this->renderPager();
        echo '</td><td>';
        $this->renderSummary();
        echo '</td></tr></table>';
    }
}
