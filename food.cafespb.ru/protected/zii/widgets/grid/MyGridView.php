<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.web.widgets.pagers.MyLinkPager');
Yii::import('application.zii.widgets.grid.*');
/**
 * Класс для нашего GridView
 *
 * @package    system
 * @subpackage widgets
 * @author     Dmitriy Neshin
 */
class MyGridView extends CGridView
{
    /**
     * Показывать ли таблицу, когда нет значений
     *
     * @var boolean
     */
    public $showTableOnEmpty = false;

    /**
     * Навешивать ли ajax
     *
     * @var boolean
     */
    public $ajaxUpdate = false;

    /**
     * Количество выбранных строк
     *
     * @var integer
     */
    public $selectableRows = 1e10;

    /**
     * Включить ли сортировку
     *
     * @var boolean
     */
  // public $enableSorting = true;

    /**
     * Включена ли пагинация
     *
     * @var boolean
     */
    public $enablePagination = true;

    /**
     * Настройки пагинатора
     *
     * @var array
     */
    public $pager = array('class' => 'MyLinkPager');

    /**
     * Текст пагинатора
     *
     * @var string
     */
    public $summaryText = '{start}&mdash;{end} из {count}';

    /**
     * Шаблон вывода элементов datagrid
     *
     * @var string
     */
    public $template = '{items}{actions}{preview}{bottom}';

    /**
     * Список действий, навешенных на datagrid
     *
     * @var array
     */
    public $actions = array();

    /**
     * Название столбца для группировки
     *
     * @var string
     */
    public $groupBy;

    /**
     * Значение столбца для группировки
     *
     * @var string
     */
    public $groupByValue;

    /**
     * id выбранного элемента
     *
     * @var integer
     */
    public $selectedId;

    /**
     * url для предпросмотра
     *
     * @var string
     */
    public $previewUrl;

    /**
     * Показывать ссылки. Пока только "создать".
     *
     * @var boolean
     */
    public $showMenuLinks;

    /**
     * Ссылка для добавления (при использовании showMenuLinks).
     *
     * @var string
     */
    public $showMenuLinksAddUrl;

    /**
     * Последнее значение колонки для группировки
     *
     * @var string
     */
    protected $_lastGroupBy;

    /**
     * Класс стиля для грида.
     *
     * @var string
     */
    protected $_gridViewClass = 'grid-view';

    public $model = null;

    /**
     * Инициализация
     */
    public function init()
    {
        $basePath = dirname(__FILE__) . '/assets/' . get_class($this);
        $this->baseScriptUrl = Yii::app()->getAssetManager()->publish($basePath);

        if (!isset($this->htmlOptions['class']) || empty($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = $this->_gridViewClass;
        }

        if (!empty($this->htmlOptions['class']) && !strstr($this->htmlOptions['class'], $this->_gridViewClass)) {
            $this->htmlOptions['class'] .= ' ' . $this->_gridViewClass;
        }

        if (!empty($this->previewUrl)) {
            $this->selectableRows = 1;
            $this->selectionChanged = "function() {
                var selectedPk = $.fn.yiiGridView.getSelection('" . $this->id . "');
                showChoosenPreview(selectedPk);
            }";

            $scriptText = "
            function showChoosenPreview(selectedPk) {
                var chooseElement = $('." . $this->_gridViewClass
                          . " div.grid-preview div.choose-element');
                var previewResponse = $('." . $this->_gridViewClass
                          . " div.grid-preview div.grid-preview-response');

                previewResponse.css('opacity',0.3);
                chooseElement.show();
                chooseElement.html('<img  src=\"" . Yii::app()->baseUrl
                          . "/images/rows-preloader.gif\"/>');
                if (selectedPk != '') {
                    $.ajax({
                        type: 'GET',
                        url: '" . $this->previewUrl . "',
                        data: 'id=' + selectedPk,
                        success: function(data) {
                            chooseElement.hide();
                            previewResponse.css('opacity',1);
                            previewResponse.html(data).show();
                        }
                    });
                } else {
                    previewResponse.hide();
                    chooseElement.show();
                }
            }";

            Yii::app()->getClientScript()->registerScript('selected-row', $scriptText);
        }

        if (!empty($this->selectedId)) {
            $selectedFieldsScript = "
                $('#" . $this->getId() . " > div.keys > span').each(function(k, v) {
                    if (v.textContent == "
                                    . $this->selectedId . ") {
                        $('#"
                                    . $this->getId() . " tr:eq(' + (k+1) + ')').addClass('selected');
                        showChoosenPreview(" . $this->selectedId . ');
                        return;
                    }
                });
            ';
            Yii::app()->getClientScript()->registerScript('selected-fields', $selectedFieldsScript);
        }

        if (Yii::app()->getRequest()->isAjaxRequest) {
            $this->ajaxUpdate = null;
        }

        parent::init();
    }

    /**
     * Инициализация колонок.
     *
     * Конкретно в классе производится настройка ширины дефолтных колонок
     */
    protected function initColumns()
    {
        if ($this->dataProvider instanceof CArrayDataProvider && $this->model !== null) {
            foreach ($this->columns as $i => $column) {
                if (is_string($column) || is_array($column) && isset($column['name']) && !isset($column['header'])) {
                    if (is_string($column)) {
                        $column = array('name' => $column);
                    }

                    $name = $column['name'];
                    $column['header'] = $this->model->getAttributeLabel($name);
                    $this->columns[$i] = $column;
                }
            }
        }

        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $options = array();
                switch ($column) {
                    case 'id':
                        $options = array('headerHtmlOptions' => array('width' => 20));
                        break;

                    case 'created_at':
                    case 'updated_at':
                        $options = array('headerHtmlOptions' => array('width' => 150));
                        break;
                }

                $column = CMap::mergeArray(array('name' => $column), $options);
                $this->columns[$i] = $column;
            }
        }

        parent::initColumns();
    }

    /**
     * Производится отрисовка строки таблицы
     *
     * @param array $row Массив с данными строки таблицы
     */
    public function renderTableRow($row)
    {
        if (isset($this->groupBy)) {
            $data = $this->dataProvider->data[$row];
            $groupBy = $this->groupBy;
            if (!isset($this->_lastGroupBy) || $this->_lastGroupBy != $data->$groupBy) {
                echo '<tr class="even">';
                echo '<td colspan="' . count($this->columns) . '"><div class="group">';
                $groupByText = $this->evaluateExpression($this->groupByValue, array('data' => $data));
                $linkParams = array(
                    'products/admin',
                    'Products[group_id]' => $data->group_id
                );
                echo CHtml::link($groupByText, $linkParams);
                echo '</div></td>';
                echo '</tr>';
                $this->_lastGroupBy = $data->$groupBy;
            }
        }
        $trId = '';
        if ($this->rowCssClassExpression !== null) {
            $data = $this->dataProvider->data[$row];
            if (isset($data->id)) {
                $trId = ' id="tr_' . $data->id . '" ';
            }

            echo '<tr class="' . $this->evaluateExpression($this->rowCssClassExpression, array('row' => $row, 'data' => $data)) . '" ' . $trId . '>';
        }
        else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0) {
            $data = $this->dataProvider->data[$row];
            if (isset($data->id)) {
                $trId = ' id="tr_' . $data->id . '" ';
            }
            echo '<tr class="' . $this->rowCssClass[$row % $n] . '" ' . $trId . '>';
        } else
            echo '<tr>';
        foreach ($this->columns as $column)
            $column->renderDataCell($row);
        echo "</tr>\n";
    }

    /**
     * Производится отрисовка кнопок для действий над таблицей
     */
    public function renderActions()
    {
        if ($this->dataProvider->getItemCount() > 0) {
            $checkBoxColumn = null;
            foreach ($this->columns as $column) {
                if ($column instanceof MyCheckBoxColumn) {
                    $checkBoxColumn = $column;
                    break;
                }
            }

            if ($checkBoxColumn && !empty($this->actions)) {
                echo CHtml::form('', 'post', array('id' => 'form-actions'));
                echo '<div id="keys-actions" class="hidden2"></div>';
                echo '<table class="grid-actions" width="100%">';
                echo '<tr>';
                echo '<td>';
                echo 'С выделенными: ';
                echo CHtml::dropDownList('action', null, $this->actions, array('prompt' => '---'));
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                echo CHtml::endForm();
                $id = $this->id;
                $fieldId = $checkBoxColumn->id;

                $scriptText = "
                    $('#action').bind('change', function() {
                        if ($(this).val() != '') {
                            var keysActions = $('#keys-actions');
                            var formActions = $('#form-actions');
                            var selectedKeys = $.fn.yiiGridView.getChecked('$id', '$fieldId');

                            if(selectedKeys.length > 0) {
                                keysActions.html('');
                                $.each(selectedKeys, function(k, v) {
                                    keysActions.append('<input type=\"hidden\" name=\"keys[]\" value=\"' + v + '\" />');
                                });
                                formActions.get(0).setAttribute('action', APP.baseRequestUrl + $(this).val());
                                formActions.submit();
                            } else {
                                $('#action option:first').attr('selected','selected');
                            }
                        }
                    });
                ";

                Yii::app()->getClientScript()->registerScript('change-action', $scriptText);
            }
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

    /**
     * Производится отрисовка предпросмотра
     */
    public function renderPreview()
    {
        if (!empty($this->previewUrl)) {
            echo '<div class="grid-preview-wrapper">';
            echo '  <div class="grid-preview">';
            echo '    <div class="choose-element">Выберите элемент из списка</div>';
            echo '    <div class="grid-preview-response" style="display:none;"></div>';
            echo '  </div>';
            echo '</div>';
        }
    }

    public function renderItems()
    {
        if (isset($this->showMenuLinksAddUrl)) {
            echo '<div class="content-middle-header">';
            echo '<table width="100%">';
            echo '<tr>';
            echo '<td>';
            echo '<div class="content-actions">';
            $this->beginWidget('application.zii.widgets.MyPortlet');
            $this->widget('application.zii.widgets.MyMenu', array(
                                                                 'items' => array(
                                                                     array(
                                                                         'label' => Yii::t('application', 'Add'),
                                                                         'url' => $this->showMenuLinksAddUrl,
                                                                         'itemOptions' => array('class' => 'create')
                                                                     ),
                                                                 ),
                                                            ));
            $this->endWidget();
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
        }

        parent::renderItems();
    }
}
