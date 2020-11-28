<?php

use yii\db\Migration;

/**
 * Class m201128_162318_add_chatbots_personality_forge
 */
class m201128_162318_add_chatbots_personality_forge extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pf_chatbot',
            [
                'id' => $this->primaryKey(),
                'pf_id' => $this->integer(),
                'age_rating' => 'CHAR(1)',
                'gender' => 'CHAR(1)',
                'name' => 'VARCHAR(255)',
                'credo' => 'VARCHAR(255)',
                'description' => 'VARCHAR(255)',
                'img_url' => 'VARCHAR(255)',
            ]
        );
        $this->execute(
            "INSERT INTO `pf_chatbot` VALUES (
                          NULL,
                          3374,
                          'T',
                          'F',
                          'genn',
                          'Friendly Human Artist',
                          'I`m curious about everything',
                          'https://www.personalityforge.com/images/faces/HoseFace.gif'
            )"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201128_162318_add_chatbots_personality_forge cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201128_162318_add_chatbots_personality_forge cannot be reverted.\n";

        return false;
    }
    */
}
