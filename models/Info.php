<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property int $id
 * @property string|null $inn
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $patro
 * @property float|null $debt
 * @property float|null $pension_debt
 * @property float|null $medical_debt
 * @property float|null $social_debt
 * @property string|null $status_date
 * @property string|null $create_date
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
            [['debt', 'pension_debt', 'medical_debt', 'social_debt'], 'number'],
            [['status_date', 'create_date'], 'safe'],
            [['inn', 'name', 'surname', 'patro'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inn' => 'Inn',
            'name' => 'Name',
            'surname' => 'Surname',
            'patro' => 'Patro',
            'debt' => 'Debt',
            'pension_debt' => 'Pension Debt',
            'medical_debt' => 'Medical Debt',
            'social_debt' => 'Social Debt',
            'status_date' => 'Status Date',
            'create_date' => 'Create Date',
        ];
    }
}
