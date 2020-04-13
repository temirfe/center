<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_items".
 *
 * @property int $id
 * @property string $item
 * @property int $project_id
 * @property int $item_id
 */
class ProjectItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item'], 'required'],
            [['project_id', 'item_id'], 'integer'],
            [['item'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item' => 'Item',
            'project_id' => 'Project ID',
            'item_id' => 'Item ID',
        ];
    }
}
