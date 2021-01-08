<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210108_175942_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%order}}',
            [
                'id'             => $this->primaryKey(),
                'total_price'    => $this->decimal(10, 2)->notNull(),
                'status'         => $this->tinyInteger(1)->notNull(),
                'firstname'      => $this->string(255)->notNull(),
                'lastname'       => $this->string(255)->notNull(),
                'email'          => $this->string(255)->notNull(),
                'transaction_id' => $this->string(255),
                'created_at'     => $this->integer(11),
                'created_by'     => $this->integer(11),
            ]
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-order-created_by}}',
            '{{%order}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-created_by}}',
            '{{%order}}',
            'created_by',
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
            '{{%fk-order-created_by}}',
            '{{%order}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-order-created_by}}',
            '{{%order}}'
        );

        $this->dropTable('{{%order}}');
    }
}
