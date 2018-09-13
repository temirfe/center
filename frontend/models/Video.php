<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $views
 * @property string $title
 * @property string $description
 * @property string $link
 * @property string $video_id
 * @property string $thumb
 * @property string $date_create
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link',], 'required'],
            [['date_create','video_id','views'], 'safe'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 1000],
            [['link', 'thumb'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'link' => Yii::t('app', 'Link'),
            'thumb' => Yii::t('app', 'Thumb'),
            'date_create' => Yii::t('app', 'Date Create'),
            'views' => Yii::t('app', 'Views'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->link, $match)) {
                $this->video_id=$match[1];
                $this->thumb="https://img.youtube.com/vi/".$this->video_id ."/mqdefault.jpg";

            }

            return true;
        } else {
            return false;
        }
    }


}
