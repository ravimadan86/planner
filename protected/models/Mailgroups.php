<?php

/**
 * This is the model class for table "mailgroups".
 *
 * The followings are the available columns in table 'mailgroups':
 * @property integer $mailgroup_id
 * @property integer $user_id
 * @property string $mailgroup_name
 * @property integer $subscribe_count
 * @property integer $unsubscribe_count
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property PersonMailgroupStats[] $personMailgroupStats
 */
class Mailgroups extends CActiveRecord
{
    public $newmailgroup;
	
	/**
	 * @return string the associated database table name
	 */
    public function tableName()
	{
		return 'mailgroups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mailgroup_name', 'required'),
			array('user_id, subscribe_count, unsubscribe_count', 'numerical', 'integerOnly'=>true),
			array('mailgroup_name', 'length', 'max'=>255),
			array('newmailgroup', 'length', 'max'=>10),
			array('created_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mailgroup_id, user_id, mailgroup_name, subscribe_count, unsubscribe_count, created_on', 'safe', 'on'=>'search'),
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
			'personMailgroupStats' => array(self::HAS_MANY, 'PersonMailgroupStats', 'mailgroup_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mailgroup_id' => 'Mailgroup',
			'user_id' => 'User',
			'mailgroup_name' => 'Mailgroup Name',
			'subscribe_count' => 'Subscribe Count',
			'unsubscribe_count' => 'Unsubscribe Count',
            'newmailgroup' => 'New Mail Group',
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

		$criteria->compare('mailgroup_id',$this->mailgroup_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('mailgroup_name',$this->mailgroup_name,true);
		$criteria->compare('subscribe_count',$this->subscribe_count);
		$criteria->compare('unsubscribe_count',$this->unsubscribe_count);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mailgroups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
