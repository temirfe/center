<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "opinion".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $image
 * @property integer $expert_id
 *
 * @property Expert $expert
 */
class Opinion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'opinion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'description', 'image'], 'required'],
            [['expert_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['image'], 'string', 'max' => 200],
            [['expert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Expert::className(), 'targetAttribute' => ['expert_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'expert_id' => Yii::t('app', 'Expert ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpert()
    {
        return $this->hasOne(Expert::className(), ['id' => 'expert_id']);
    }
}
