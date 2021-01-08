<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_address}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210108_174927_create_user_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%user_address}}',
            [
                'id'      => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'address' => $this->string()->notNull(),
                'city'    => $this->string()->notNull(),
                'state'   => $this->string()->notNull(),
                'country' => $this->string()->notNull(),
                'zipcode' => $this->string(),
            ]
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_address-user_id}}',
            '{{%user_address}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_address-user_id}}',
            '{{%user_address}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_address-user_id}}',
            '{{%user_address}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_address-user_id}}',
            '{{%user_address}}'
        );

        $this->dropTable('{{%user_address}}');
    }
}
