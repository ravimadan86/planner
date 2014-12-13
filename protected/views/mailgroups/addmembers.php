<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Add Members',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

$model = $paramArray['model'];
$customFieldModel = $paramArray['customFieldModel'];
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

    <h4>Mailgroups : Add Members</h4>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'person_first_name',array('class'=>'span5','placeholder' => 'First Name')); ?>
    
	<?php echo $form->textFieldRow($model,'person_last_name',array('class'=>'span5','placeholder' => 'Last Name')); ?>

	<?php echo $form->textFieldRow($model,'person_email',array('class'=>'span5','maxlength'=>255,'placeholder' => 'Email Id')); ?>
    
	<?php echo $form->textFieldRow($model,'person_phone',array('class'=>'span5','placeholder' => 'Phone No')); ?>
    
	<?php echo $form->textFieldRow($model,'person_address_line1',array('class'=>'span5','placeholder' => 'Address Line1')); ?>

	<?php echo $form->textFieldRow($model,'person_address_line2',array('class'=>'span5','placeholder' => 'Address Line2')); ?>

    <?php echo $form->textFieldRow($model,'person_city',array('class'=>'span5','placeholder' => 'City')); ?>
    
	<?php echo $form->textFieldRow($model,'person_state',array('class'=>'span5','placeholder' => 'State')); ?>

	<?php echo $form->textFieldRow($model,'person_country',array('class'=>'span5','placeholder' => 'Country')); ?>

	<?php echo $form->textFieldRow($model,'person_zipcode',array('class'=>'span5','placeholder' => 'Zip Code')); ?>
    
    <!-- <h4>Custom Fields (Extra Fields) :-</h4> -->
    <?php 
        foreach($customFieldModel as $k=>$custom)
        {
            echo "<div>";
            echo "<label for='".$custom->custom_field_name."'>".$custom->custom_field_name."</label>";
            echo CHtml::textField('MailgroupCustomFields['.$custom->mailgroup_custom_id.']', '', array('maxlength'=>$custom->custom_field_size, 'placeholder' => $custom->custom_field_name, 'class'=>'span5'));
            echo "</div>";
        }
    ?>
    <?php //echo $form->textFieldRow($model,'created_on',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
