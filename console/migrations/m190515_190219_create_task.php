<?php

use yii\db\Migration;

/**
 * Class m190515_190219_create_task
 */
class m190515_190219_create_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task',[
            'id' =>$this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer()->null(),
            'executor_id' => $this->integer()->null(),
            'started_at' => $this->integer()->null(),
            'completed_at' => $this->integer()->null(),
            'creator_id'  => $this->integer()->notNull(),
            'updater_id'  => $this->integer()->null(),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  =>$this->integer()->null(),
        ]);
        $this->addForeignKey('fk_task_to_user1',
            'task', ['executor_id'],
            'user',['id']
        );
        $this->addForeignKey('fk_task_to_user2',
            'task', ['creator_id'],
            'user',['id']
        );
        $this->addForeignKey('fk_task_to_user3',
            'task', ['updater_id'],
            'user',['id']
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_190219_create_task cannot be reverted.\n";

        return false;
    }
    */
}
