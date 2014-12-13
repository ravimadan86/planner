<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index'), 'visible' => Yii::app()->user->checkAccess('user.index')),
	array('label'=>'Create User','url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('user.create')),
	array('label'=>'View User','url'=>array('view','id'=>$model->user_id), 'visible' => Yii::app()->user->checkAccess('user.view')),
	array('label'=>'Manage User','url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('user.admin')),
);
?>

<h1>Update User: <?php echo $model->first_name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>