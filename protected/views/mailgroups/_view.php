<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailgroup_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mailgroup_id),array('view','id'=>$data->mailgroup_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailgroup_name')); ?>:</b>
	<?php echo CHtml::encode($data->mailgroup_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_on')); ?>:</b>
	<?php echo CHtml::encode($data->created_on); ?>
	<br />


</div>