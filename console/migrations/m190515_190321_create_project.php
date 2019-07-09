<?php

use yii\db\Migration;

/**
 * Class m190515_190321_create_project
 */
class m190515_190321_create_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project',[
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue('0'),
            'creator_id' =>$this->integer()->notNull(),
            'updater_id' =>$this->integer()->null(),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  =>$this->integer()->null(),
        ]);
        $this->addForeignKey('fk_project_to_user1',
            'project', ['creator_id'],
            'user',['id']
        );
        $this->addForeignKey('fk_project_to_user2',
            'project', ['updater_id'],
            'user',['id']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_190321_create_project cannot be reverted.\n";

        return false;
    }
    */
}
