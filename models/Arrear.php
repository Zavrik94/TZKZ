<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arrear".
 *
 * @property string|null $user_iin_bin
 * @property string|null $organisation_char_code
 * @property string $bcc
 * @property string|null $bcc_name_ru
 * @property string|null $bcc_name_kz
 * @property float|null $tax_arrear
 * @property float|null $poena_arrear
 * @property float|null $percent_arrear
 * @property float|null $fine_arrear
 * @property float|null $total_arrear
 *
 * @property Organisation $organisationCharCode
 * @property User $userIinBin
 */
class Arrear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arrear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bcc'], 'required'],
            [['tax_arrear', 'poena_arrear', 'percent_arrear', 'fine_arrear', 'total_arrear'], 'number'],
            [['user_iin_bin', 'organisation_char_code', 'bcc', 'bcc_name_ru', 'bcc_name_kz'], 'string', 'max' => 255],
            [['bcc'], 'unique'],
            [['organisation_char_code'], 'exist', 'skipOnError' => true, 'targetClass' => Organisation::className(), 'targetAttribute' => ['organisation_char_code' => 'char_code']],
            [['user_iin_bin'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_iin_bin' => 'iin_bin']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_iin_bin' => 'User Iin Bin',
            'organisation_char_code' => 'Organisation Char Code',
            'bcc' => 'Bcc',
            'bcc_name_ru' => 'Bcc Name Ru',
            'bcc_name_kz' => 'Bcc Name Kz',
            'tax_arrear' => 'Tax Arrear',
            'poena_arrear' => 'Poena Arrear',
            'percent_arrear' => 'Percent Arrear',
            'fine_arrear' => 'Fine Arrear',
            'total_arrear' => 'Total Arrear',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationCharCode()
    {
        return $this->hasOne(Organisation::className(), ['char_code' => 'organisation_char_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIinBin()
    {
        return $this->hasOne(User::className(), ['iin_bin' => 'user_iin_bin']);
    }
}
