<?php

use yii\db\Migration;

/**
 * Class m191227_234111_init
 */
class m191227_234111_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('public.user', [
            'iin_bin' => $this->string(),

            'name_ru' => $this->string(),
            'name_kk' => $this->string(),
            'total_arrear' => $this->float(),
            'total_tax_arrear' => $this->float(),
            'pension_contribution_arrear' => $this->float(),
            'social_contribution_arrear' => $this->float(),
            'social_health_insurance_arrear' => $this->float(),
        ]);
        $this->execute('ALTER TABLE public.user ADD PRIMARY KEY (iin_bin)');

        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'user_iin_bin' => $this->string(),
            'sendTime' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'FK_request__TO__user__ON__user_iin_bin',
            'request',
            'user_iin_bin',
            'public.user',
            'iin_bin'
        );

        $this->createTable('organisation', [
            'char_code' => $this->string(),

            'name_ru' => $this->string(),
            'name_kk' => $this->string(),

            'report_acrual_date' => $this->timestamp(),
        ]);
        $this->execute('ALTER TABLE organisation ADD PRIMARY KEY (char_code)');

        $this->createTable('arrear', [
            'user_iin_bin' => $this->string(),
            'organisation_char_code' => $this->string(),

            'bcc' => $this->string(),

            'bcc_name_ru' => $this->string(),
            'bcc_name_kz' => $this->string(),
            'tax_arrear' => $this->float(),
            'poena_arrear' => $this->float(),
            'percent_arrear' => $this->float(),
            'fine_arrear' => $this->float(),
            'total_arrear' => $this->float(),
        ]);
        $this->execute('ALTER TABLE arrear ADD PRIMARY KEY (bcc)');
        $this->addForeignKey(
            'FK_arrear__TO__user__ON__user_iin_bin',
            'arrear',
            'user_iin_bin',
            'public.user',
            'iin_bin'
        );
        $this->createIndex(
            'INDEX_arrear_user_iin_bin',
            'arrear',
            'user_iin_bin'
        );
        $this->addForeignKey(
            'FK_arrear__TO__organisation__ON__organisation_char_code',
            'arrear',
            'organisation_char_code',
            'organisation',
            'char_code',
            'CASCADE'
        );
        $this->createIndex(
            'INDEX_arrear_organisation_char_code',
            'arrear',
            'organisation_char_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('public.user');
        $this->dropTable('request');
        $this->dropTable('organisation');
        $this->dropTable('arrear');

        return true;
    }
}
