<?php
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
	array('label'=>'Manage Mailgroups','url'=>array('admin')),
);
?>

<h1>Create Mailgroups</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>