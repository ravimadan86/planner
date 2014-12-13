<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Clone Mailgroups',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'mailgroups-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name' => 'person_custom_name',
            'value' => '$data->person->person_first_name." ".$data->person->person_last_name',
            'htmlOptions' =>array (
                'class' => 'span6',
            ),
        ),
        array(
            'name' => 'is_subscribed',
            'value' => '($data->is_subscribed == 0) ? "Unsubscribed" : "Subscribed"',
            'visible' => array('0'=>'Unsubscribed', '1'=>'Subscribed'),
            'filter'=>array('0'=>'Unsubscribed', '1'=>'Subscribed'),
            'htmlOptions' =>array (
                'class' => 'span2',
            ),
        ),
        array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{subscribeperson} {person}',
            'buttons' => array(
                'subscribeperson' => array(
                    'label' => '',
                    'url' => '"javascript:markSubscribeUnsubscribe(".$data->mailgroup_id.",".$data->person_id.",".(int) !$data->is_subscribed.");"', 
                    'options' => array(
                        'class'=> 'icon-star',
                        'title' => 'Subscribe/Unsubscribe',
                    ),
                ),
                'person' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("mailgroups/personcustomfieldsedit", array("id"=>$data->mailgroup_id, "person_id"=> $data->person_id ))', 
                    'options' => array(
                        'class'=> 'icon-pencil',
                        'title' => 'Edit Mailgroup Person',
                    ),
                ),
            ),
		),
        
	),
)); ?>