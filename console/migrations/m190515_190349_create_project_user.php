<?php

use yii\db\Migration;

/**
 * Class m190515_190349_create_project_user
 */
class m190515_190349_create_project_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user',[
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => 'enum ("manager", "developer", "tester")',
        ]);
        $this->addForeignKey('fk_project_user_to_user',
            'project_user', ['user_id'],
            'user',['id']
        );
        $this->addForeignKey('fk_project_user_to_project',
            'project_user', ['project_id'],
            'project',['id']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project_user');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_190349_create_project_user cannot be reverted.\n";

        return false;
    }
    */
}
