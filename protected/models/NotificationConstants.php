<?php

/**
 * This is the model class for table "notification_constants".
 *
 * The followings are the available columns in table 'notification_constants':
 * @property integer $notification_constant_id
 * @property integer $user_id
 * @property string $notification_const
 * @property string $notification_value
 * @property string $created_on
 */
class NotificationConstants extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notification_constants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, notification_const, notification_value, created_on', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('notification_const, notification_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_constant_id, user_id, notification_const, notification_value, created_on', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notification_constant_id' => 'Notification Constant',
			'user_id' => 'User',
			'notification_const' => 'Notification Const',
			'notification_value' => 'Notification Value',
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

		$criteria->compare('notification_constant_id',$this->notification_constant_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('notification_const',$this->notification_const,true);
		$criteria->compare('notification_value',$this->notification_value,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotificationConstants the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
