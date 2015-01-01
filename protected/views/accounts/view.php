<?php
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Accounts','url'=>array('index')),
	array('label'=>'Create Accounts','url'=>array('create')),
	array('label'=>'Update Accounts','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Accounts','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accounts','url'=>array('admin')),
);
?>

<h4>View Accounts #<?php echo $model->id; ?></h4>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'is_active',
		'owner_id',
		'created_time',
	),
)); ?>
