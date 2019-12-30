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

            'name_ru' => $this->string()->notNull(),
            'name_kk' => $this->string()->notNull(),
            'total_arrear' => $this->float()->notNull(),
            'total_tax_arrear' => $this->float()->notNull(),
            'pension_contribution_arrear' => $this->float()->notNull(),
            'social_contribution_arrear' => $this->float()->notNull(),
            'social_health_insurance_arrear' => $this->float()->notNull(),
        ]);
        $this->execute('ALTER TABLE public.user ADD PRIMARY KEY (iin_bin)');

        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'user_iin_bin' => $this->string()->notNull(),
            'sendTime' => $this->timestamp()->notNull(),
        ]);
        $this->addForeignKey(
            'FK_request__TO__user__ON__user_iin_bin',
            'request',
            'user_iin_bin',
            'public.user',
            'iin_bin'
        );
        $this->createIndex(
            'INDEX_request_user_iin_bin',
            'request',
            'user_iin_bin'
        );

        $this->createTable('organisation', [
            'char_code' => $this->string(),

            'name_ru' => $this->string()->notNull(),
            'name_kk' => $this->string()->notNull(),

            'report_acrual_date' => $this->timestamp()->notNull(),
        ]);
        $this->execute('ALTER TABLE organisation ADD PRIMARY KEY (char_code)');

        $this->createTable('arrear', [
            'user_iin_bin' => $this->string()->notNull(),
            'organisation_char_code' => $this->string()->notNull(),

            'bcc' => $this->string(),

            'bcc_name_ru' => $this->string()->notNull(),
            'bcc_name_kz' => $this->string()->notNull(),
            'tax_arrear' => $this->float()->notNull(),
            'poena_arrear' => $this->float()->notNull(),
            'percent_arrear' => $this->float()->notNull(),
            'fine_arrear' => $this->float()->notNull(),
            'total_arrear' => $this->float()->notNull(),
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
            'char_code'
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
        $this->execute('DROP TABLE request');
        $this->execute('DROP TABLE arrear');
        $this->execute('DROP TABLE organisation');
        $this->execute('DROP TABLE public.user');

        return true;
    }
}
