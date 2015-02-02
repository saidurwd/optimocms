<?php

/**
 * This is the model class for table "{{subscriber_group}}".
 *
 * The followings are the available columns in table '{{subscriber_group}}':
 * @property integer $id
 * @property integer $parent
 * @property string $title
 * @property string $details
 * @property integer $status
 */
class SubscriberGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{subscriber_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent, title', 'required'),
			array('parent, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
			array('details', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent, title, details, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'parent' => 'Parent',
			'title' => 'Category',
			'details' => 'Details',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubscriberGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function get_title($id) {
		$value = SubscriberGroup::model()->findByAttributes(array('id' => $id));
		if (empty($value->title)) {
			return null;
		} else {
			return $value->title;
		}
	}
	
	public static function get_groups($id) {
		$model = Subscriber::model()->findByAttributes(array('id' => $id));
		$exval = explode(',', $model->groups);
		$groups = '';
		$total = count($exval);
		for ($i = 0; $i < $total; $i++) {
			if ($i == $total - 1) {
				$groups .= SubscriberGroup::get_title(trim($exval[$i])) . ' ';
			} else {
				$groups .= SubscriberGroup::get_title(trim($exval[$i])) . ', ';
			}
		}
		return $groups;
	}
}
