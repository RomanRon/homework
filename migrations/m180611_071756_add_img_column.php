<?php

use yii\db\Migration;

/**
 * Class m180611_071756_add_img_column
 */
class m180611_071756_add_img_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%news}}', 'img_src', 'string(255)');

        $this->addColumn('{{%news}}', 'img_web', 'string(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%news}}', 'img_src');

        $this->dropColumn('{{%news}}', 'img_web');

    }

}
