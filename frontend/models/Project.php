<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class Project extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $rules = [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(), $rules);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete('project');
    }
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        Yii::$app->cache->delete('project');
        return parent::afterDelete();
    }
}
