<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_tb".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $message
 * @property string $status
 * @property string|null $deleted_on
 * @property string $created_on
 * @property string $updated_on
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'recipient_id', 'message'], 'required'],
            [['sender_id', 'recipient_id'], 'integer'],
            [['message', 'status'], 'string'],
            [['deleted_on', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender Name',
            'recipient_id' => 'Recipient Name',
            'message' => 'Message',
            'status' => 'Status',
            'deleted_on' => 'Deleted On',
            'created_on' => 'Sent On',
            'updated_on' => 'Updated On',
        ];
    }
}
