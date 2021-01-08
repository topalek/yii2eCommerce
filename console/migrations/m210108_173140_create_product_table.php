<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m210108_173140_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%product}}',
            [
                'id'          => $this->primaryKey(),
                'name'        => $this->string(255)->notNull()->comment('Name of the product'),
                'description' => $this->text()->comment('Description'),
                'image'       => $this->string(2000)->comment('Image'),
                'price'       => $this->decimal(10, 2)->notNull()->comment('Price'),
                'status'      => $this->tinyInteger(2)->notNull()->comment('Status'),
                'created_at'  => $this->integer(11),
                'updated_at'  => $this->integer(11),
                'created_by'  => $this->integer(11),
                'updated_by'  => $this->integer(11),
            ]
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-created_by}}',
            '{{%product}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-product-updated_by}}',
            '{{%product}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-updated_by}}',
            '{{%product}}',
            'updated_by',
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
            '{{%fk-product-created_by}}',
            '{{%product}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product-updated_by}}',
            '{{%product}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-product-updated_by}}',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
