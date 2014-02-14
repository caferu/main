<div class="form" style="padding-top:30px; ">
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
)); ?>

    <div class="row">
    <?php echo $form->textField($model, 'username', array('class' => 'login_form')); ?>
    </div>

    <div class="row">
    <?php echo $form->textField($model, 'password', array('class' => 'login_form')); ?>

    </div>


    <div class="buttons">
    <?php echo CHtml::imageButton('/images/enter.gif', array('style' => 'cursor:pointer; border:none; height:16px')); ?>
    </div>
    <? if (isset($_POST['LoginForm'])){?>
    <div class="err_div"><?php echo $form->error($model,'username');  echo $form->error($model,'password'); ?></div>
    <?}?>
        <div  class="login_anons">

        </div>
    <div class="yell phone">
        
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->
