<?php

class MailgroupsController extends Controller
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
        $model=new Mailgroups;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mailgroups']))
		{
			$model->attributes=$_POST['Mailgroups'];
            $model->user_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('view','id'=>$model->mailgroup_id));
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

		if(isset($_POST['Mailgroups']))
		{
			$model->attributes=$_POST['Mailgroups'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->mailgroup_id));
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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mailGroupController.js');
		
        $mailGroupModel = new Mailgroups();
        if(isset($_POST['Mailgroups']))
        {
            $mailGroupModel->attributes=$_POST['Mailgroups'];
            $mailGroupModel->user_id = Yii::app()->user->id;
            if($mailGroupModel->save())
                Yii::app()->user->setFlash('success', '<strong>Success!</strong> Mail Group created successfully');
        }
        
        $model=new Mailgroups('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mailgroups']))
			$model->attributes=$_GET['Mailgroups'];
            $model->user_id = Yii::app()->user->id;
        
        $paramArray = array();
        $paramArray['mailGroupModel'] = $mailGroupModel;
        $paramArray['model'] = $model;
		$this->render('index',array(
			'paramArray'=>$paramArray,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mailGroupController.js');
        
		$model=new Mailgroups('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mailgroups']))
			$model->attributes=$_GET['Mailgroups'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    /**
     * Function to Add Member to a Mailgroup
     * @param type $id
     */
    public function actionAddMembers($id = null)
    {
        $model = Mailgroups::model()->findByPk(array('mailgroup_id' => $id));
        $personModel=new Persons;
        $customFieldModel = MailgroupCustomFields::model()->findAllByAttributes(array('mailgroup_id'=>$id));
        if(isset($model) && !empty($model))
        {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            
            if(isset($_POST['Persons']))
            {
                $personModel->attributes=$_POST['Persons'];
                $personModel->person_code = md5($_POST['Persons']['person_email']);
                $personModel->user_id = Yii::app()->user->id;
                if($personModel->save())
                {
                    $personMailGroupMappingModel = new PersonMailgroupStats;
                    $personMailGroupMappingModel->mailgroup_id = $id;
                    $personMailGroupMappingModel->person_id = $personModel->person_id;
                    $personMailGroupMappingModel->mailgroup_subscribe_stamp = time();
                    $personMailGroupMappingModel->save();
                    
                    $model->subscribe_count = $model->subscribe_count+1;
                    $model->save();
                    
                    
                    //print_r($_POST['MailgroupCustomFields']); die;
                    if(isset($_POST['MailgroupCustomFields']))
                    {
                        foreach($_POST['MailgroupCustomFields'] as $customFields=>$customValue)
                        {
                            $personCustomValues = new PersonCustomValues();
                            $personCustomValues->custom_field_id = $customFields;
                            $personCustomValues->mailgroup_id = $id;
                            $personCustomValues->person_id = $personModel->person_id;
                            $personCustomValues->person_custom_field_value = $customValue;
                            $personCustomValues->save();
                        }
                        
                        
                    }
                    
                    Yii::app()->user->setFlash('success', '<strong>Member added successfully!!</strong>');
                }
            }
            
            
        }
        else
        {
            Yii::app()->user->setFlash('warning', '<strong>Mailgroup does not exits! Select Mail Group to add members </strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $paramArray = array();
        $paramArray['model'] = $personModel;
        $paramArray['customFieldModel'] = $customFieldModel;
        
        
		$this->render('addmembers',array(
			'paramArray'=>$paramArray,
		));
    }
    
    /**
     * Function to Prepared Headers to Download Sample CSV for Bulk Import CSv 
     */
    public function actionSampleMailGroupsImport()
    {
        if(isset($_REQUEST['download']))
        {           
            $fileName = Yii::app()->params['sampleCsvFiles']['mailgroups'];
            $path = Yii::app()->getBaseUrl(true).'/download_files/'.$fileName;
            getDownloadFile($path,$fileName);                          
        }
    }
    
    public function actionBulkImportMailgroups($id = null)
    {
        $mailGroupModel = Mailgroups::model()->findByPk($id);
        if(!$mailGroupModel)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group does not exist!</strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $errorArr = array();
        $csvFile = CUploadedFile::getInstanceByName('csvFile');
        if(Yii::app()->request->isPostRequest)
        {
            if($csvFile)
            {
                $mailgroup_count = $mailGroupModel->subscribe_count;
                $personInsertCount = 0;
                $personUpdateCount = 0;
                $personSkipCount = 0;
                $handle = fopen("$csvFile->tempName", "r");
                $row = 1;
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE)
                {
                    // if row is not the first row
                    $updated = false;
                    if ($row > 1)
                    {                       
                        // check if event with code already exists
                        $transaction = Yii::app()->db->beginTransaction();
                        $personModel = Persons::model()->findByAttributes(array('person_email'=> trim($data[2])));

                        if (!$personModel)
                        {
                            $personModel = new Persons();
                        }
                        else
                        {
                            $updated = true;
                        }

                        $personModel->user_id = Yii::app()->user->id;
                        $personModel->person_first_name = $data[0];
                        $personModel->person_last_name = $data[1];
                        $personModel->person_email = $data[2];
                        $personModel->person_phone = $data[3];
                        $personModel->person_address_line1 = $data[4];
                        $personModel->person_address_line2 = $data[5];
                        $personModel->person_city = $data[6];
                        $personModel->person_state = $data[7];
                        $personModel->person_country = $data[8];
                        $personModel->person_zipcode = $data[9];
                        $personModel->person_code = md5($data[2]);
                        
                        if($data[0]=="" || $data[1]=="" || $data[2]=="")
                        {
                            $personSkipCount++;
                        }
                        else
                        {
                            if ($personModel->validate())
                            {
                                if ($personModel->save())
                                {
                                    $mailGroupPersonMappingModel = PersonMailgroupStats::model()->findByAttributes(array('person_id' => $personModel->person_id, 'mailgroup_id' => $id));
                                    if(!$mailGroupPersonMappingModel)
                                    {
                                        $mailGroupPersonMappingModel = new PersonMailgroupStats();
                                    }

                                    $mailGroupPersonMappingModel->person_id = $personModel->person_id;
                                    $mailGroupPersonMappingModel->mailgroup_id = $id;
                                    $mailGroupPersonMappingModel->mailgroup_subscribe_stamp = time();
                                    $mailGroupPersonMappingModel->mailgroup_unsubscribe_stamp = NULL;
                                    $mailGroupPersonMappingModel->is_subscribed = '1';
                                    $mailGroupPersonMappingModel->save();

                                    if(!isset($errorArr[$row]))
                                    {
                                        $transaction->commit();
                                        if($updated)
                                            $personUpdateCount++;
                                        else
                                            $personInsertCount++;
                                    }
                                    else
                                    {
                                        $transaction->rollback();
                                    }
                                }
                            }
                            else
                            {
                                $personSkipCount++;
                            }
                        }
                        
                    }
                    $row++;
                    }
                
                if($personInsertCount>0)
                {
                    $mailGroupModel->subscribe_count = $mailgroup_count + $personInsertCount;
                    $mailGroupModel->save();
                }
                if($personInsertCount >0 || $personUpdateCount >0 || $personSkipCount >0)
                {
                    Yii::app()->user->setFlash('success', '<strong>New member added successfully!</strong> Total person inserted = '. $personInsertCount.', Total person updated = '.$personUpdateCount.', Total Skipped: '.$personSkipCount);
                }
            }
            else
            {
                $errorArr[] = 'Select a CSV to upload';
            }
        }
        
        
        $paramArray = array();
        $paramArray['error'] = $errorArr;
        $paramArray['model'] = $mailGroupModel;
        $this->render("bulkmailgroupsimport", array(
            'paramArray' => $paramArray,
        ));
    }
    
    /**
     * Function to Clone Mailgroups
     * @param type $id
     */
    public function actionCloneMailgroups($id = null)
    {
        $mailGroupModel = Mailgroups::model()->findByPk($id);
        $req = Yii::app()->request->isPostRequest;
        $user_id = Yii::app()->user->id;
        $saveToMailGroup = true;
        
        if(!$mailGroupModel)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group does not exist!</strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        if($req && $_POST['Mailgroups']['newmailgroup']=='')
        {
            Yii::app()->user->setFlash('warning', '<strong>New Mail Group cannot be blank!</strong>');
            $saveToMailGroup = false;
            $this->refresh();
            //$this->redirect(array('mailgroups/clonemailgroups', 'id' => $id));
        }
        
        if($req && $_POST['Mailgroups']['mailgroup_name']!=$mailGroupModel->mailgroup_name)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group name cannot be changed!</strong>');
            $saveToMailGroup = false;
            //$this->redirect(array('mailgroups/clonemailgroups', 'id' => $id));
        }
        
        if($saveToMailGroup && $req)
        {
            $newMailGroup = new Mailgroups;
            $newMailGroup->mailgroup_name = $_POST['Mailgroups']['newmailgroup'];
            $newMailGroup->user_id = Yii::app()->user->id;
            $newMailGroup->subscribe_count = $mailGroupModel->subscribe_count + $mailGroupModel->unsubscribe_count + $mailGroupModel->bounced_count;
            
            try 
            {
                $transaction = Yii::app()->db->beginTransaction();
                if($newMailGroup->save())
                {
                    $personMailGroupStatModel = getMailGroupsPerson($mailGroupModel->mailgroup_id);
                    foreach($personMailGroupStatModel as $person)
                    {
                        $clonePersonModel = new PersonMailgroupStats();
                        //$clonePersonModel->attrbutes = $person->attributes;
                        $clonePersonModel->person_id = $person->person_id;
                        $clonePersonModel->mailgroup_id = $newMailGroup->mailgroup_id;
                        $clonePersonModel->is_subscribed = '1';
                        $clonePersonModel->mailgroup_subscribe_stamp = time();
                        $clonePersonModel->mailgroup_unsubscribe_stamp = NULL;
                        $clonePersonModel->mailgroup_bounced_stamp = NULL;
                        $clonePersonModel->save();
                        $transaction->commit();
                    }

                    Yii::app()->user->setFlash('success', '<strong>Mail Group Cloned Successfully!!!</strong>');
                    $this->redirect(array('index'));
                }
                
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('warning', '<strong>Error cloning mail group.!</strong>');
            }
            
        }
        
        $this->render('clonemailgroups', array('model' => $mailGroupModel));
        
    }
    
    public function actionMailGroupStats($id = null)
    {
        $mailGroupModel = Mailgroups::model()->findByPk($id);
        
        $user_id = Yii::app()->user->id;
        
        if(!$mailGroupModel)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group does not exist!</strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $statArray = array();
        $total = array();
        $total['totalCount'] = $mailGroupModel->subscribe_count + $mailGroupModel->unsubscribe_count + $mailGroupModel->bounced_count;
        $statArray['Subscribed'] = $mailGroupModel->subscribe_count;
        $statArray['Unsubscribed'] = $mailGroupModel->unsubscribe_count;
        $statArray['Bounced'] = $mailGroupModel->bounced_count;
        
        $paramArray = array();
        $paramArray['statArray'] = $statArray;
        $paramArray['totalCount'] = $total;
        
        
        $this->render('mailgroupstats', array('paramArray'=> $paramArray));
        
    }
    
    /**
     * Function to Send Mailgroup Subscription Email to the menbers os a Mailgroup
     */
    public function actionSendMailgroupSubscriptionMail()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mailGroupController.js');
        $return = array();
        $mailgroup_id = !empty($_POST['mailgroup_id']) ? $_POST['mailgroup_id'] : false;
        
        if(!$mailgroup_id)
        {
            $return["success"] = "0";
            $return["message"] = "Email sending failed, Missing Mailgroup Id.";
            echo CJSON::encode($return);
            exit;
        }
        
        $mailGroupModel = Mailgroups::model()->findByPk($mailgroup_id);
        
        if(!$mailGroupModel)
        {
            $return["success"] = "0";
            $return["message"] = "Email sending failed, Mailgroup Model Does Not Exist.";
            echo CJSON::encode($return);
            exit;
        }
        
        //Notification Templates Tags
        $tags = array();
        $tagsIndex = 0;
        $tags[$tagsIndex++] = "{{FirstName}}";
        $tags[$tagsIndex++] = "{{LastName}}";
        $tags[$tagsIndex++] = "{{MailGroupName}}";
        
        $emailError = array();
        
        $notificationTemplateId = getGlobalPreferences('mailgroup_subscribe_email');
        $notificationTemplateModel = NotificationTemplates::model()->findByPk($notificationTemplateId);
        $emailContent = $notificationTemplateModel->content;
        $emailSubject = $notificationTemplateModel->subject;
        
        $personMailgroupModel = getSubUnsubscribedMailGroupPerson('0', $mailgroup_id);
        
        if(count($personMailgroupModel)>0)
        {
            foreach($personMailgroupModel as $personMailgroup)
            {

                $personModel = Persons::model()->findByAttributes(array('person_id' => $personMailgroup->person_id));

                if($personModel)
                {
                    $receiverEmail = $personModel->person_email;
                    $receiverName = trim($personModel->person_first_name." ".$personModel->person_last_name);

                    $sendersEmail = Yii::app()->params['adminEmail'];
                    $sendersName = Yii::app()->params['adminName'];

                    $replaceValues = array();
                    $tagsIndex =0;
                    $replaceValues[$tagsIndex++] = $personModel->person_first_name;
                    $replaceValues[$tagsIndex++] = $personModel->person_last_name;
                    $replaceValues[$tagsIndex++] = $mailGroupModel->mailgroup_name;
                    $emailContentToSend = str_replace($tags, $replaceValues, $emailContent);
                    $emailSubjectToSend = str_replace($tags, $replaceValues, $emailSubject);

                    if (!sendEmail($receiverEmail, $receiverName, $sendersEmail, $sendersName, $emailSubjectToSend, $emailContentToSend))
                    {
                        $emailError[] = $personModel->person_email;
                    }
                }

            }
            
            if(count($emailError)>0)
            {
                $return["success"] = "0";
                $return["message"] = "Email could not be sent follwing users ". implode(", ", $emailError);
                exit;
            }
            
            
        }
        else
        {
            $return["success"] = "0";
            $return["message"] = "Email cannot be sent. Either all members are subscribed or no person exist in this mailgroup.";
            echo CJSON::encode($return);
            exit;
        }
        
        
        $return["success"] = "1";
        $return["message"] = "Email sent successfully";
        
        echo CJSON::encode($return);
    }
    
    /**
     * function to View Member of Mailgroup
     * @param type $id
     */
    public function actionViewMembers($id = null)
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mailGroupController.js');
        
        $mailGroupModel = Mailgroups::model()->findByPk($id);
        
        $user_id = Yii::app()->user->id;
        
        if(!$mailGroupModel)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group does not exist!</strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $model=new PersonMailgroupStats('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PersonMailgroupStats']))
			$model->attributes=$_GET['PersonMailgroupStats'];
            $model->mailgroup_id = $id;
        
        $this->render('viewmembers',array(
			'model'=>$model,
		));
        
        
    }
    
    /**
     * Function to subscribe and unsubscribe person from mailgroup
     * @param type $mailgroup_id
     * @param type $person_id
     * @param type $subscribed = 'sub' or 'unsub'
     */
    public function actionMarkSubscribeUnsubscribe()
    {
        //$return = array();
        $mailgroup_id = $_POST['mailgroup_id'];
        $person_id = $_POST['person_id'];
        $subscribed = $_POST['subscribe'];
        
        if(!isset($mailgroup_id) && !isset($person_id))
        {
            $return["success"] = "0";
            $return["message"] = "Mail Group or Person Id is missing.";
            echo CJSON::encode($return);
        }
        else
        {
            $subscribedStatus = PersonMailgroupStats::model()->findByAttributes(array('mailgroup_id' => $mailgroup_id, 'person_id' => $person_id));
            
            if($subscribed == '1')
            {
                $subscribedStatus->is_subscribed = '1';
                $subText = 'subscribed to';
            }
            else if($subscribed == '0')
            {
                $subscribedStatus->is_subscribed = '0';
                $subText = 'unsubscribed from';
            }
            
            if($subscribedStatus->save())
            {
                $mailGroupModel = Mailgroups::model()->findByAttributes(array('mailgroup_id' => $mailgroup_id));
                $subCnt = $mailGroupModel->subscribe_count;
                $unSubCnt = $mailGroupModel->unsubscribe_count;
                
                $subscribedStatus = PersonMailgroupStats::model()->findByAttributes(array('mailgroup_id' => $mailgroup_id, 'person_id' => $person_id));
                if($subscribedStatus->is_subscribed == '1')
                {
                    $mailGroupModel->subscribe_count = $subCnt+1;
                    $subscribedStatus->mailgroup_subscribe_stamp = time();
                    
                    $mailGroupModel->unsubscribe_count = $unSubCnt-1;
                    $subscribedStatus->mailgroup_unsubscribe_stamp = null;
                }
                else if($subscribedStatus->is_subscribed == '0')
                {
                    $mailGroupModel->unsubscribe_count = $unSubCnt+1;
                    $subscribedStatus->mailgroup_unsubscribe_stamp = time();
                    
                    $mailGroupModel->subscribe_count = $subCnt-1;
                    $subscribedStatus->mailgroup_subscribe_stamp = null;
                    
                }
                
                $mailGroupModel->save();
                $subscribedStatus->save();
                
                
                $return["success"] = "1";
                $return["message"] = "Person successfully ".$subText." Mailgroup : ".$mailGroupModel->mailgroup_name;
                echo CJSON::encode($return);
            }
            else
            {
                $return["success"] = "0";
                $return["message"] = "Error Occured!!! Action cannot be completed";
                echo CJSON::encode($return);
            }
                
        }
    }
    
    public function actionAddCustomFields($id = null)
    {
        $mailGroupModel = Mailgroups::model()->findByPk($id);
        
        $user_id = Yii::app()->user->id;
        
        if(!$mailGroupModel)
        {
            Yii::app()->user->setFlash('warning', '<strong>Mail Group does not exist!</strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $model = new MailgroupCustomFields();
        if(isset($_POST['MailgroupCustomFields']))
		{
			$model->attributes=$_POST['MailgroupCustomFields'];
            $model->mailgroup_id = $id;
			if($model->save())
            {
                $mailgroupPersonModel = getMailGroupsPerson($id);
                foreach($mailgroupPersonModel as $personMailgroup)
                {
                    $personCustomVal = PersonCustomValues::model()->findByAttributes(array('custom_field_id'=>$model->mailgroup_custom_id,'person_id'=>$personMailgroup->person_id, 'mailgroup_id'=>$personMailgroup->mailgroup_id));
                    if(!$personCustomVal)
                    {
                        $personCustomVal = new PersonCustomValues();
                        $personCustomVal->custom_field_id = $model->mailgroup_custom_id;
                        $personCustomVal->mailgroup_id = $personMailgroup->mailgroup_id;
                        $personCustomVal->person_id = $personMailgroup->person_id;
                        $personCustomVal->person_custom_field_value = null; 
                    }
                    $personCustomVal->save();
                }
                Yii::app()->user->setFlash('success', '<strong>Custom Field added successfully</strong>');
				//$this->redirect(array('mailgroups/index'));
            }
                
		}
        
        $this->render('addcustomfields',array(
			'model'=>$model,
		));
    }
    
    public function actionPersonCustomFieldsEdit($id = null, $person_id = null)
    {
        $model = Mailgroups::model()->findByPk($id);
        $personModel= Persons::model()->findByPk($person_id);
        $customFieldModel = MailgroupCustomFields::model()->findAllByAttributes(array('mailgroup_id'=>$id));
        $originalEmail = $personModel->person_email;
        
        if(isset($model) && !empty($model))
        {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            
            if(isset($_POST['Persons']))
            {
                $personModel->attributes=$_POST['Persons'];
                $personModel->person_email = $originalEmail;
                
                if($personModel->save())
                {
                    //print_r($_POST['MailgroupCustomFields']); die;
                    if(isset($_POST['MailgroupCustomFields']))
                    {
                        foreach($_POST['MailgroupCustomFields'] as $customFields=>$customValue)
                        {
                            $personCustomValues = PersonCustomValues::model()->findByAttributes(array('custom_field_id'=>$customFields, 'mailgroup_id'=> $id, 'person_id'=>$person_id));
                            $personCustomValues->person_custom_field_value = $customValue;
                            $personCustomValues->save();
                        }
                        
                        
                    }
                    
                    Yii::app()->user->setFlash('success', '<strong>Person data edited successfully!!</strong>');
                }
            }
            
            
        }
        else
        {
            Yii::app()->user->setFlash('warning', '<strong>Mailgroup does not exits! Select Mail Group to add members </strong>');
            $this->redirect(array('mailgroups/index'));
        }
        
        $paramArray = array();
        $paramArray['model'] = $personModel;
        $paramArray['customFieldModel'] = $customFieldModel;
        
        $this->render('personcustomfieldsedit',array(
			'paramArray'=>$paramArray,
		));
    }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Mailgroups::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='mailgroups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
