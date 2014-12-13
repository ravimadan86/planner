<?php
/* @var $this NotificationsController */
$notificationType = $paramArray['notificationType'];

$this->breadcrumbs=array(
	'Notifications'=>array('/notifications'),
	'Email',
);

$this->renderPartial('_navigationBar');

?>

<h4>Send Email</h4>

<?php
    $this->renderPartial("_templatesEmailForm", array('paramArray' => $paramArray));
?>


<div class="clearfix"></div>

