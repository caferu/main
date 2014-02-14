<div class="form" style="width: 610px">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'demand-form',
                                                         'enableAjaxValidation' => false,
                                                    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

                   <table style="width:95%">
                       <tr>
                            <td nowrap colspan="2">№<?=$model->id?>. Дата и время заказа: <?=date('d.m.Y H:i', strtotime($model->created_at));?></td>
                        </tr>
                        <tr>
                            <td>Статус</td>
                            <td><?php echo $form->dropDownList($model, 'food_demand_status_id', CHtml::listData(FoodDemandStatuses::model()->findAll('status=1'), 'id', 'name'));?></td>
                        </tr>
                        <tr>
                            <td nowrap colspan="2">Комментарий менеджера Fasteda.ru</td>
                        </tr>
                         <tr>
                            <td colspan="2"><?php echo $form->textArea($model, 'manager_comment', array('style'=>'width:95%')); ?></td>
                        </tr>
                    </table>
    <div class="row buttons" style="text-align:center; width:95%">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('id'=>'subDemandBtn')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->