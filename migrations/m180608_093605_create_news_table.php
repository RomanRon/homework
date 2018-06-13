<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180608_093605_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'short_description' => $this->string(255),
            'description' => $this->text(),
            'img' => $this->char(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
