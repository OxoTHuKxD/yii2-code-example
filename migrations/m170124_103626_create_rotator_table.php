<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rotator`.
 */
class m170124_103626_create_rotator_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%rotator}}', [
            'id' => $this->primaryKey(),
            'webmaster_id' => $this->integer(),
            'name' => $this->string(),
            'slot_count' => $this->integer(),
            'layout' => $this->integer(),
            'text_exist' => $this->boolean(),
            'text_position' => $this->integer(),
            'border_color' => $this->string(),
            'border_width' => $this->float(),
            'separator_width' => $this->float(),
            'background_color' => $this->string(),
            'padding_horizontal' => $this->float(),
            'padding_vertical' => $this->float()
        ]);

        $this->createIndex('idx-rotator-webmaster_id', '{{%rotator}}', 'webmaster_id');
        $this->addForeignKey('fk-rotator-webmaster_id', '{{%rotator}}', 'webmaster_id', '{{%webmaster}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-rotator-webmaster_id', '{{%rotator}}');
        $this->dropIndex('idx-rotator-webmaster_id', '{{%rotator}}');
        $this->dropTable('{{%rotator}}');
    }
}
