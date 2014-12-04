<?php

/**
 * This is the model class for table "dictionary".
 *
 * The followings are the available columns in table 'dictionary':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $lang_source
 * @property string $lang_translation
 * @property string $created_dt
 * @property integer $user_id
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Language $langSource
 * @property Language $langTranslation
 * @property Word[] $words
 */
class Dictionary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dictionary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('name, lang_source, lang_translation', 'required'),
			array('lang_source, lang_translation', 'length', 'max'=>2),
			array('description, created_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, lang_source, lang_translation, created_dt, user_id, type', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'langSource' => array(self::BELONGS_TO, 'Language', 'lang_source'),
			'langTranslation' => array(self::BELONGS_TO, 'Language', 'lang_translation'),
			'words' => array(self::HAS_MANY, 'Word', 'dictionary_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'lang_source' => 'Lang Source',
			'lang_translation' => 'Lang Translation',
			'created_dt' => 'Created',
			'user_id' => 'User',
			'type' => 'Type (0 - private, 1 - common)',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.lang_source',$this->lang_source,true);
		$criteria->compare('t.lang_translation',$this->lang_translation,true);
		$criteria->compare('t.created_dt',$this->created_dt,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dictionary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
