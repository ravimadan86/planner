<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property integer $account_id
 * @property string $role
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip_code
 * @property string $company_name
 * @property integer $timezone_offset
 * @property string $is_active
 * @property string $last_modified_time
 * @property string $registration_token
 * @property string $forgot_token
 * @property string $created_on
 *  
 * The followings are the available model relations:
 * @property Accounts[] $accounts
 * @property Mailgroups[] $mailgroups
 * @property Surveys[] $surveys
 * @property Templates[] $templates
 * @property Accounts $account
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, role, email, first_name', 'required'),
            array('account_id, timezone_offset', 'numerical', 'integerOnly'=>true),
			array('role, email, password, first_name, last_name, address_line_1, address_line_2, city, state, country, zip_code, company_name, registration_token, forgot_token', 'length', 'max'=>255),
			array('is_active', 'length', 'max'=>1),
            array('email','email'),
			array('last_modified_time, created_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, account_id, role, email, password, first_name, last_name, address_line_1, address_line_2, city, state, country, zip_code, company_name, is_active, last_modified_time, registration_token, forgot_token, created_on', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'accounts' => array(self::HAS_MANY, 'Accounts', 'owner_id'),
			'mailgroups' => array(self::HAS_MANY, 'Mailgroups', 'user_id'),
			'surveys' => array(self::HAS_MANY, 'Surveys', 'user_id'),
			'templates' => array(self::HAS_MANY, 'Templates', 'user_id'),
			'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
            'account_id' => 'Account',
			'role' => 'Role',
			'email' => 'Email',
			'password' => 'Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address_line_1' => 'Address Line 1',
			'address_line_2' => 'Address Line 2',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'zip_code' => 'Zip Code',
			'company_name' => 'Organisation',
            'timezone_offset' => 'Timezone Offset',
			'is_active' => 'Status',
			'last_modified_time' => 'Last Modified Time',
			'registration_token' => 'Registration Token',
			'forgot_token' => 'Forgot Token',
			'created_on' => 'Created On',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
        $criteria->compare('account_id',$this->account_id);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address_line_1',$this->address_line_1,true);
		$criteria->compare('address_line_2',$this->address_line_2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('company_name',$this->company_name,true);
        $criteria->compare('timezone_offset',$this->timezone_offset);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('last_modified_time',$this->last_modified_time,true);
		$criteria->compare('registration_token',$this->registration_token,true);
		$criteria->compare('forgot_token',$this->forgot_token,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
