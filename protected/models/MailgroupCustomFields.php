<?php

/**
 * This is the model class for table "mailgroup_custom_fields".
 *
 * The followings are the available columns in table 'mailgroup_custom_fields':
 * @property integer $mailgroup_custom_id
 * @property integer $mailgroup_id
 * @property string $custom_field_name
 * @property string $custom_field_type
 * @property string $custom_field_tag
 * @property integer $custom_field_size
 * @property integer $custom_field_order
 * @property string $is_mandatory
 * @property string $created_on
 */
class MailgroupCustomFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mailgroup_custom_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mailgroup_id, custom_field_name, custom_field_type, custom_field_tag, custom_field_size', 'required'),
			array('mailgroup_id, custom_field_size, custom_field_order', 'numerical', 'integerOnly'=>true),
			array('custom_field_name, custom_field_type, custom_field_tag', 'length', 'max'=>255),
			array('is_mandatory', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mailgroup_custom_id, mailgroup_id, custom_field_name, custom_field_type, custom_field_tag, custom_field_size, custom_field_order, is_mandatory, created_on', 'safe', 'on'=>'search'),
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
			'mailgroup_custom_id' => 'Mailgroup Custom',
			'mailgroup_id' => 'Mailgroup',
			'custom_field_name' => 'Field Name',
			'custom_field_type' => 'Field Type',
			'custom_field_tag' => 'Field Identifier/Tag',
			'custom_field_size' => 'Field Size',
			'custom_field_order' => 'Field Order',
			'is_mandatory' => 'Is Mandatory',
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

		$criteria->compare('mailgroup_custom_id',$this->mailgroup_custom_id);
		$criteria->compare('mailgroup_id',$this->mailgroup_id);
		$criteria->compare('custom_field_name',$this->custom_field_name,true);
		$criteria->compare('custom_field_type',$this->custom_field_type,true);
		$criteria->compare('custom_field_tag',$this->custom_field_tag,true);
		$criteria->compare('custom_field_size',$this->custom_field_size);
		$criteria->compare('custom_field_order',$this->custom_field_order);
		$criteria->compare('is_mandatory',$this->is_mandatory,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MailgroupCustomFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
