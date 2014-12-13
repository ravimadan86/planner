<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Custom Fields',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'mailgroups-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'class' => 'well',
    ),
)); ?>

<?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'&times;',
    ));
?>

    <h4>Mailgroups : Add Custom Fields</h4>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
    
    <div>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'custom_field_name',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'custom_field_tag',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->dropDownListRow($model,'custom_field_type',Yii::app()->params['custom_fields_type'], array('class'=>'span5','maxlength'=>255));?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'custom_field_size',array('class'=>'span5','maxlength'=>255)); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'custom_field_order',array('class'=>'span5')); ?>
    </div>
    
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
