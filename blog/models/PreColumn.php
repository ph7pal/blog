<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%pre_column}}".
 *
 * @property integer $id
 * @property integer $belongid
 * @property string $title
 * @property string $name
 * @property integer $hot
 * @property integer $bold
 * @property integer $queue
 * @property integer $classify
 * @property integer $status
 */
class PreColumn extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pre_column';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['belongid', 'title', 'name', 'hot', 'bold', 'queue', 'status'], 'required'],
            [['belongid', 'hot', 'bold', 'queue', 'classify', 'status'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'belongid' => 'Belongid',
            'title' => 'Title',
            'name' => 'Name',
            'hot' => 'Hot',
            'bold' => 'Bold',
            'queue' => 'Queue',
            'classify' => 'Classify',
            'status' => 'Status',
        ];
    }
    
    public static function allFirstCols(){
        $query = PreColumn::findAll(['classify'=>2,'belongid'=>0]);
        return ArrayHelper::map($query, 'id', 'title');
    }
    public static function allCols(){
        $query = PreColumn::find()
                ->where(['classify'=>2])
                ->orderBy('belongid ASC')
                ->all();
        return ArrayHelper::map($query, 'id', 'title');
    }
    
    /**
     * 获取某个栏目下的所有子栏目的IDs
     * @param type $colid
     */
    public static function getColIds($colid){
        $query = PreColumn::findAll(['classify'=>2,'belongid'=>$colid]);
        $subs=ArrayHelper::map($query, 'id', 'title');
        $ids=array_keys($subs);
        $ids[]=$colid;
        return [
            'ids'=>$ids,
            'subs'=>$subs,
        ];
    }

}
