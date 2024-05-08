<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_tb".
 *
 * @property int $id
 * @property string $fname
 * @property string $sname
 * @property string $gender
 * @property string $phone_no
 * @property string $email
 * @property string|null $location
 * @property string|null $address
 * @property string|null $postal_code
 * @property string $created_on
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fname', 'sname', 'gender', 'phone_no', 'email'], 'required'],
            ['email','unique'],
            [['created_on'], 'safe'],
            [['fname', 'sname'], 'string', 'max' => 255],
            [['gender', 'phone_no', 'email', 'location', 'address', 'postal_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'First Name',
            'sname' => 'Last Name',
            'gender' => 'Gender',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'location' => 'Location',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'created_on' => 'Created On',
        ];
    }
}
