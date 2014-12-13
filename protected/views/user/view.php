<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index'), 'visible' => Yii::app()->user->checkAccess('user.index')),
	array('label'=>'Create User','url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('user.create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->user_id), 'visible' => Yii::app()->user->checkAccess('user.update')),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?'), 'visible' => Yii::app()->user->checkAccess('user.delete')),
	array('label'=>'Manage User','url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('user.admin')),
);
?>

<h1>View User: <?php echo $model->first_name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		/*'user_id',*/
		'role',
		'email',
		/*'password',*/
		'first_name',
		'last_name',
		'address_line_1',
		'address_line_2',
		'city',
		'state',
		'country',
		'zip_code',
		'company_name',
		array('name'=>'is_active',
            'value' => $model->is_active == 0 ? 'Inactive' : 'Active',
        ),
		/*'last_modified_time',
		'registration_token',
		'forgot_token',*/
		'created_on',
	),
)); ?>
