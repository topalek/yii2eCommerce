<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210113_223455_add_firstname_lastname_to_user_table
 */
class m210113_223455_add_firstname_lastname_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(User::tableName(), 'firstname', $this->string(255)->notNull()->after('id'));
        $this->addColumn(User::tableName(), 'lastname', $this->string(255)->notNull()->after('firstname'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(User::tableName(), 'lastname');
        $this->dropColumn(User::tableName(), 'firstname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210113_223455_add_firstname_lastname_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
