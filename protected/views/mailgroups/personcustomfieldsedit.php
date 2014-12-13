<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Edit Member',
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

    <h4>Mailgroups : Edit Member</h4>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
    <div>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_first_name',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_last_name',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->uneditableRow($model,'person_email',array('class'=>'span5','maxlength'=>255)); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_phone',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_address_line1',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_address_line2',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_city',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_state',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_country',array('class'=>'span5')); ?>
    </div>
    <div>
        <?php echo $form->textFieldRow($model,'person_zipcode',array('class'=>'span5')); ?>
    </div>
    
    <!-- <h4>Custom Fields (Extra Fields) :-</h4> -->
    <?php 
        foreach($customFieldModel as $k=>$custom)
        {
            $personCustomValues = PersonCustomValues::model()->findByAttributes(array('custom_field_id'=>$custom->mailgroup_custom_id, 'mailgroup_id'=> $custom->mailgroup_id, 'person_id'=>$model->person_id));
            
            echo "<div>";
            echo "<label for='".$custom->custom_field_name."'>".$custom->custom_field_name."</label>";
            echo CHtml::textField('MailgroupCustomFields['.$custom->mailgroup_custom_id.']', $personCustomValues->person_custom_field_value, array('maxlength'=>$custom->custom_field_size, 'placeholder' => $custom->custom_field_name, 'class'=>'span5'));
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
