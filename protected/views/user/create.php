<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index'), 'visible' => Yii::app()->user->checkAccess('user.index')),
	array('label'=>'Manage User','url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('user.admin')),
);
?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>