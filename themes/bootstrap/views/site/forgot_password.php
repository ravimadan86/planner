<?php
/* @var $this SiteController */
/* @var $model ForgotPasswordForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Forgot Password';
$this->breadcrumbs=array(
	'Forgot Password',
);
?>

<div class="container forgot-password">
    <div class="row">
        <div class="center span4 well">
            <legend>Forgot Password</legend>
            <?php
                $this->widget('bootstrap.widgets.TbAlert', array(
                    'block'=>false, // display a larger alert block?
                    'fade'=>true, // use transitions?
                    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                ));
            ?>
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'forgot-password-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' =>array(
                    'class' => 'input85',
                ),
            )); ?>
            <div>
                <?php echo $form->textFieldRow($model,'email', array('size'=>60, 'prepend' => '@')); ?>
            </div>
            <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Submit',
                    'block'=>true,
                )); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!-- forgot-password -->