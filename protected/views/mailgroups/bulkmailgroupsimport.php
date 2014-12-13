<?php
/* @var $this UserController */
$errorArr = $paramArray['error'];
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Bulk Import via CSV',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

?>
<h4>Mailgroup : Import Persons via CSV</h4>
<?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>false,
        'fade'=>true,
        'closeText'=>'&times;',
    ));          
                              
?>
<?php
foreach($errorArr as $key => $value) 
    {   
?>
    <div class="alert in fade alert-warning">
        <a class="close" data-dismiss="alert">×</a>
        <div>
        <?php echo $value;?><br />   
        </div>
    </div>
<?php
}
?>
<div class="form">
    <?php $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
     'id'=>'csv-form',
     'enableAjaxValidation'=>false,
        'htmlOptions'=>array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )); ?>
    <div class="alert in alert-block fade alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <ul>
            <li>CSV file must contain column names in the first row.</li>
            <li>A record will be skipped if they have blank values for any of mandatory fields or they fails validation rules.</li>
            <li>person_first_name, person_last_name, person_email are mandatory fields</li>
            <li><strong>Column names should be in the following order : -</strong></li>
            <li>person_first_name, person_last_name, person_email, person_phone, person_address_line1, person_address_line2, person_city, person_state, person_country, person_zipcode</li>
        </ul>
    </div>
    
    <div>
        <?php echo CHtml::label('Upload File','csvFile'); ?>
        <?php
            echo CHtml::fileField('csvFile');
        ?>
    </div>
    <br />
<?php
echo CHtml::link('Click here', Yii::app()->createAbsoluteUrl("mailgroups/samplemailgroupsimport", array("download" =>'true'))).' to download sample csv file.';
?>
     <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>('Import'))); ?>
     </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->