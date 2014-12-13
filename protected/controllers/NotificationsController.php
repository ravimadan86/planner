<?php

class NotificationsController extends Controller
{
    // to make the tab in navigation bar as active
    public $activeTab = 'index';

    public function filters()
    {
        return array(
            array('auth.filters.AuthFilter'),
        );
    }

	public function actionEmail()
	{
        // to make the tab in navigation bar as active
        $this->activeTab = 'email';

        // urls for ajax requests
        Yii::app()->clientScript->registerScript('helpers', '
            Yii = {
                urls: {
                    saveTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/saveTemplate")).',
                    loadTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/loadTemplate")).',
                    deleteTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/deleteTemplate")).',
                    sendEmailUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/sendEmailNotification")).',
                    loadMailgroupTagsUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/loadMailgroupTagsUrl")).'
                }
            };
        ');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/notificationsController.js');

        // fetching all the active templates
        $templatesModel = fetchNotificationTemplates('email', "active");
        $templates = array();
        foreach ($templatesModel as $template)
        {
            $templates[$template->id] = $template->title;
        }
        // appending a new option at the end
        $templates['new'] = 'New';
        
        $mailGroupModel = getUserMailGroups();
        $mailGroupList = array();
        $mailGroupList[''] = 'Select Mailgroup';
        foreach($mailGroupModel as $mailgroup)
        {
            $mailGroupList[$mailgroup->mailgroup_id] = $mailgroup->mailgroup_name;
        }
        
        // fetching the user model
        $paramArray = array();
        $paramArray['model'] = $templatesModel;
        $paramArray['templates'] = $templates;
        $paramArray['mailGroupList'] = $mailGroupList;
        $paramArray['notificationType'] = $this->activeTab;
        $paramArray['showCheckBoxColumn'] = true;
        $paramArray['sendButtonLabel'] = 'Send Email';
        $paramArray['sendButtonId'] = 'sendEmail';
        $paramArray['showSubmitButton'] = true;
        $paramArray['showDeleteButton'] = true;
        // show the template title field change
        $paramArray['showTemplateTitle'] = true;
        
        
        $this->render('email', array(
            'paramArray' => $paramArray,
        ));
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSms()
	{
        // to make the tab in navigation bar as active
        $this->activeTab = 'sms';

        // urls for ajax requests
        Yii::app()->clientScript->registerScript('helpers', '
            Yii = {
                urls: {
                    saveTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/saveTemplate")).',
                    loadTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/loadTemplate")).',
                    deleteTemplateUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/deleteTemplate")).',
                    sendSmsUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/sendSmsNotification")).',
                    loadMailgroupTagsUrl : '.CJSON::encode(Yii::app()->createAbsoluteUrl("notificationTemplates/loadMailgroupTags")).'
                }
            };
        ');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/notificationsController.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/userController.js');

        // fetching all the active templates
        $templatesModel = fetchNotificationTemplates('sms', "active");
        $templates = array();
        foreach ($templatesModel as $template)
        {
            $templates[$template->id] = $template->title;
        }
        // appending a new option at the end
        $templates['new'] = 'New';

        
        $paramArray = array();
        $paramArray['templates'] = $templates;
        // show check boxes in user grid
        $paramArray['showCheckBoxColumn'] = true;
        $paramArray['notificationType'] = 'sms';
        $paramArray['sendButtonLabel'] = 'Send Sms';
        $paramArray['sendButtonId'] = 'sendSms';
        $paramArray['showSubmitButton'] = true;
        $paramArray['showDeleteButton'] = true;
        // show the template title field change
        $paramArray['showTemplateTitle'] = true;
		$this->render('sms', array(
            'paramArray' => $paramArray,
        ));
	}


}