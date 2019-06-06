<?php

namespace backend\modules\MadActiveRecord\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\conditions\AndCondition;
use yii\db\conditions\OrCondition;
use yii\db\Query;

/**
 * Default model for the `MadActiveRecord` module
 */
class MadActiveRecord extends ActiveRecord
{
    /**
     * @param $what
     * @param $from
     * @param $where
     * @return ActiveQuery
     */
    public static function select($what, $from, $where)
    {
        $query = new Query();

        $query
            ->select($what)
            ->from($from)
            ->where($where);

        return $query;
    }

    /**
     * @param $modelClass
     * @param $what
     * @param $from
     * @param $where
     * @return ActiveQuery
     */
    public static function aSelect($modelClass = null, $what, $from, $where)
    {
        $query = new ActiveQuery($modelClass);

        $query
            ->select($what)
            ->from($from)
            ->where($where);

        return $query;
    }

    public static function meById($modelClass = null,$id){
        /**
         * @param $modelClass i need a new Model
         * @param $id
         * @return your model /w id of choice
         */

        $query = $modelClass::aSelect($modelClass, '*', $modelClass::tableName(), 'id=' . $id);
        $me=$query->one();
        return $me;
    }



    /**
     * @param MadActiveRecord $model
     * @param $values
     * @return bool
     */
    public static function insertOne(MadActiveRecord $model, $values)
    {
        $model->setAttributes($values);

        return $model->save(false);
    }

    /**
     * @param MadActiveRecord $model
     * @param $values
     * @return int | bool
     */
    public static function insertOneReturn(MadActiveRecord $model, $values)
    {
        $model->setAttributes($values);

        if ($model->save(false)) {
            return $model->id;
        }

        return false;
    }


    public static function insertAll(string $model, $values)
    {
        foreach ($values as $value) {
            $newModel = new $model;

            if (!MadActiveRecord::insertOne($newModel, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $conditions
     * @return AndCondition
     */
    public static function andWhereFilter($conditions)
    {
        return new AndCondition(self::_setConditions($conditions));
    }

    /**
     * @param $conditions
     * @return OrCondition
     */
    public static function orWhereFilter($conditions)
    {
        return new OrCondition(self::_setConditions($conditions));
    }

    /**
     * @param $conditions
     * @return array
     */
    private static function _setConditions($conditions)
    {
        foreach ($conditions as $i => $condition) {
            $glass = $condition[0];
            $condition[0] = $condition[1];
            $condition[1] = $glass;

            $conditions[$i] = $condition;
        }

        return $conditions;
    }



}
