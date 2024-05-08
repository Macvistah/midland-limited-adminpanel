<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pick_up_points".
 *
 * @property int $id
 * @property string $p_name
 * @property float $charge
 */
class PickUpPoints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pick_up_points';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['p_name', 'charge'], 'required'],
            [['charge'], 'number'],
            [['p_name'], 'string', 'max' => 100],
            [['p_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'p_name' => 'Pick-up Point Name',
            'charge' => 'Charge',
        ];
    }
}
