<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string|null $user_iin_bin
 * @property string|null $sendTime
 *
 * @property User $userIinBin
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sendTime'], 'safe'],
            [['user_iin_bin'], 'string', 'max' => 255],
            [['user_iin_bin'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_iin_bin' => 'iin_bin']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_iin_bin' => 'User Iin Bin',
            'sendTime' => 'Send Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIinBin()
    {
        return $this->hasOne(User::className(), ['iin_bin' => 'user_iin_bin']);
    }
}
