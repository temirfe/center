<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $image
 * @property string $date_start
 * @property string $date_end
 * @property string $place
 * @property string $latlong
 * @property string $hosted_by
 */
class Event extends MyModel
{
    public $project_id;
    public $panelist = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['title'], 'required'],
            [['text'], 'string'],
            [['date_start', 'date_end', 'panelist', 'project_id'], 'safe'],
            [['title', 'description', 'place'], 'string', 'max' => 500],
            [['image'], 'string', 'max' => 200],
            [['latlong'], 'string', 'max' => 250],
            [['hosted_by'], 'string', 'max' => 255],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Subject'),
            'description' => Yii::t('app', 'Description'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
            'imageFile' => Yii::t('app', 'Image File'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'place' => Yii::t('app', 'Place'),
            'latlong' => Yii::t('app', 'Map link'),
            'hosted_by' => Yii::t('app', 'Hosted By'),
            'panelist' => Yii::t('app', 'Panelist'),
            'project_id' => Yii::t('app', 'Project'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->panelist) {
            $dao = Yii::$app->db;
            $dao->createCommand()->delete('participant', ['model_name' => 'event', 'model_id' => $this->id])->execute();
            foreach ($this->panelist as $panelist) {
                if ($panelist) {
                    $dao->createCommand()->insert('participant', [
                        'expert_id' => $panelist,
                        'model_name' => 'event',
                        'model_id' => $this->id,
                    ])->execute();
                }
            }
        }
    }

    public function getStatus()
    {
        return self::getStatusStatic($this->date_start, $this->date_end);
    }

    public static function getStatusStatic($date_start, $date_end)
    {
        $time = time();
        $start = strtotime($date_start);
        $end = strtotime($date_end);
        $register = false;
        if ($end) {
            if ($end < $time) {
                $msg = Yii::t('app', 'Past event');
            } else if ($start < $time) {
                $msg = Yii::t('app', 'Going');
            } else {
                $msg = Yii::t('app', 'Upcoming event');
                $register = true;
            }
        } else {
            if ($start < $time) {
                $msg = Yii::t('app', 'Past event');
            } else {
                $msg = Yii::t('app', 'Upcoming event');
                $register = true;
            }
        }
        return array('msg' => $msg, 'register' => $register);
    }

    public function getDates()
    {
        $start = strtotime($this->date_start);
        if ($this->date_end) {
            $end = strtotime($this->date_end);
            if (date('d-m', $start) == date('d-m', $end)) {
                $start_date = Yii::$app->formatter->asDatetime($start, 'EEEE, d MMMM, y H:mm');
                $end_date = " - " . Yii::$app->formatter->asTime($end, 'H:mm');
            } else {
                $start_date = Yii::$app->formatter->asDatetime($start, 'd MMMM H:mm');
                $end_date = " - " . Yii::$app->formatter->asDatetime($end, 'H:mm d MMMM, y');
            }
        } else {
            $start_date = Yii::$app->formatter->asDatetime($start, 'EEEE, d MMMM, y H:mm');
            $end_date = '';
        }



        return ['start' => $start_date, 'end' => $end_date];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $dao = Yii::$app->db;
            $dao->createCommand()->update('depend', ['last_update' => time()], 'table_name="event"')->execute();

            $prev = $dao->createCommand("SELECT * FROM project_items WHERE item_id='{$this->id}' AND item='event'")->queryOne();
            if ($this->project_id) {
                if ($prev) {
                    if ($prev['project_id'] != $this->project_id) {
                        $dao->createCommand()->update('project_items', ['project_id' => $this->project_id], ['id' => $prev['id']])->execute();
                    }
                } else {
                    $dao->createCommand()->insert('project_items', ['project_id' => $this->project_id, 'item' => 'event', 'item_id' => $this->id])->execute();
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
