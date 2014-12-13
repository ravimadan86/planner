<?php
/* @var $this NotificationsController */
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs',
    'stacked'=>false,
    'items'=>array(
        array('label'=>'SMS', 'url'=>  Yii::app()->createAbsoluteUrl("notifications/sms"), 'itemOptions'=>array('class' => 'nav-sms'), 'active' => ( $this->activeTab == 'sms' ) ? true : false ),
        array('label'=>'Email', 'url'=>  Yii::app()->createAbsoluteUrl("notifications/email"), 'itemOptions'=>array('class' => 'nav-email'), 'active' => ( $this->activeTab == 'email' ) ? true : false),
    ),
));
?>