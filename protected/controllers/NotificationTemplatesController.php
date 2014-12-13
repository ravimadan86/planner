<?php

class NotificationTemplatesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
    {
        return array(
            array('auth.filters.AuthFilter'),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NotificationTemplates;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NotificationTemplates']))
		{
			$model->attributes=$_POST['NotificationTemplates'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NotificationTemplates']))
		{
			$model->attributes=$_POST['NotificationTemplates'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('NotificationTemplates');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NotificationTemplates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NotificationTemplates']))
			$model->attributes=$_GET['NotificationTemplates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    /**
     * action is called by ajax request to initialize sending Email notification
     */
    public function actionSendEmailNotification()
    {
        ini_set('max_execution_time', 3600);
        // values to be replaced from the email template
        //print_r($_POST); die;
        // fetching form fields
        $emailFrom = $_POST["NotificationTemplates"]["from"];
        $sendersName = $_POST["NotificationTemplates"]["senders_name"];
        $emailSubject = $_POST["NotificationTemplates"]["subject"];
        $emailContent = $_POST["NotificationTemplates"]["content"];
        $mailGroup = $_POST["NotificationTemplates"]["mailgroup"];
        $emailError = array();
        $cc= array();
        
        $personTags = getPersonTagsForEmail();
        //print_r($personTags);
        $custom_tags = getMailGroupTags($mailGroup);
        $mailGroupPerson = getSubUnsubscribedMailGroupPerson('1', $mailGroup);
        foreach($mailGroupPerson as $person)
        {
            $personModel = getSubUnsubscribedPerson('1', $person->person_id);
            
            $replaceValues = getReplacedPersonTagsForEmail($personModel);
            //print_r($replaceValues); 
            $mailGroupCustomTags = getMailGroupTags($mailGroup);
            
            $mailGroupreplaceTagsValue = getPersonCustomTagValues($mailGroup, $personModel->person_id);
            
            $emailSendContent = str_replace($personTags, $replaceValues, $emailContent);
            $emailSendContent = str_replace($mailGroupCustomTags, $mailGroupreplaceTagsValue, $emailSendContent);
            
            $emailSendSubject = str_replace($personTags, $replaceValues, $emailSubject);
            $emailSendSubject = str_replace($mailGroupCustomTags, $mailGroupreplaceTagsValue, $emailSendSubject);
            if($personModel)
            {
                if (!sendEmail($personModel->person_email, trim($personModel->person_first_name." ".$personModel->person_last_name), $emailFrom, $sendersName, $emailSendSubject, $emailSendContent, $cc))
                {
                    $emailError[] = 'error unknown';
                }
            }
            
            
        }
        
        $return = array();
        if ( count($emailError) == 0 )
        {
            $return["success"] = "1";
            $return["message"] = "Email sent successfully";
        }
        else
        {
            $return["success"] = "0";
            $return["message"] = "Email could not be sent follwing users ";
        }
        echo CJSON::encode($return);
    }
    
    /**
     * funciton is called by ajax request
     * function is used to load a template
     */
    public function actionLoadTemplate()
    {
        $return = array();
        if ( isset($_POST['id']) )
        {
            $notificationTemplatesModel = $this->loadModel($_POST['id']);
            if ($notificationTemplatesModel)
            {
                $return['success'] = '1';
                $return['message'] = 'Template loaded successfully';
                $return['id'] = $notificationTemplatesModel->id;
                $return['from'] = $notificationTemplatesModel->from;
                $return['sendersName'] = $notificationTemplatesModel->senders_name;
                $return['subject'] = $notificationTemplatesModel->subject;
                $return['content'] = $notificationTemplatesModel->content;
                $return['title'] = $notificationTemplatesModel->title;
            }
            else
            {
                $return['success'] = '0';
                $return['message'] = 'Template not found';
            }
        }
        else
        {
            $return['success'] = '0';
            $return['message'] = 'Template not specified';
        }
        echo CJSON::encode($return);
    }
    
    /**
     * action is called by ajax
     * function is used to delete the selected template
     */
    public function actionDeleteTemplate()
    {
        $return = array();
        if ( isset($_POST['id']) )
        {
            $this->loadModel($_POST['id'])->delete();
            $return['success'] = '1';
            $return['message'] = 'Template deleted successfully';
        }
        else
        {
            $return['success'] = '0';
            $return['message'] = 'Template not specified';
        }
        echo CJSON::encode($return);
    }
    
    /**
     * function is used to save a template
     */
    public function actionSaveTemplate()
    {
        if (isset($_POST))
        {
            $return = array();
            $templateTitle = $_POST['NotificationTemplates']['title'];
            $templateFrom = $_POST['NotificationTemplates']['from'];
            $templateSendersName = $_POST['NotificationTemplates']['senders_name'];
            $templateSubject = $_POST['NotificationTemplates']['subject'];
            $templateContent = $_POST['NotificationTemplates']['content'];
            $templateType = $_POST['NotificationTemplates']['type'];
            $errors = array();
            // check if template title is blank
            if ($templateTitle == '')
            {
                $errors[] = "- Template title can not be blank";
            }
            // check if template content is blank
            if ($templateContent == '')
            {
                $errors[] = "- Template body can not be blank";
            }
            // check if template subject is blank
            if ($templateSubject == '')
            {
                $errors[] = "- Template subject can not be blank";
            }
            // check if form submitted has errors, if no errors then
            // continue saving the NotificationTemplates model
            if (count($errors) == 0)
            {
                // check if new template option is selected
                if ($_POST['NotificationTemplates']['id'] == 'new')
                {
                    $templateModel = new NotificationTemplates;
                    $templateModel->tag = strtotime('now');
                    $return['isNewTemplate'] = "1";
                }
                else
                {
                    // loading template model if new template is not selected
                    $templateModel = $this->loadModel($_POST['NotificationTemplates']['id']);
                    $return['isNewTemplate'] = "0";
                    // checking if the template is saved with a new title
                    if ($templateModel->title != $templateTitle)
                    {
                        // creating new NotificationTemplates model
                        $templateModel = new NotificationTemplates;
                        $templateModel->tag = strtotime('now');
                        $return['isNewTemplate'] = "1";
                    }
                }
                // check if template is new and template with same name and same type exists
                if ( $return['isNewTemplate'] == "1" && NotificationTemplates::model()->countByAttributes(array('type' => $templateType, 'title' => $templateTitle)) == 1)
                {
                    $return['success'] = '0';
                    $return['message'] = 'Template with same title already exists, please choose another title';
                }
                // else save the template
                else
                {
                    $templateModel->type = $templateType;
                    $templateModel->title = $templateTitle;
                    $templateModel->from = $templateFrom;
                    $templateModel->senders_name = $templateSendersName;
                    $templateModel->subject = $templateSubject;
                    $templateModel->content = $templateContent;
                    if ($templateModel->save())
                    {
                        $return['success'] = '1';
                        $return['message'] = 'Template saved successfully';
                        $return['id'] = $templateModel->id;
                        $return['title'] = $templateModel->title;
                    }
                    else
                    {
                        $return['success'] = '0';
                        $return['message'] = 'An error occurred while saving the template';
                    }
                }
            }
            // if form contain errors
            // return failure along with error message
            else
            {
                $return['success'] = '0';
                $return['message'] = "Please fix following errors :-\r\n". implode("\r\n", $errors);
            }
            echo CJSON::encode($return);
        }
    }
    
    public function actionLoadMailgroupTagsUrl()
    {
        $return = array();
        if ($_POST)
        {
            $mailgroup_id = $_POST['mailgroup_id'];
            $mailGroupCustomFields = MailgroupCustomFields::model()->findAllByAttributes(array('mailgroup_id'=>$mailgroup_id));
            if($mailGroupCustomFields)
            {
                $tags = array();
                $tagIndex = 0;
                foreach($mailGroupCustomFields as $customFields)
                {
                    $tags[$tagIndex++] = "{{".$customFields->custom_field_name."}}";
                }
                $return['success'] = '1';
                $return['message'] = $tags;
            }
            else
            {
                $return['success'] = '0';
                $return['message'] = 'test';
            }
            
            
            
        }
    echo CJSON::encode($return);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=NotificationTemplates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notification-templates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
