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
 * @property string $url
 * @property integer $expert_id
 *
 * @property Expert $expert
 */
class Opinion extends MyModel
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
            [['description',], 'required'],
            [['expert_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['url'], 'safe'],
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
            'name' => Yii::t('app', 'Full Name'),
            'title' => Yii::t('app', 'His/her Title'),
            'description' => Yii::t('app', 'Opinion'),
            'image' => Yii::t('app', 'Image'),
            'imageFile' => Yii::t('app', 'Image'),
            'expert_id' => Yii::t('app', 'Expert'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpert()
    {
        return $this->hasOne(Expert::className(), ['id' => 'expert_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->url=str_replace("http://","",$this->url);
            $this->url=str_replace("https://","",$this->url);
            $this->url="http://".$this->url;

            return true;
        } else {
            return false;
        }
    }
}
