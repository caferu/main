<?php
/**
 * Класс колонки кнопок для грида.
 *
 * @package    System
 * @subpackage Grid
 * @author     Dmitriy Neshin <d.neshin@naibecar.com>
 */
class MyButtonColumn extends CButtonColumn
{
    public $otherParams = array();

    /**
     * @var string the label for the update button. Defaults to "Update".
     *             Note that the label will not be HTML-encoded when rendering.
     */
    public $copyButtonLabel = null;

    /**
     * @var string the image URL for the update button. If not set, an integrated image will be used.
     *             You may set this property to be false to render a text link instead.
     */
    public $copyButtonImageUrl = null;

    /**
     * @var array the HTML options for the view button tag.
     */
    public $copyButtonOptions = array('class' => 'copy');

    public $controller;
    public $copyButtonUrl = null;

    /**
     * Initializes the default buttons (view, update and delete).
     */
    protected function initDefaultButtons()
    {
        if ($this->copyButtonLabel === null) $this->copyButtonLabel = Yii::t('zii', 'Copy');
        if ($this->copyButtonImageUrl === null) $this->copyButtonImageUrl = '/images/fugue/documents.png';
        $this->buttons['copy']    = array(
            'label'    => $this->copyButtonLabel,
            'url'      => $this->copyButtonUrl,
            'imageUrl' => $this->copyButtonImageUrl,
            'options'  => $this->copyButtonOptions,
        );

        parent::initDefaultButtons();
    }

    /**
     * Инициализация.
     *
     * Смотрит какие существуют экшены у контроллера, и, в зависимости от этого, рисует только те иконки, по которым
     * доступен экшен.
     */
    public function init()
    {
        $isArray = $this->grid->dataProvider instanceof CArrayDataProvider;
        if ($isArray) {
            $idCode = '$data[\'id\']';
        } else {
            $idCode = '$data->primaryKey';
        }

        $otherParamsString = '';
        $controller        = Yii::app()->getController();
        if (!empty($this->otherParams)) {
            $params = $controller->getActionParams();
            foreach ($this->otherParams as $otherParam) {
                if (!empty($params[$otherParam])) {
                    if ($isArray) {
                        $paramValueCode = '$data[\'' . $otherParam . '\']';
                    } else {
                        $paramValueCode = '$data->' . $otherParam;
                    }

                    $otherParamsString .= ',\'' . $otherParam . '\' => ' . $paramValueCode;
                }
            }
        }

        $template = array();
        $module   = $controller->getModule()->id;

        if (!isset($this->controller)) {
            $controllerClassName = get_class(Yii::app()->controller);
        } else {
            Yii::import('application.modules.' . $module . '.controllers.' . $this->controller . 'Controller');
            $controllerClassName = $this->controller . 'Controller';
        }

        $moduleControllerUrl = $module . '/' . lcfirst(preg_replace('/Controller$/', '', $controllerClassName));

        $viewButtonAction      = '//' . $moduleControllerUrl . '/view';
        $this->viewButtonUrl   = 'Yii::app()->controller->createUrl("' . $viewButtonAction
                               . '",array("id"=>' . $idCode . $otherParamsString . '))';
        $updateButtonAction    = '//' . $moduleControllerUrl . '/update';
        $this->updateButtonUrl = 'Yii::app()->controller->createUrl("' . $updateButtonAction
                               . '",array("id"=>' . $idCode . $otherParamsString . '))';
        $deleteButtonAction    = '//' . $moduleControllerUrl . '/delete';
        $this->deleteButtonUrl = 'Yii::app()->controller->createUrl("' . $deleteButtonAction
                             . '",array("id"=>' . $idCode . $otherParamsString . '))';

        $copyButtonAction    = '//' . $moduleControllerUrl . '/copy';
        $this->copyButtonUrl = 'Yii::app()->controller->createUrl("' . $copyButtonAction
                           . '",array("id"=>' . $idCode . $otherParamsString . '))';

        $controllerActions = MyReflection::getClassActions($controllerClassName);

        if (in_array('copy', $controllerActions)) {
            $template[] = '{copy}';
        }

        if (in_array('view', $controllerActions)) {
            $template[] = '{view}';
        }

        if (in_array('update', $controllerActions)) {
            $template[] = '{update}';
        }

        if (in_array('delete', $controllerActions)) {
            $template[] = '{delete}';
        }

        $this->template = implode(' ', $template);

        parent::init();
    }
}
