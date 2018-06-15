<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $name
 * @property string $short_description
 * @property string $description
 * @property string $img
 */
class News extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name', 'short_description', 'img'], 'string', 'max' => 255],
            [['name', 'short_description', 'description'], 'required'],
            [['file'], 'image'],
        ];
    }

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $dir = Yii::getAlias('uploads/');
            $this->img = $file->baseName.'.'.$file->extension;
            if (file_exists($dir . $this->img)) {
                unlink($dir . $this->img);
            }

            $file->saveAs($dir.$this->img);
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public
    function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_description' => Yii::t('app', 'Short Description'),
            'description' => Yii::t('app', 'Description'),
            'img' => Yii::t('app', 'Назва зображення'),
            'file' => Yii::t('app', 'Зображення'),
        ];
    }
}
