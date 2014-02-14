<div style="width:100%">
    <h1><?=$model->c_name?></h1>
    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'comments-form',
                                                         'enableAjaxValidation' => false,
                                                    ));
    ?>
    <table style="100%; margin-top: 10px">
        <tr>
            <td>
                <table id='busy_dates_tbl'>
                    <tr>
                        <td>Комментарий</td>
                        <td>Пользователь</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($comment, 't_comment', array('size' => 70)); ?>
                        </td>
                        <td></td>
                        <td>
                            <?php echo $form->hiddenField($comment, 'id_object');?>
                            <img src="/images/plus-button.png" alt="Добавить" id='add_bs_comment_btn'>
                        </td>
                    </tr><?php
if (!empty($comments)) {
                    ?>

                    <?php
                    $user = Yii::app()->user->getState('id_user');

                    foreach ($comments as $v) { ?>
                        <tr id='busy_dates_tr'>
                            <td><?=$v->t_comment?></td>
                            <td width="120px"><?=$v->Agent->c_name?></td>
                            <td width="20px" >
                              <?
                        if (Yii::app()->user->CF_STATUS == 1 || $user == $v['id_user']){?>
                                <img class="bd_del_button" src="/images/del.png" alt="" style="cursor: pointer"
                                                  onclick="deleteComment(<?=$v['id']?>)">
                            <?}?>
                                                  </td>
                        </tr>
                        <? }
                }?>

                </table>
</div>
<? $this->endWidget(); ?>


