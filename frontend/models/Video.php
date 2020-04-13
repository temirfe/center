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
    public $project_id;
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
            [['date_create', 'video_id', 'views', 'project_id'], 'safe'],
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
            'project_id' => Yii::t('app', 'Project'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->link, $match)) {
                $this->video_id = $match[1];
                $this->thumb = "https://img.youtube.com/vi/" . $this->video_id . "/mqdefault.jpg";
            }
            $dao = Yii::$app->db;
            $prev = $dao->createCommand("SELECT * FROM project_items WHERE item_id='{$this->id}' AND item='video'")->queryOne();
            if ($this->project_id) {
                if ($prev) {
                    if ($prev['project_id'] != $this->project_id) {
                        $dao->createCommand()->update('project_items', ['project_id' => $this->project_id], ['id' => $prev['id']])->execute();
                    }
                } else {
                    $dao->createCommand()->insert('project_items', ['project_id' => $this->project_id, 'item' => 'video', 'item_id' => $this->id])->execute();
                }
            } else {
                if ($prev) {
                    $dao->createCommand()->delete('project_items', ['id' => $prev['id']])->execute();
                }
            }

            return true;
        } else {
            return false;
        }
    }
    public function getItems()
    {
        return $this->hasMany(ProjectItems::className(), ['item_id' => 'id']);
    }
}
