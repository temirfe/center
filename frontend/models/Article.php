<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property integer $category_id
 * @property integer $expert_id
 * @property string $date_create
 * @property string $footnotes
 * @property string $custom_author
 * @property integer $own
 * @property integer $views
 * 
 * @property Comment $comments
 */
class Article extends MyModel
{
    public $project_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['title'], 'required'],
            [['text'], 'string'],
            [['category_id', 'expert_id', 'expert2_id', 'expert3_id', 'own', 'views'], 'integer'],
            [['date_create', 'custom_author', 'image', 'project_id'], 'safe'],
            [['title'], 'string', 'max' => 500],
            [['image'], 'string', 'max' => 200],
            [['footnotes'], 'string', 'max' => 1000],
            [['category_id', 'expert_id', 'expert2_id', 'expert3_id', 'own'], 'default', 'value' => 0]
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $rules = [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Subject'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
            'category_id' => Yii::t('app', 'Category'),
            'custom_author' => Yii::t('app', 'or Author'),
            'expert_id' => Yii::t('app', 'Expert'),
            'project_id' => Yii::t('app', 'Project'),
            'expert2_id' => Yii::t('app', 'Expert 2'),
            'expert3_id' => Yii::t('app', 'Expert 3'),
            'date_create' => Yii::t('app', 'Date Create'),
            'footnotes' => Yii::t('app', 'Footnotes'),
            'own' => Yii::t('app', 'Own article'),
            'views' => Yii::t('app', 'Views'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(), $rules);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    public function getExpert()
    {
        return $this->hasOne(Expert::className(), ['id' => 'expert_id']);
    }
    public function getExpert2()
    {
        return $this->hasOne(Expert::className(), ['id' => 'expert2_id']);
    }
    public function getExpert3()
    {
        return $this->hasOne(Expert::className(), ['id' => 'expert3_id']);
    }
    public function showExpert($int, $author)
    {
        if (!$author) return '';
        if ($int == 2) {
            $expert_img = $this->expert2->image;
            $expert_id = $this->expert2_id;
            $expert_desc = $this->expert2->description;
            $expert_name = $this->expert2->title;
        } else if ($int == 3) {
            $expert_img = $this->expert3->image;
            $expert_id = $this->expert3_id;
            $expert_desc = $this->expert3->description;
            $expert_name = $this->expert3->title;
        } else {
            $expert_img = $this->expert->image;
            $expert_id = $this->expert_id;
            $expert_desc = $this->expert->description;
            $expert_name = $this->expert->title;
        }
        $html = "<div class='mb20 oh'>";
        if ($expert_img)
            $img = Html::img("/images/expert/" . $expert_id . "/s_" . $expert_img, ['class' => 'round author_image_small']);
        else {
            $words = explode(" ", $expert_name);
            $acronym = "";

            foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
            }
            $img = "<div class='round initials_thumb'>" . $acronym . "</div>";
        }
        $url = Html::a($img, ['/expert/view', 'id' => $expert_id]);
        $html .= "<div class='pull-left mr15'>" . $url . "</div>";
        $html .= "<h2 class='name'>" . $author . '</h2>';
        $html .= "<span class='font12 color69'>" . $expert_desc . "</span>";
        $html .= "</div>";

        return $html;
    }

    public function getAuthors()
    {
        $author = '';
        $author2 = '';
        $author3 = '';
        $and1 = '';
        $and2 = '';
        if ($this->expert_id) {
            $author = $this->getAuthorLink(1);
        }
        if ($this->expert2_id) {
            $and1 = " " . Yii::t('app', 'and') . " ";
            $author2 = $this->getAuthorLink(2);
        }
        if ($this->expert3_id) {
            $and1 = ", ";
            $and2 = " " . Yii::t('app', 'and') . " ";
            $author3 = $this->getAuthorLink(3);
        }
        $authors = $author . $and1 . $author2 . $and2 . $author3;

        if ($this->custom_author) {
            if ($authors)
                $authors .= ", " . $this->custom_author;
            else
                $authors = $this->custom_author;
        }

        return $authors;
    }

    public function getAuthorLink($number)
    {
        $title = false;
        if ($number == 2) {
            $title = $this->expert2->title;
            $id = $this->expert2_id;
        } else if ($number == 3) {
            $title = $this->expert3->title;
            $id = $this->expert3_id;
        } else {
            if (isset($this->expert->title)) {
                $title = $this->expert->title;
                $id = $this->expert_id;
            }
        }
        if ($title) {
            $ret = Html::a($title, ['/expert/view', 'id' => $id], ['class' => 'darklink']);
        } else $ret = '';
        return $ret;
    }

    public function getLangTitle()
    {
        $msg = '';
        if (Yii::$app->language == 'ru-RU') {
            if (isset($this->category->title)) {
                $msg = $this->category->title;
            }
        } else {
            if (isset($this->category->title_en)) {
                $msg = $this->category->title_en;
            }
        }
        return $msg;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $dao = Yii::$app->db;
            $dao->createCommand()->update('depend', ['last_update' => time()], 'table_name="article"')->execute();
            $prev = $dao->createCommand("SELECT * FROM project_items WHERE item_id='{$this->id}' AND item='article'")->queryOne();
            if ($this->project_id) {
                if ($prev) {
                    if ($prev['project_id'] != $this->project_id) {
                        $dao->createCommand()->update('project_items', ['project_id' => $this->project_id], ['id' => $prev['id']])->execute();
                    }
                } else {
                    $dao->createCommand()->insert('project_items', ['project_id' => $this->project_id, 'item' => 'article', 'item_id' => $this->id])->execute();
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

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['model_id' => 'id']);
    }
    public function getItems()
    {
        return $this->hasMany(ProjectItems::className(), ['item_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $dao = Yii::$app->db;
        $dao->createCommand()->update('depend', ['last_update' => time()], 'table_name="article"')->execute();
        return parent::afterDelete();
    }
}
