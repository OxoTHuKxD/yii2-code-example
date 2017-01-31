<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banner`.
 */
class m170124_110126_create_banner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'rotator_id' => $this->integer()->null(),
            'template_id' => $this->integer(),
            'program_id' => $this->integer(),
            'link' => $this->string(),
            'status' => $this->integer(),
            'stop_shows' => $this->integer(),
            'stop_conversion' => $this->float(),
            'description' => $this->string()
        ]);

        $this->createIndex('idx-banner-rotator_id', '{{%banner}}', 'rotator_id');
        $this->addForeignKey('fk-banner-rotator_id', '{{%banner}}', 'rotator_id', '{{%rotator}}', 'id', 'SET NULL');

        $this->createIndex('idx-banner-template_id', '{{%banner}}', 'template_id');
        $this->addForeignKey('fk-banner-template_id', '{{%banner}}', 'template_id', '{{%banner_template}}', 'id', 'CASCADE');

        $this->createIndex('idx-banner-program_id', '{{%banner}}', 'program_id');
        $this->addForeignKey('fk-banner-program_id', '{{%banner}}', 'program_id', '{{%program}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-banner-rotator_id', '{{%banner}}');
        $this->dropIndex('idx-banner-rotator_id', '{{%banner}}');
        $this->dropForeignKey('fk-banner-template_id', '{{%banner}}');
        $this->dropIndex('idx-banner-template_id', '{{%banner}}');
        $this->dropForeignKey('fk-banner-program_id', '{{%banner}}');
        $this->dropIndex('idx-banner-program_id', '{{%banner}}');
        $this->dropTable('{{%banner}}');
    }
}
