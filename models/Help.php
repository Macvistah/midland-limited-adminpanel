<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "help_tb".
 *
 * @property int $id
 * @property int $title_id
 * @property string $user_type
 * @property string $question
 * @property string $answer
 * @property string $created_on
 *
 * @property HelpTitle $title
 */
class Help extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'help_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_id', 'user_type', 'question', 'answer'], 'required'],
            [['title_id'], 'integer'],
            [['question', 'answer'], 'string'],
            [['created_on'], 'safe'],
            [['user_type'], 'string', 'max' => 100],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpTitle::className(), 'targetAttribute' => ['title_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_id' => 'Title',
            'user_type' => 'Visible To',
            'question' => 'Question',
            'answer' => 'Answer',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Title]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(HelpTitle::className(), ['id' => 'title_id']);
    }
}
