<?php

/**
 * This is the model class for table "persons".
 *
 * The followings are the available columns in table 'persons':
 * @property integer $person_id
 * @property integer $user_id
 * @property string $user_code
 * @property string $person_code
 * @property string $person_first_name
 * @property string $person_last_name
 * @property string $person_email
 * @property string $person_phone
 * @property string $person_password
 * @property string $person_address_line1
 * @property string $person_address_line2
 * @property string $person_city
 * @property string $person_state
 * @property string $person_country
 * @property string $is_subscribed
 * @property integer $unsubscribe_stamp
 * @property string $is_notify_schemes
 * @property integer $unnotify_stamp
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property PersonMailgroupStats[] $personMailgroupStats
 */
class Persons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_first_name, person_last_name, person_email', 'required'),
			array('user_id, unsubscribe_stamp, unnotify_stamp', 'numerical', 'integerOnly'=>true),
            array('person_email', 'email'),
            array('person_email', 'unique', 'message'=>'Email already exists! Search Mailgroups for this email.'),
            
        	array('user_code, person_code, person_first_name, person_last_name, person_email, person_password, person_address_line1, person_address_line2, person_city, person_state, person_country, person_zipcode', 'length', 'max'=>255),
			array('is_subscribed, is_notify_schemes', 'length', 'max'=>1),
            array('person_phone', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person_id, user_id, user_code, person_code, person_first_name, person_last_name, person_email, person_password, person_address_line1, person_address_line2, person_city, person_state, person_country, person_zipcode, is_subscribed, unsubscribe_stamp, is_notify_schemes, unnotify_stamp, created_on', 'safe', 'on'=>'search'),
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
			'personMailgroupStats' => array(self::HAS_MANY, 'PersonMailgroupStats', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'person_id' => 'Person',
			'user_id' => 'User',
			'user_code' => 'User Code',
			'person_code' => 'Person Code',
			'person_first_name' => 'Person First Name',
			'person_last_name' => 'Person Last Name',
			'person_email' => 'Person Email',
			'person_phone' => 'Person Phone',
			'person_password' => 'Person Password',
			'person_address_line1' => 'Person Address Line1',
			'person_address_line2' => 'Person Address Line2',
			'person_city' => 'Person City',
			'person_state' => 'Person State',
			'person_country' => 'Person Country',
            'person_zipcode' => 'Person Zipcode',
			'is_subscribed' => 'Is Subscribed',
			'unsubscribe_stamp' => 'Unsubscribe Stamp',
			'is_notify_schemes' => 'Is Notify Schemes',
			'unnotify_stamp' => 'Unnotify Stamp',
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

		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_code',$this->user_code,true);
		$criteria->compare('person_code',$this->person_code,true);
		$criteria->compare('person_first_name',$this->person_first_name,true);
		$criteria->compare('person_last_name',$this->person_last_name,true);
		$criteria->compare('person_email',$this->person_email,true);
		$criteria->compare('person_phone',$this->person_phone,true);
		$criteria->compare('person_password',$this->person_password,true);
		$criteria->compare('person_address_line1',$this->person_address_line1,true);
		$criteria->compare('person_address_line2',$this->person_address_line2,true);
		$criteria->compare('person_city',$this->person_city,true);
		$criteria->compare('person_state',$this->person_state,true);
		$criteria->compare('person_country',$this->person_country,true);
		$criteria->compare('person_zipcode',$this->person_zipcode,true);
		$criteria->compare('is_subscribed',$this->is_subscribed,true);
		$criteria->compare('unsubscribe_stamp',$this->unsubscribe_stamp);
		$criteria->compare('is_notify_schemes',$this->is_notify_schemes,true);
		$criteria->compare('unnotify_stamp',$this->unnotify_stamp);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Persons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
