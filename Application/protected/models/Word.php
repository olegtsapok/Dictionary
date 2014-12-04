<?php

/**
 * This is the model class for table "word".
 *
 * The followings are the available columns in table 'word':
 * @property integer $id
 * @property string $word
 * @property string $translation
 * @property integer $dictionary_id
 *
 * The followings are the available model relations:
 * @property Learned[] $learneds
 * @property Dictionary $dictionary
 */
class Word extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'word';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dictionary_id', 'numerical', 'integerOnly'=>true),
			array('word, translation', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, word, translation, dictionary_id', 'safe', 'on'=>'search'),
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
			'learneds' => array(self::HAS_MANY, 'Learned', 'word_id'),
			'dictionary' => array(self::BELONGS_TO, 'Dictionary', 'dictionary_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'word' => 'Word',
			'translation' => 'Translation',
			'dictionary_id' => 'Dictionary',
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
		$criteria->compare('t.word',$this->word,true);
		$criteria->compare('t.translation',$this->translation,true);
		$criteria->compare('t.dictionary_id',$this->dictionary_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Word the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
