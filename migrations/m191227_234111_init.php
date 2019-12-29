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
        $this->createTable('info', [
            'id' => $this->primaryKey(),
            'iin_bin' => $this->string(),
            'name_ru' => $this->string(),
            'name_kk' => $this->string(),
            'total_arrear' => $this->float(),
            'total_tax_arrear' => $this->float(),
            'pension_contribution_arrear' => $this->float(),
            'social_contribution_arrear' => $this->float(),
            'social_health_insurance_arrear' => $this->float(),

            'send_time' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('info');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191227_234111_init cannot be reverted.\n";

        return false;
    }
    */
}
