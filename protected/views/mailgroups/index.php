<?php
$this->breadcrumbs=array(
	'Mailgroups',
);

$this->menu=array(
	array('label'=>'Create Mailgroups','url'=>array('create')),
	array('label'=>'Manage Mailgroups','url'=>array('admin')),
);

$mailGroupModel = $paramArray['mailGroupModel'];
$model = $paramArray['model'];
?>

<h1>Mailgroups</h1>

<div class="well">
    <?php echo $this->renderPartial('_mailgroup_create_form', array('model'=>$mailGroupModel)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'mailgroups-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/*'mailgroup_id',*/
		/*'user_id',*/
		array(
            'name' => 'mailgroup_name',
            'htmlOptions' =>array(
                'class' => 'span6',
            ),
        ),
		array(
            'name'=>'created_on',
            'htmlOptions' =>array(
                'class' => 'span3',
            ),
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete} {addmember} {importmember} {clonemailgroup} {statistics} {sendsubscribemail} {viewpeople} {addcustomfields}',
            'buttons' => array(
                'addmember' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/addmembers", array("id"=>$data->mailgroup_id))',
                    'options' => array(
                        'class'=> 'icon-user',
                        'title' => 'Add Member',
                    ),
                    
                ),
                'importmember' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/bulkimportmailgroups", array("id"=>$data->mailgroup_id))',
                    'options' => array(
                        'class'=> 'icon-file',
                        'title' => 'Import Bulk Member via CSV',
                    ),
                ),
                'clonemailgroup' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/clonemailgroups", array("id"=>$data->mailgroup_id))',
                    'options' => array(
                        'class'=> 'icon-repeat',
                        'title' => 'Clone Mailgroup',
                    ),
                ),
                'statistics' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/mailgroupstats", array("id"=>$data->mailgroup_id))',
                    'options' => array(
                        'class'=> 'icon-bookmark',
                        'title' => 'Mailgroup Statistics',
                    ),
                ),
                'sendsubscribemail' => array(
                    'label' => '',
                    'url' => '"javascript:sendSubscriptionMail(".$data->mailgroup_id.");"', 
                    'options' => array(
                        'class'=> 'icon-envelope',
                        'title' => 'Send Subscription Email',
                    ),
                ),
                'viewpeople' => array(
                    'label'=>'View Members',
                    'imageUrl'=> Yii::app()->request->baseUrl."/images/icons/friends2.png",
                    'url'=>'Yii::app()->createUrl("mailgroups/viewmembers", array("id"=>$data->mailgroup_id))',
                ),
                'addcustomfields' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/addcustomfields", array("id"=>$data->mailgroup_id))',
                    'options' => array(
                        'class'=> 'icon-tag',
                        'title' => 'Add Mailgroup Custom Fields',
                    ),
                ),
            ),
            
            'htmlOptions' => array(
                'class' => 'span3',
            ),
		),
	),
)); ?>

