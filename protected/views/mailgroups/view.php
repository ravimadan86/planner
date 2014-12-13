<?php
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	$model->mailgroup_id,
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
	array('label'=>'Create Mailgroups','url'=>array('create')),
	array('label'=>'Update Mailgroups','url'=>array('update','id'=>$model->mailgroup_id)),
	array('label'=>'Delete Mailgroups','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->mailgroup_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mailgroups','url'=>array('admin')),
);
?>

<h1>View Mailgroups #<?php echo $model->mailgroup_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'mailgroup_id',
		'user_id',
		'mailgroup_name',
		'created_on',
	),
)); ?>
