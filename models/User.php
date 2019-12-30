<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $iin_bin
 * @property string|null $name_ru
 * @property string|null $name_kk
 * @property float|null $total_arrear
 * @property float|null $total_tax_arrear
 * @property float|null $pension_contribution_arrear
 * @property float|null $social_contribution_arrear
 * @property float|null $social_health_insurance_arrear
 *
 * @property Arrear[] $arrears
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iin_bin'], 'required'],
            [['total_arrear', 'total_tax_arrear', 'pension_contribution_arrear', 'social_contribution_arrear', 'social_health_insurance_arrear'], 'number'],
            [['iin_bin', 'name_ru', 'name_kk'], 'string', 'max' => 255],
            [['iin_bin'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iin_bin' => 'Iin Bin',
            'name_ru' => 'Name Ru',
            'name_kk' => 'Name Kk',
            'total_arrear' => 'Total Arrear',
            'total_tax_arrear' => 'Total Tax Arrear',
            'pension_contribution_arrear' => 'Pension Contribution Arrear',
            'social_contribution_arrear' => 'Social Contribution Arrear',
            'social_health_insurance_arrear' => 'Social Health Insurance Arrear',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrears()
    {
        return $this->hasMany(Arrear::className(), ['user_iin_bin' => 'iin_bin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['user_iin_bin' => 'iin_bin']);
    }
}
