<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property int $id
 * @property string|null $iin_bin
 * @property string|null $name_ru
 * @property string|null $name_kk
 * @property float|null $total_arrear
 * @property float|null $total_tax_arrear
 * @property float|null $pension_contribution_arrear
 * @property float|null $social_contribution_arrear
 * @property float|null $social_health_insurance_arrear
 * @property string|null $send_time
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_arrear', 'total_tax_arrear', 'pension_contribution_arrear', 'social_contribution_arrear', 'social_health_insurance_arrear'], 'number'],
            [['send_time'], 'safe'],
            [['iin_bin', 'name_ru', 'name_kk'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iin_bin' => 'Iin Bin',
            'name_ru' => 'Name Ru',
            'name_kk' => 'Name Kk',
            'total_arrear' => 'Total Arrear',
            'total_tax_arrear' => 'Total Tax Arrear',
            'pension_contribution_arrear' => 'Pension Contribution Arrear',
            'social_contribution_arrear' => 'Social Contribution Arrear',
            'social_health_insurance_arrear' => 'Social Health Insurance Arrear',
            'send_time' => 'Send Time',
        ];
    }
}
