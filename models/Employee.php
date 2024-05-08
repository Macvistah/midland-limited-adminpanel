<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_tb".
 *
 * @property int $id
 * @property string $fname
 * @property string $sname
 * @property string $gender
 * @property string $national_id
 * @property string $email
 * @property string $phone_no
 * @property string $marital_status
 * @property string $role
 * @property string|null $location
 * @property string|null $address
 * @property string|null $postal_code
 * @property string $created_on
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fname', 'sname', 'gender', 'national_id', 'email', 'phone_no', 'marital_status', 'role'], 'required'],
            [['created_on'], 'safe'],
            [['fname', 'sname', 'gender', 'location'], 'string', 'max' => 255],
            [['national_id', 'email', 'phone_no', 'marital_status', 'role', 'address', 'postal_code'], 'string', 'max' => 100],
            [['national_id'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Firstname',
            'sname' => 'Lastname',
            'gender' => 'Gender',
            'national_id' => 'National ID',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'marital_status' => 'Marital Status',
            'role' => 'Role',
            'location' => 'Location',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'created_on' => 'Created On',
        ];
    }
}
