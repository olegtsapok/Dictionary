<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property Company[] $companies1
 * @property Company[] $companies2
 * @property Company2user[] $company2users
 * @property Role $role0
 */
class User extends CActiveRecord
{
        public $new_password;
        
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
			array('first_name, email', 'required'),
			array('first_name, last_name', 'length', 'max'=>100),
			array('email', 'length', 'max'=>255),
			array('email', 'email'),
			array('email', 'validationEmail'),
			array('role', 'length', 'max'=>45),
			array('role', 'validationRole'),
			array('new_password', 'validationPassword'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, role', 'safe', 'on'=>'search'),
		);
	}

	public function validationRole($attribute,$params)
	{
            /*if (array_key_exists($this->role, CpRole::getAvailableRoles())
                 or (Yii::app()->user->checkAccess(CpRole::roleSuperAdmin)
                    and $this->role == CpRole::roleSuperAdmin)
            ) {
                return true;
            }
            $this->addError('role','Incorrect role.');/**/
                return true;
	}
	public function validationPassword($attribute,$params)
	{
            if (!$this->id and !$this->new_password) {
                $this->addError('new_password','Cant be empty');
            }
	}
	public function validationEmail($attribute,$params)
	{
            if (User::model()->findByAttributes(array('email' => $this->email))) {
                $this->addError('email','Email already exist');
            }
	}

	protected function beforeDelete()
	{
            if(parent::beforeDelete()) {
                if (Company::model()->findAllByAttributes(array(),
                    "billing_contact_id = :user_id or
                        technical_contact_id = :user_id or
                        owner_id = :user_id",
                    array(':user_id' => $this->id)
                )) {
                    throw new CHttpException(404, 'This user is used in company managing');
                }
                return true;
            } else {
                return false;
            }
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
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'new_password' => 'Password',
			'role' => 'Role',
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

                /*$criteria->together = true;
                $criteria->with = array(
                    'company2user',
                    'company2user.company',
                );/**/
		//$criteria->addInCondition('company.id', array(Yii::app()->company->getCurrentCompany()->id));

               
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.first_name',$this->first_name,true);
		$criteria->compare('t.last_name',$this->last_name,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.role',$this->role,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        //'pagination' => array('pageSize' => 1),
		));
	}

        public function beforeSave()
        {
            if ($this->new_password) {
                $this->password = md5($this->new_password);
            }

            return parent::beforeSave();
        }

        protected function afterFind()
        {
            parent::afterFind();
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

        public function getCompany()
        {
            /*if (!($this->company)) {
                return new Company;
            }
            return $this->company;/**/
        }

        public function renderCompany($data,$row)
        {
            /*if (!isset($data->company2user[0])) {
                return '';
            }/**/
            //return $data->company2user[0]->company->name;
        }

        public function renderRole($data,$row = null)
        {
            /*if (!isset($data->user2role)) {
                return '';
            }/**/

            //return $data->user2role->name;
       }

}
