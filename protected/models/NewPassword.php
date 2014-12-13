<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */

class NewPassword extends CFormModel
{
  //public $currentPassword;
  public $new_password;
  public $new_password_repeat;
	private $_identity;
  
  public function rules()
  {
    return array(

      array(
        'new_password, new_password_repeat', 'required',
        //'message'=>'aaaa {attribute}.',
      ),
      array(
        'new_password_repeat', 'compare',
        'compareAttribute'=>'new_password',
        //'message'=>'bbbb.',
      ),
      
    );
  }
  


  
  public function attributeLabels()
  {
    return array(
      'new_password'=>'New Password',
      'new_password_repeat'=>'New Passowrd Repeat',
    );
  }
  

}
?>
