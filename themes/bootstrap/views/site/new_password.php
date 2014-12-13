<?php
/* @var $this SiteController */
/* @var $model ForgotPasswordForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - New Password';
$this->breadcrumbs=array(
	'New Password',
);
?>

<div class="container new-password">
    <div class="row ">
        <div class="center span4 well">
            <legend>Create New Password</legend>
            <?php
                $this->widget('bootstrap.widgets.TbAlert', array(
                    'block'=>false, // display a larger alert block?
                    'fade'=>true, // use transitions?
                    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed textFieldRow
                ));
            ?>

            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'newPpassword-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' => array(
                    'class' => 'input85',
                ),
            )); ?>
            <div>
                <?php echo $form->passwordFieldRow($model, 'new_password', array('size' => 60, 'prepend' => '<i class="icon icon-asterisk"></i>')); ?>
            </div>
            <div>
            <?php echo $form->passwordFieldRow($model, 'new_password_repeat', array('size' => 60, 'prepend' => '<i class="icon icon-asterisk"></i>')); ?>
            </div>
            <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Save',
                    'block'=>true,
                )); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!-- new-password -->
