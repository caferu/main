<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.zii.widgets.grid.MyGridHistoriableDataColumn');
/**
 * Грид для отображения истории значений модели.
 *
 * Пример:
 * <code>
 * $this->widget('application.zii.widgets.grid.MyGridHistoriableView', array(
 *     'modelName' => 'ObjectHistories',
 *     'fk' => $model->object->id,
 * ));
 * </code>
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyGridHistoriableView extends CGridView
{
    /**
     * Шаблон по которому будет строиться грид.
     *
     * @var string
     */
    public $template = '{items}';

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
     * Инициализация.
     */
    public function init()
    {
        $basePath            = dirname(__FILE__) . '/assets/' . get_class($this);
        $this->baseScriptUrl = Yii::app()->getAssetManager()->publish($basePath);

        $criteria            = new CDbCriteria;
        $criteria->condition = 'fk_id = :fk';
        $criteria->params    = array('fk' => $this->fk);

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
            'created_at',
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
}
