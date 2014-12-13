<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Clone Mailgroups',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clonemailgroups-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'class' => 'well',
    ),
)); ?>

<?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>false,
        'fade'=>true,
        'closeText'=>'&times;',
    ));
?>
    
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
    <div class="alert in alert-block fade alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <ul>
            <li>Cloning copies all the Person available in the parent Mailgroup.</li>
            <li>Cloning marks all inherited persons as Subscribed in new Mailgroup.</li>
        </ul>
    </div>  

	<?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>
    
    <div>
        <?php echo $form->textFieldRow($model,'mailgroup_name', array('class'=>'span5','maxlength'=>255)); ?>
    </div>
    
    <div>
        <?php echo $form->textFieldRow($model,'newmailgroup',array('name'=> 'Mailgroups[newmailgroup]', 'id'=>'Mailgroups_newmailgroup', 'class'=>'span5','maxlength'=>255)); ?>
    </div>
    
    <?php //echo $form->textFieldRow($model,'created_on',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
