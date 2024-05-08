<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback_tb".
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $status
 * @property string $subject
 * @property string $message
 * @property string|null $reply
 * @property string $date_sent
 * @property string|null $date_reply
 *
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'status', 'subject', 'message'], 'required'],
            [['user_id'], 'integer'],
            [['message', 'reply'], 'string'],
            [['date_sent', 'date_reply'], 'safe'],
            [['email', 'status'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'email' => 'From',
            'status' => 'Status',
            'subject' => 'Subject',
            'message' => 'Message',
            'reply' => 'Reply',
            'date_sent' => 'Date Sent',
            'date_reply' => 'Date Reply',
        ];
    }
}
