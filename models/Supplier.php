<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_tb".
 *
 * @property int $id
 * @property string $contact_fname
 * @property string $contact_sname
 * @property string|null $contact_gender
 * @property string|null $contact_phone
 * @property string|null $company_name
 * @property string $contact_email
 * @property string|null $location
 * @property int|null $national_id
 * @property string|null $kra_pin
 * @property string $created_on
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_fname', 'contact_sname', 'contact_email'], 'required'],
            [['location'], 'string'],
            [['national_id'], 'integer'],
            [['created_on'], 'safe'],
            [['contact_fname', 'contact_sname', 'company_name'], 'string', 'max' => 100],
            [['contact_gender', 'contact_phone'], 'string', 'max' => 10],
            [['contact_email'], 'string', 'max' => 50],
            [['kra_pin'], 'string', 'max' => 12],
            [['contact_email'], 'unique'],
            [['company_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_fname' => 'Contact Fname',
            'contact_sname' => 'Contact Sname',
            'contact_gender' => 'Contact Gender',
            'contact_phone' => 'Contact Phone',
            'company_name' => 'Company Name',
            'contact_email' => 'Contact Email',
            'location' => 'Location',
            'national_id' => 'National ID',
            'kra_pin' => 'Kra Pin',
            'created_on' => 'Created On',
        ];
    }
}
