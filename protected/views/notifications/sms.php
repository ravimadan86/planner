<?php
/* @var $this NotificationsController */

$this->breadcrumbs=array(
	'Notifications'=>array('/notifications'),
	'Sms',
);

$this->renderPartial('_navigationBar');

?>

<h4>Send SMS</h4>

<?php
    $this->renderPartial("_templatesSMSForm", array('paramArray' => $paramArray));
?>

<div class="clearfix"></div>

