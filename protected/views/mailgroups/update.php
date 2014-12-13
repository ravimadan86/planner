<?php
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	$model->mailgroup_id=>array('view','id'=>$model->mailgroup_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
	array('label'=>'Create Mailgroups','url'=>array('create')),
	array('label'=>'View Mailgroups','url'=>array('view','id'=>$model->mailgroup_id)),
	array('label'=>'Manage Mailgroups','url'=>array('admin')),
);
?>

<h1>Update Mailgroups <?php echo $model->mailgroup_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>