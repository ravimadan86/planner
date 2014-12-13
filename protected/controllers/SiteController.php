<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        $model=new ContactForm;
        $cc = array();
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$subject = "Customer Query: ".$model->subject;
                $receieverEmail = Yii::app()->params['adminEmail'];
                $receieverName = Yii::app()->params['adminName'];
                
				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                sendEmail($receieverEmail, $receieverName, $model->email, $model->name, $subject, $model->body, $cc);
				Yii::app()->user->setFlash('contact','Thank you for writing us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
    
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
    
     /**
   * function for forgot password 
   */
   public function actionForgotPassword()
   {
       // check if user is already logged in
       if (!Yii::app()->user->isGuest)
       {
           // display the login form
           $this->redirect(Yii::app()->createAbsoluteUrl('home'));
       }

       $forgotPassModel = new ForgotPasswordForm;

       // Uncomment the following line if AJAX validation is needed
       // $this->performAjaxValidation($model);         
        if(isset($_POST['ForgotPasswordForm']))
        {                
            $userModel = User::model()->findByAttributes(array('email' => $_POST['ForgotPasswordForm']['email']));
            // check if email already exists [ required for mobile app ] 
            // check user authorize to change password
            if (isset($userModel) && in_array($userModel->role, Yii::app()->params['roleNames']))
            {   
                // getting the unique registration token for user
                $userModel->forgot_token = getUniqueToken($userModel->email);
                if ($userModel->save())
                {
                    /**
                    * Send Password Rest Link by using template with key "password_reset"
                    */
                    $emailTags = getEmailTagsToBeReplaced();
                    // values by which tags will be replaced
                    $replaceValues = array();
                    $tagIndex = 0;
                    
                    //$tags[$tagsIndex++] = "{{WebsiteLogo}}";
                    $replaceValues[$tagIndex++] = getGlobalPreferences('site_url');
                    $replaceValues[$tagIndex++] = ''; //CHtml::link($registrationURL, $registrationURL); // for registration URL
                    $replaceValues[$tagIndex++] = $userModel->first_name;
                    $replaceValues[$tagIndex++] = $userModel->last_name;
                    $replaceValues[$tagIndex++] = $userModel->email;
                    $replaceValues[$tagIndex++] = '';   // left for password
                    $replaceValues[$tagIndex++] = $userModel->role;
                    $newPasswordURL = Yii::app()->createAbsoluteUrl('/site/newpassword', array('token' => $userModel->forgot_token));
                    $replaceValues[$tagIndex++] = CHtml::link($newPasswordURL, $newPasswordURL); // for registration URL
                    
                    //Fetch Password Reset Template from Global Preferences
                    $newRegistrationTemplateId = getGlobalPreferences('password_reset');
                    if ($newRegistrationTemplateId)
                    {
                        $templateModel = NotificationTemplates::model()->findByPk($newRegistrationTemplateId);
                        if ($templateModel)
                        {
                            $emailContent = $templateModel->content;
                            $emailSubject = $templateModel->subject;
                            $emailContentToSend = str_replace($emailTags, $replaceValues, $emailContent);
                            $emailSubjectToSend = str_replace($emailTags, $replaceValues, $emailSubject);
                            $recieversName = $userModel->first_name." ".$userModel->last_name;
                            $recieversEmail = $userModel->email;
                            $emailFrom = Yii::app()->params['adminEmail']; //$templateModel->from;
                            $sendersName = Yii::app()->params['adminName']; //$templateModel->senders_name;
                            sendEmail($recieversEmail, $recieversName, $emailFrom, $sendersName, $emailSubjectToSend,  $emailContentToSend);
                        }
                    }


                 // setting the success message
                 Yii::app()->user->setFlash('success', '<strong>Please check your mail</strong>');
                 $this->redirect(array('/site/login'));

                }
            }
            else
            {
                 // setting the success message
                 Yii::app()->user->setFlash('warning', '<strong>Email does not exists.</strong>');
            }
        }

        $this->render('forgot_password',array(
           'model'=>$forgotPassModel,
        ));
   }

   /**
    * function for change password 
    */
   public function actionNewPassword()
   {
       // check if user is already logged in
       if (!Yii::app()->user->isGuest)
       {
           // display the login form
           $this->redirect(Yii::app()->createAbsoluteUrl('home'));
       }
       $token  = isset($_GET['token'])?$_GET['token']:'';


       $model = new NewPassword;
       $userModel = User::model()->findByAttributes(array('forgot_token' => $token));
       if(!$userModel)
       {
            // setting the unsuccess message
            Yii::app()->user->setFlash('warning', '<strong>Token is not valid.</strong>');
            
       }
       
       if(isset($_POST['NewPassword']) && isset($userModel))
       {
          if($_POST['NewPassword']['new_password'] == $_POST['NewPassword']['new_password'])
          {
              $userModel->password = md5($_POST['NewPassword']['new_password']);
              $userModel->forgot_token = '';
              $userModel->save();

              Yii::app()->user->setFlash('success', '<strong>Password has been changed successfully.</strong>');
              $this->redirect('login');

          }
          else
          {
              Yii::app()->user->setFlash('warning', '<strong>New Password and New Passowrd Repeat must be same.</strong>');   
          }         
       }
           
       $this->render('new_password',array(
            'model'=>$model,'token'=>$token
        ));       
   }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}