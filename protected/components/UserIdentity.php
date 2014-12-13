<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_email;
    public $first_name;
    public $last_name;
    
    public function __construct($email, $password) 
    {
        $this->_email = $email;
        $this->password = $password;
    }
    
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/*$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);*/
        
		$user = User::model()->findByAttributes(array('email'=>$this->_email, 'is_active'=>'1'));
        
        if($user === null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($user->password !== md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $user->user_id;
            $this->first_name = $user->first_name; 
            $this->last_name = $user->last_name; 
            $this->setState('name', $user->role); // 
            $this->setState('user_id', $user->user_id);
            $this->setState('role', $user->role);
            $this->setState('email', $user->email);
            $this->setState('first_name', $user->first_name);
            $this->setState('last_name', $user->last_name);
            $this->errorCode=self::ERROR_NONE;
        }
        
		return !$this->errorCode;
	}
    
    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->first_name." ".$this->last_name;
    }
}