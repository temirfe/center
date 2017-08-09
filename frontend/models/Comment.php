<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $content
 * @property integer $user_id
 * @property string $model_name
 * @property integer $model_id
 * @property integer $public
 * @property integer $check
 */
class Comment extends \yii\db\ActiveRecord
{
    public $check;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['date'], 'safe'],
            [['user_id', 'model_id', 'public','check'], 'integer'],
            ['check', 'compare', 'compareValue' => 9, 'operator' => '==', 'type' => 'number'],
            [['name', 'model_name'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'user_id' => Yii::t('app', 'User ID'),
            'model_name' => Yii::t('app', 'Model Name'),
            'model_id' => Yii::t('app', 'Model ID'),
            'public' => Yii::t('app', 'Public'),
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'model_id']);
    }
    
}
