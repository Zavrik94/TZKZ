<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 * @property int          $id
 * @property string|null  $user_iin_bin
 * @property string|null  $send_time
 * @property string|null  $our_request
 * @property string|null  $gov_response
 * @property bool|null    $is_ok
 * @property integer|null $anti_capcha_task_id
 * @property User         $userIinBin
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
            [['is_ok'], 'boolean'],
            [['send_time'], 'safe'],
            [['our_request', 'gov_response'], 'string'],
            [['anti_capcha_task_id'], 'integer'],
            [['user_iin_bin'], 'string', 'max' => 255],

            [['user_iin_bin'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_iin_bin' => 'iin_bin']],
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
            'send_time' => 'Send Time',
            'our_request' => 'Our Request',
            'gov_response' => 'Gov Response',
            'is_ok' => 'Is Ok',
            'anti_capcha_task_id' => 'Anti Capcha Task ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIinBin()
    {
        return $this->hasOne(User::className(), ['iin_bin' => 'user_iin_bin']);
    }

    /**
     * {@inheritdoc}
     * @return RequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestQuery(get_called_class());
    }
}
