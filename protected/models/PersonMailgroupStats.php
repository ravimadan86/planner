<?php

/**
 * This is the model class for table "person_mailgroup_stats".
 *
 * The followings are the available columns in table 'person_mailgroup_stats':
 * @property integer $person_mailgroup_id
 * @property integer $person_id
 * @property integer $mailgroup_id
 * @property string $is_subscribed
 * @property integer $mailgroup_subscribe_stamp
 * @property integer $mailgroup_unsubscribe_stamp
 * @property integer $mailgroup_bounced_stamp
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Mailgroups $mailgroup
 * @property Persons $person
 */
class PersonMailgroupStats extends CActiveRecord
{
    public $person_custom_name; 
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person_mailgroup_stats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, mailgroup_id', 'required'),
			array('person_id, mailgroup_id, mailgroup_subscribe_stamp, mailgroup_unsubscribe_stamp, mailgroup_bounced_stamp', 'numerical', 'integerOnly'=>true),
			array('is_subscribed', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person_mailgroup_id, person_id, person_custom_name, mailgroup_id, is_subscribed, mailgroup_subscribe_stamp, mailgroup_unsubscribe_stamp, mailgroup_bounced_stamp, created_on', 'safe', 'on'=>'search'),
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
			'mailgroup' => array(self::BELONGS_TO, 'Mailgroups', 'mailgroup_id'),
			'person' => array(self::BELONGS_TO, 'Persons', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'person_mailgroup_id' => 'Person Mailgroup',
			'person_id' => 'Person',
			'mailgroup_id' => 'Mailgroup',
			'is_subscribed' => 'Subscribed?',
            'person_custom_name' => 'Person Name',
			'mailgroup_subscribe_stamp' => 'Mailgroup Subscribe Stamp',
			'mailgroup_unsubscribe_stamp' => 'Mailgroup Unsubscribe Stamp',
			'mailgroup_bounced_stamp' => 'Mailgroup Bounced Stamp',
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
        $criteria->with = array(
            'mailgroup',
            'person',
        );

		$criteria->compare('person_mailgroup_id',$this->person_mailgroup_id);
		$criteria->compare('t.person_id',$this->person_id);
		$criteria->compare('t.mailgroup_id',$this->mailgroup_id);
		$criteria->compare('t.is_subscribed',$this->is_subscribed,true);
		$criteria->compare('CONCAT(person.person_first_name," ",person.person_last_name)',$this->person_custom_name,true);
		$criteria->compare('mailgroup_subscribe_stamp',$this->mailgroup_subscribe_stamp);
		$criteria->compare('mailgroup_unsubscribe_stamp',$this->mailgroup_unsubscribe_stamp);
		$criteria->compare('mailgroup_bounced_stamp',$this->mailgroup_bounced_stamp);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'attributes'=>array(
                    'person_custom_name'=>array(
                        'asc'=>'CONCAT(person.person_first_name," ",person.person_last_name)',
                        'desc'=>'CONCAT(person.person_first_name," ",person.person_last_name) DESC',
                    ),
                    '*',
                ),
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersonMailgroupStats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
