<?php

/**
 * returns the list of email tags to be replaced
 */
function getEmailTagsToBeReplaced()
{
    $tags = array();
    $tagsIndex = 0;
    //$tags[$tagsIndex++] = "{{WebsiteLogo}}";
    $tags[$tagsIndex++] = "{{BaseUrl}}";
    $tags[$tagsIndex++] = "{{RegistrationURL}}";
    $tags[$tagsIndex++] = "{{FirstName}}";
    $tags[$tagsIndex++] = "{{LastName}}";
    $tags[$tagsIndex++] = "{{Email}}";
    $tags[$tagsIndex++] = "{{Password}}";
    $tags[$tagsIndex++] = "{{Role}}";
    $tags[$tagsIndex++] = "{{NewPasswordURL}}";

    return $tags;
}

/**
 * @return a random string of alphabets
 * @param integer $length
 */
function getRandomString($length)
{
    $str = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    $string = str_shuffle($str);
    return substr($string, 0, $length);
}

/**
 * @return unique string from generated from a string
 * @param string $string
 */
function getUniqueToken($string)
{
    $return = $string.time();
    return CHtml::encode(substr(sha1($return), 0, 255));
}


/*
 * function used to sends email
 * @param string $to
 * @param string $recieversName
 * @param string $from
 * @param string $sendersName
 * @param string $subject
 * @param string $content
 * @returns true if email sent successfully else false
 */
function sendEmail($to, $recieversName, $from, $sendersName, $subject, $content, $cc = array())
{
    $mail = new JPhpMailer;
    $mail->IsSMTP();
    $mail->Host = getGlobalPreferences("smtp_host");
    $mail->SMTPAuth = getGlobalPreferences("smtp_auth");
    $mail->Port = getGlobalPreferences("smtp_port");
    $mail->SMTPSecure = getGlobalPreferences("smtp_secure");
    $mail->Username = getGlobalPreferences("smtp_username");
    $mail->Password = getGlobalPreferences("smtp_password");
    $mail->SetFrom($from, $sendersName);
    $mail->Subject = $subject;
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    $mail->MsgHTML($content);
    $mail->AddAddress($to, $recieversName);
    
    if(count($cc)>0)
    {
        foreach($cc as $email => $name)
        {
           $mail->AddCC($email, $name);
        }
    }
    
    if ($mail->Send())
    {
        return true;
    }
    else
    {
        echo "Error Occured";
        return false;
    }
}

/**
* function is used to return the value for the key for GlobalPreferences model
* @param string $name
*/
function getGlobalPreferences($name)
{
    $return = "";
    if ($name)
    {
        $globalPreferencesModel = GlobalPreferences::model()->findByAttributes(array('name' => $name));
        if ($globalPreferencesModel)
        {
            $return = $globalPreferencesModel->value;
        }
    }
    return $return;
}

/**
* function is used to update the value of GlobalPreference in the GlobalPreferences model
* @param string $name = key to be updated
* @param string $value = value for the key
*/
function setGlobalPreferences($name, $value)
{
    $return = false;
    if ($name)
    {
        $globalPreferencesModel = GlobalPreferences::model()->findByAttributes(array('name' => $name));
        $globalPreferencesModel->value = $value;
        if ($globalPreferencesModel->save())
        {
            $return = true;
        }
    }
    return $return;
}


/*
 * Function to check If the user exist or not
 */
function checkIfUserExists($email)
{
    $return = false;
    $userModel = User::model()->findByAttributes(array('email' => html_entity_decode(trim($email))));
    if ($userModel)
    {
        $return = $userModel;
    }
    return $return;
}

/*
 * Function to UserRole based on User_id
 */
function getUserRole($user_id = null)
{
    $return = false;
    if($user_id == null)
    {
        $return = Yii::app()->user->role;
    }
    else
    {
        $userModel = User::model()->findByAttributes(array('user_id' => html_entity_decode(trim($user_id))));
        if ($userModel)
        {
            $return = $userModel->role;
        }
    }
    return $return;
}

/**
 * function fetches distinct user roles from authitem model
 */
function fetchUserRoles()
{
    return Authitem::model()->findAllByAttributes(array("type" => "2"));
}

/*
 * Function to check if user has admin access or role
 */
function isAdminUser()
{
    $return = (Yii::app()->user->role == 'Admin') ? true : false;
    return $return;
}

/*
 * Function to finc Customer Name
 */
function getUserName($user_id)
{
    $return = false;
    $userModel = User::model()->findByAttributes(array('user_id' => html_entity_decode(trim($user_id))));
    if($userModel) {
        $return = $userModel->first_name." ".$userModel->last_name;
    }
    
    return $return;
}

/*
 * Function to find Cutomer's/User's Organisation Name
 */
function getCompanyName($user_id)
{
    $return = false;
    $userModel = User::model()->findByAttributes(array('user_id' => html_entity_decode(trim($user_id))));
    if($userModel) {
        $return = $userModel->company_name;
    }
    
    return $return;
}

/**
 * To fetch the array of admin users
 * @return type
 */
function getAllAdminUsers()
{
    $adminList = array();
    $adminModel = User::model()->findAllByAttributes(array('role'=>'Admin', 'is_active'=> '1'));
    
    if($adminModel)
    foreach($adminModel as $model)
    {
        $adminList[] = $model->user_id;
    }
    
    return $adminList;
    
}

/**
 * Funtion to pass the headers for download file
 * @param type $path
 * @param type $filename
 */
function getDownloadFile($path, $filename = 'sample.txt')
 {

    $filecontent=file_get_contents($path);
    header("Content-Type: text/plain");
    header("Content-disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    echo $filecontent;
    exit;                 
 }
 
 /**
  * Function to fetch all the Mailgroups of a User
  * @param type $user_id
  * @return type
  */
 function getUserMailGroups($user_id = null)
 {
     $id = isset($user_id) ? $user_id : Yii::app()->user->id;
     
     $userMailgroupModel = Mailgroups::model()->findAllByAttributes(array('user_id' => $id));
     
     return $userMailgroupModel;
 }
 
 
 function getMailGroupsPerson($mailgroup_id)
 {
     if(isset($mailgroup_id))
     {  
        $mailGroupPersonModel = PersonMailgroupStats::model()->findAllByAttributes(array('mailgroup_id' => $mailgroup_id));
        return $mailGroupPersonModel;
     }
     
     return 0;
 }
 
 function getSubUnsubscribedMailGroupPerson($is_subscribed,$mailgroup_id = null)
 {
     $mailgroup_id = (int) $mailgroup_id;
     $subUnsubscribedModel = array();
     if($mailgroup_id)
     {
         $subUnsubscribedModel = PersonMailgroupStats::model()->findAllByAttributes(array('mailgroup_id'=>$mailgroup_id, 'is_subscribed' => $is_subscribed));
     }
     else
     {
         $subUnsubscribedModel = PersonMailgroupStats::model()->findAllByAttributes(array('is_subscribed' => $is_subscribed));
     }
     
     return $subUnsubscribedModel;
     
 }
 
 function getSubUnsubscribedPerson($is_subscribed, $person_id = null)
 {
     $person_id = (int) $person_id;
     $subUnsubscribedModel = array();
     if($person_id)
     {
         $subUnsubscribedModel = Persons::model()->findByAttributes(array('person_id'=>$person_id, 'is_subscribed' => $is_subscribed));
     }
     
     return $subUnsubscribedModel;
     
 }
 
 /**
* function is used to return notification templates
* @param string $type = notification type [ e.g. email, sms, push ]
* @param string $status is the inactive status for the notification
*/
function fetchNotificationTemplates($type, $status = "all")
{
    if ( $status == "all")
    {
        return NotificationTemplates::model()->findAllByAttributes(array("type" => $type));
    }
    else
    {
        $inactive = "1";
        if ($status == "active")
        {
            $inactive = "0";
        }
        return NotificationTemplates::model()->findAllByAttributes(array("type" => $type, "inactive" => $inactive), 'tag > 0');
    }
}
 
function getPersonTagsForEmail()
{
    $tags = array();
    $tagsIndex = 0;
    //$tags[$tagsIndex++] = "{{WebsiteLogo}}";
    $tags[$tagsIndex++] = "{{FirstName}}";
    $tags[$tagsIndex++] = "{{LastName}}";
    $tags[$tagsIndex++] = "{{Email}}";
    $tags[$tagsIndex++] = "{{Mobile}}";
    $tags[$tagsIndex++] = "{{Address1}}";
    $tags[$tagsIndex++] = "{{Address2}}";
    $tags[$tagsIndex++] = "{{City}}";
    $tags[$tagsIndex++] = "{{State}}";
    $tags[$tagsIndex++] = "{{Country}}";
    $tags[$tagsIndex++] = "{{ZipCode}}";

    return $tags;
}

function getReplacedPersonTagsForEmail($personModel)
{
    $tags = array();
    $tagsIndex = 0;
    //$tags[$tagsIndex++] = "{{WebsiteLogo}}";
    $tags[$tagsIndex++] = $personModel->person_first_name;
    $tags[$tagsIndex++] = $personModel->person_last_name;
    $tags[$tagsIndex++] = $personModel->person_email;
    $tags[$tagsIndex++] = $personModel->person_phone;
    $tags[$tagsIndex++] = $personModel->person_address_line1;
    $tags[$tagsIndex++] = $personModel->person_address_line2;
    $tags[$tagsIndex++] = $personModel->person_city;
    $tags[$tagsIndex++] = $personModel->person_state;
    $tags[$tagsIndex++] = $personModel->person_country;
    $tags[$tagsIndex++] = $personModel->person_zipcode;

    return $tags;
}

function getMailGroupTags($mailgroup_id)
{
    $mailGroupCustomFields = array();
    $tags = array();
    $mailGroupCustomFields = MailgroupCustomFields::model()->findAllByAttributes(array('mailgroup_id'=>$mailgroup_id));
    if($mailGroupCustomFields)
    {
        $tagIndex = 0;
        foreach($mailGroupCustomFields as $customFields)
        {
            $tags[$customFields->mailgroup_custom_id] = "{{".$customFields->custom_field_name."}}";
        }
    }
    return $tags;
}

function getPersonCustomTagValues($mailgroup_id, $person_id)
{
    $personValueModel = PersonCustomValues::model()->findAllByAttributes(array('mailgroup_id'=>$mailgroup_id, 'person_id'=>$person_id));
    $tags = array();
    if($personValueModel)
    {
        $tagIndex = 0;
        foreach($personValueModel as $personValue)
        {

            $tags[$personValue->custom_field_id] = isset($personValue->person_custom_field_value) ? $personValue->person_custom_field_value : "";
        }
    }
    return $tags;
}

?>