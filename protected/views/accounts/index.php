<?php
$this->breadcrumbs=array(
	'Accounts'
);

$this->menu=array(
	array('label'=>'List Accounts','url'=>array('index')),
	array('label'=>'Create Accounts','url'=>array('create')),
	array('label'=>'Manage Accounts','url'=>array('admin')),
);

?>
<h4>Account Index</h4>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'accounts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'address',
		'is_active',
		'owner_id',
		'created_time',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
