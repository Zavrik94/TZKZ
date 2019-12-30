<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organisation".
 *
 * @property string $char_code
 * @property string $name_ru
 * @property string $name_kk
 * @property string $report_acrual_date
 *
 * @property Arrear[] $arrears
 */
class Organisation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organisation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['char_code', 'name_ru', 'name_kk', 'report_acrual_date'], 'required'],
            [['report_acrual_date'], 'safe'],
            [['char_code', 'name_ru', 'name_kk'], 'string', 'max' => 255],
            [['char_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'char_code' => 'Char Code',
            'name_ru' => 'Name Ru',
            'name_kk' => 'Name Kk',
            'report_acrual_date' => 'Report Acrual Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrears()
    {
        return $this->hasMany(Arrear::className(), ['organisation_char_code' => 'char_code']);
    }
}
