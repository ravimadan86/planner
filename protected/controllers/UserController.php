<?php

class UserController extends Controller
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
        $allUserRoles = Yii::app()->params['roleNames'];
        
		$model=new User;
        
        // creating instance of AuthAssignment model
        $authAssignmentModel = new Authassignment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            $connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
            $saveUserDetails = true;
            try
            {
                $model->attributes=$_POST['User'];
                $pwd_string = getGlobalPreferences('password_string_length');
                $password = getRandomString($pwd_string);
                $model->password = md5($password);
                
                // check if email already exists
                if (checkIfUserExists($model->email))
                {
                    Yii::app()->user->setFlash('warning', '<strong>Email "'.$model->email.'" already exists!</strong>');
                    $saveUserDetails = false;
                }
                if (!in_array($model->role, $allUserRoles))
                {
                    Yii::app()->user->setFlash('warning', '<strong>User Role does not exists!</strong>');
                    $saveUserDetails = false;
                }
                
                if($saveUserDetails)
                {
                    if($model->save())
                    {
                        $user_id_created = $model->user_id;
                        $authAssignmentModel->userid = $user_id_created;
                        $authAssignmentModel->itemname = $model->role;
                        $authAssignmentModel->save();
                        $transaction->commit();
                        
                        //Send Mail for New Account Created
                        $emailTags = getEmailTagsToBeReplaced();
                        // values by which tags will be replaced
                        $replaceValues = array();
                        $tagIndex = 0;

                        //$tags[$tagsIndex++] = "{{WebsiteLogo}}";
                        $replaceValues[$tagIndex++] = getGlobalPreferences('site_url');
                        $replaceValues[$tagIndex++] = ''; //CHtml::link($registrationURL, $registrationURL); // for registration URL
                        $replaceValues[$tagIndex++] = $model->first_name;
                        $replaceValues[$tagIndex++] = $model->last_name;
                        $replaceValues[$tagIndex++] = $model->email;
                        $replaceValues[$tagIndex++] = $password;   // left for password
                        $replaceValues[$tagIndex++] = $model->role;
                        $replaceValues[$tagIndex++] = '';
                        
                        //Fetch Password Reset Template from Global Preferences
                        $newRegistrationTemplateId = getGlobalPreferences('account_created');
                        if ($newRegistrationTemplateId)
                        {
                            $templateModel = NotificationTemplates::model()->findByPk($newRegistrationTemplateId);
                            if ($templateModel)
                            {
                                $emailContent = $templateModel->content;
                                $emailSubject = $templateModel->subject;
                                $emailContentToSend = str_replace($emailTags, $replaceValues, $emailContent);
                                $emailSubjectToSend = str_replace($emailTags, $replaceValues, $emailSubject);
                                $recieversName = trim($model->first_name." ".$model->last_name);
                                $emailFrom = $templateModel->from;
                                $sendersName = $templateModel->senders_name;
                                $cc = array();
                                sendEmail($model->email, $recieversName, $emailFrom, $sendersName, $emailSubjectToSend, $emailContentToSend, $cc);
                            }
                        }
                        
                        Yii::app()->user->setFlash('success', '<strong>Success!</strong> User created successfully');
                        $this->redirect(array('view','id'=>$user_id_created));
                    }
                }
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('warning', '<strong>Error creating the user!</strong>');
            }

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
        $allUserRoles = Yii::app()->params['roleNames'];
        
		$model=$this->loadModel($id);
        
        //Fetch Auth Role Assignment
        $authAssignmentModel = Authassignment::model()->findByAttributes(array('userid'=> $id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            $connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
            $saveUserDetails = true;
 
            try 
            {
                $oldEmail = $model->email;
                $oldRole = $model->role;
                
                $model->attributes=$_POST['User'];
                
                $newEmail = $model->email;
                $newRole = $model->role;
                
                $errors = array();
                
                // check if email already exists
                if ($oldEmail!=$newEmail && checkIfUserExists($newEmail))
                {
                    $errors[] = '<strong>Email "'.$model->email.'" already exists!</strong>';
                    $saveUserDetails = false;
                }
                
                if (!in_array($model->role, $allUserRoles))
                {
                    $errors[] = '<strong>User Role does not exists!</strong>';
                    $saveUserDetails = false;
                }
                
                if($saveUserDetails)
                {
                    $update_time = new CDbExpression('NOW()');
                    $model->last_modified_time = $update_time;
                    
                    if($model->save())
                    {
                        $authAssignmentModel->itemname = $model->role;
                        $authAssignmentModel->save();
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', '<strong>Success!</strong> User updated successfully');
                        $this->redirect(array('view','id'=>$id));
                    }
                }
                else
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('warning', implode('<br/>', $errors));
                }
                
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('warning', '<strong>Error creating the user!</strong>');
            }
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
			$update_time = new CDbExpression('NOW()');
            $model = $this->loadModel($id);
            $model->is_active = 0;
            $model->last_modified_time = $update_time;
            $model->save();

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
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
