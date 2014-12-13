<?php
$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create User','url'=>array('create'),  'visible' => Yii::app()->user->checkAccess('user.create')),
	array('label'=>'Manage User','url'=>array('admin'),  'visible' => Yii::app()->user->checkAccess('user.admin')),
);
?>

<h1>Users</h1>

<?php /*$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));*/ ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/*'user_id',*/
		'role',
		'email',
		/*'password',*/
		'first_name',
		'last_name',
		/*
		'address_line_1',
		'address_line_2',
        */
		'city',
		'state',
		'country',
		/*'zip_code',*/
		'company_name',
		array('name'=>'is_active',
            'value' => '($data->is_active == 0) ? "Inactive" : "Active"',
            'visible' => array('0'=>'Inactive', '1'=>'Active'),
            'filter'=>array('0'=>'Inactive', '1'=>'Active'),
            'htmlOptions' => array('style'=>'width:80px'),
        ),
		/*'last_modified_time',
		'registration_token',
		'forgot_token',
		'created_on',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),*/
	),
)); ?>