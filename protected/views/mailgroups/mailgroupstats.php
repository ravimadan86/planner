<?php 
$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	'Statistics',
);

$this->menu=array(
	array('label'=>'List Mailgroups','url'=>array('index')),
);

?>
<?php

$statistics = $paramArray['statArray'];
$totalCount = $paramArray['totalCount'];

foreach($statistics as $key=>$value)
{
    $dataStat[] = array(
        'value' => (int) $value,
        'color' => 'rgba('.mt_rand(0,255).','.mt_rand(0,255).','.mt_rand(0,255).','.mt_rand(0,255).')',
        'label' => $key,
    );
}

?>

<div class='well'>
    <h4>Mail Group Statistics</h4>
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'type'=>'striped bordered condensed',
        'data'=>array_merge($totalCount, $paramArray['statArray']),
        'attributes'=>array(
            array('name'=>'totalCount', 'label'=>'Total Members in Mailgroup',),
            array('name'=>'Subscribed', 'label'=>'Members Subscribed'),
            array('name'=>'Unsubscribed', 'label'=>'Members UnSubscribed'),
            array('name'=>'Bounced', 'label'=>'Members Bounced'),
        ),
        'htmlOptions'=> array(
            'style'=>'width: 100%',
        ),
    )); ?>
</div>
<div class="well" align="center">
    <h4>Mailgroup Graphical Statistics</h4>
    
    <div > 
        <?php 
            $this->widget(
            'chartjs.widgets.ChPie', 
            array(
                'height' => 200,
                'htmlOptions' => array('class'=>'well'),
                'drawLabels' => true,
                'datasets' => $dataStat,
                'options' => array()
            )
        ); 
        ?>
        
    </div>
</div>
