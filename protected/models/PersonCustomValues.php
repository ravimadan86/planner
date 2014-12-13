<?php

/**
 * This is the model class for table "person_custom_values".
 *
 * The followings are the available columns in table 'person_custom_values':
 * @property integer $person_custom_field_id
 * @property integer $custom_field_id
 * @property integer $mailgroup_id
 * @property integer $person_id
 * @property string $person_custom_field_value
 * @property string $created_on
 */
class PersonCustomValues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person_custom_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('custom_field_id, mailgroup_id, person_id', 'required'),
			array('custom_field_id, mailgroup_id, person_id', 'numerical', 'integerOnly'=>true),
			array('person_custom_field_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person_custom_field_id, custom_field_id, mailgroup_id, person_id, person_custom_field_value, created_on', 'safe', 'on'=>'search'),
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
			'person_custom_field_id' => 'Person Custom Field',
			'custom_field_id' => 'Custom Field',
			'mailgroup_id' => 'Mailgroup',
			'person_id' => 'Person',
			'person_custom_field_value' => 'Person Custom Field Value',
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

		$criteria->compare('person_custom_field_id',$this->person_custom_field_id);
		$criteria->compare('custom_field_id',$this->custom_field_id);
		$criteria->compare('mailgroup_id',$this->mailgroup_id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('person_custom_field_value',$this->person_custom_field_value,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersonCustomValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
