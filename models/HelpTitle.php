<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "help_title".
 *
 * @property int $id
 * @property string $title
 * @property int $deleted
 * @property string $created_on
 *
 */
class HelpTitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'help_title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'deleted' => 'Deleted',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[HelpTbs]].
     *
     * @return \yii\db\ActiveQuery
     */

}
