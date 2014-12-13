<?php
$templates = $paramArray['templates'];
$notificationType = $paramArray['notificationType'];
$showSubmitButton = $paramArray['showSubmitButton'];
$showDeleteButton = $paramArray['showDeleteButton'];
$showTemplateTitle = $paramArray['showTemplateTitle'];
$mailGroupList = $paramArray['mailGroupList'];
if ($showSubmitButton)
{
    $sendButtonLabel = $paramArray['sendButtonLabel'];
    $sendButtonId = $paramArray['sendButtonId'];
}
$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'notification-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class' => 'well well-custom'),
));
?>
<div class="form-fields pull-left">
    <div>
        <?php echo CHtml::hiddenField('NotificationTemplates[type]', $notificationType); ?>
        <?php echo CHtml::dropDownList('NotificationTemplates[id]', array('new'), $templates); ?>
    </div>
    <div>
         <?php
        if ( $notificationType == 'email' )
        {
            echo CHtml::dropDownList('NotificationTemplates[mailgroup]', '', $mailGroupList);
        }
        else
        {
            echo CHtml::hiddenField('NotificationTemplates[subject]', '-');
        }
        ?>
    </div>
    <div>
        <?php
        if ( $notificationType == 'email' )
        {
            echo CHtml::textField('NotificationTemplates[from]', '', array('placeholder' => 'Sender\'s Email : '));
        }
        else
        {
            echo CHtml::hiddenField('NotificationTemplates[from]', '-');
        }
        ?>
    </div>

    <div>
         <?php
        if ( $notificationType == 'email' )
        {
            echo CHtml::textField('NotificationTemplates[senders_name]', '', array('placeholder' => 'Sender\'s Name : '));
        }
        else
        {
            echo CHtml::hiddenField('NotificationTemplates[senders_name]', '-');
        }
        ?>
    </div>

    <div>
         <?php
        if ( $notificationType == 'email' )
        {
            echo CHtml::textField('NotificationTemplates[subject]', '', array('placeholder' => 'Subject : '));
        }
        else
        {
            echo CHtml::hiddenField('NotificationTemplates[subject]', '-');
        }
        ?>
    </div>

    <div>
        <?php
        if ( $notificationType == 'email' )
        {
            $this->widget('ext.tinymce.TinyMce', array(
                'name' => 'NotificationTemplates[content]',
                'htmlOptions' => array(
                    'id' => 'notificationContent',
                    'class' => 'span5',
                    'rows' => 15,
                    'cols' => 10,
                ),
            ));
        }
        else
        {
            echo CHtml::textArea('NotificationTemplates[content]', '', array(
                'id' => 'notificationContent',
                'class' => 'notificationContent notificationContentTextArea',
                
            ));
        }
        ?>
    </div>
    <div class="btn-toolbar notification-template-actions">

        <?php
            if ($showTemplateTitle)
            {
                echo CHtml::textField('NotificationTemplates[title]', '', array('class' => 'input-small','placeholder' => 'Template Name'));
            }
            else
            {
                echo CHtml::hiddenField('NotificationTemplates[title]', '');
            }
        ?>

        <?php

            $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Save Template',
                'type'=>'primary',
                'htmlOptions' => array(
                    'id' => 'saveTemplate',
                ),
            ));
            if ( $showDeleteButton )
            {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Delete',
                    'type' => 'danger',
                    'htmlOptions' => array(
                        'id' => 'deleteTemplate',
                    ),
                ));
            }
            if ( $showSubmitButton )
            {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => $sendButtonLabel,
                    'type' => 'success',
                    'htmlOptions' => array(
                        'id' => $sendButtonId,
                    ),
                ));
            }
        
        ?>
    </div>
</div>
<div class="pull-right notification-form-hints">
    <p style="color: red;">
        You can use following tags while working with template : -
            <br>{{FirstName}}
            <br>{{LastName}}
            <br>{{Email}}
            <br>{{Mobile}}
            <br>{{Address1}}
            <br>{{Address2}}
            <br>{{City}}
            <br>{{State}}
            <br>{{Country}}
            <br>{{ZipCode}}
    </p>
    <p>
        <span id="custom_field_tags">
        </span>
    </p>
</div>
<?php $this->endWidget(); ?>