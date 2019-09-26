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
class MadActiveRecord extends ActiveRecord {

    protected static $table;
    protected static $searchModel;
    protected static $activeDataProvider;

    public static function useTable($table) {
        static::$table = $table;

        return new static();
    }

    public static function tableName() {
        return static::$table;
    }

    /**
     * @param $what
     * @param $from
     * @param $where
     *
     * @return Query
     */
    public static function select($what, $from, $where) {
        $query = new Query();

        $query
            ->select($what)
            ->from($from)
            ->where($where);

        return $query;
    }

    /**
     * @param null $modelClass
     * @param $what
     * @param $from
     * @param $where
     * @param null $orderBy
     * @param null $groupBy
     *
     * @return ActiveQuery
     */
    public static function aSelect($modelClass = null, $what, $from, $where, $orderBy = null, $groupBy = null) {
        $query = new ActiveQuery($modelClass);

        if (!$orderBy) {
            $orderBy = ['id' => SORT_ASC];
        }

        if (!$groupBy) {
            $groupBy = ['id'];
        }

        $query
            ->select($what)
            ->from($from)
            ->where($where)
            ->orderBy($orderBy)
            ->groupBy($groupBy);

        return $query;
    }

    public static function meById($modelClass = null, $id) {
        /**
         * @param $modelClass i need a new Model
         * @param $id
         *
         * @return your model /w id of choice
         */

        $query = $modelClass::aSelect($modelClass, '*', $modelClass::tableName(), 'id=' . $id);
        $me = $query->one();
        return $me;
    }

    /**
     * @param MadActiveRecord $model
     * @param $values
     *
     * @return int | bool
     */
    public static function insertOneReturn(MadActiveRecord $model, $values) {
        $model->setAttributes($values);

        if ($model->save(false)) {
            return $model->id;
        }

        return false;
    }

    public static function insertAll(string $model, $values) {
        foreach ($values as $value) {
            $newModel = new $model;

            if (!MadActiveRecord::insertOne($newModel, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param MadActiveRecord $model
     * @param $values
     *
     * @return bool
     */
    public static function insertOne(MadActiveRecord $model, $values) {
        $model->setAttributes($values);

        return $model->save(false);
    }

    /**
     * @param MadActiveRecord $model
     * @param $message
     * @param null $from
     * @param null $to
     */
    public static function log(MadActiveRecord $model, $message, $from = null, $to = null){

        $assignData = [];
        $assignData['time'] = date('Y-m-d H:i:s', time());
        $assignData['by'] = Yii::$app->user->identity->username;
        $assignData['from'] = $from;
        $assignData['to'] = $to;
        $assignData['message']= $message;

        $foundReservation=$model;

        if ($foundReservation) {
            $Reservationobject = json_decode($foundReservation->data);
            if (isset($Reservationobject->assignments) && is_array($Reservationobject->assignments)) {

                array_unshift($Reservationobject->assignments, $assignData);
            } else {
                $Reservationobject->assignments[] = $assignData;
            }

            $foundReservation->data = json_encode($Reservationobject);
            $foundReservation->save(false);
//                echo \GuzzleHttp\json_encode($foundReservation->data);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successful assignment<u>' .
                                                                $foundReservation->id . '</u> reservation to ' .
                                                                $foundReservation->sellerName));


    }

    }

    /**
     * @param $conditions
     *
     * @return AndCondition
     */
    public static function andWhereFilter($conditions) {
        return new AndCondition(self::_setConditions($conditions));
    }

    /**
     * @param $conditions
     *
     * @return array
     */
    private static function _setConditions($conditions) {
        foreach ($conditions as $i => $condition) {
            $glass = $condition[0];
            $condition[0] = $condition[1];
            $condition[1] = $glass;

            $conditions[$i] = $condition;
        }

        return $conditions;
    }

    /**
     * @param $conditions
     *
     * @return OrCondition
     */
    public static function orWhereFilter($conditions) {
        return new OrCondition(self::_setConditions($conditions));
    }



}
