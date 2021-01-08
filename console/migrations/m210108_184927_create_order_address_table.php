<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_address}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%order}}`
 */
class m210108_184927_create_order_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%order_address}}',
            [
                'order_id' => $this->integer(11)->notNull(),
                'address'  => $this->string()->notNull(),
                'city'     => $this->string()->notNull(),
                'state'    => $this->string()->notNull(),
                'country'  => $this->string()->notNull(),
                'zipcode'  => $this->string(),
            ]
        );

        // creates Primary Key for column `order_id`
        $this->addPrimaryKey('{{%pk-order_address-order_id}}', '{{%order_address}}', 'order_id');

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-order_address-order_id}}',
            '{{%order_address}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-order_address-order_id}}',
            '{{%order_address}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-order_address-order_id}}',
            '{{%order_address}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-order_address-order_id}}',
            '{{%order_address}}'
        );

        $this->dropTable('{{%order_address}}');
    }
}
