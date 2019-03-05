<?php

namespace backend\modules\MadActiveRecord\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\conditions\AndCondition;
use yii\db\conditions\OrCondition;
use yii\db\Query;

/**
 * Default model for the `MadActiveRecord` module
 */
class MadActiveRecord extends ActiveRecord {
    /**
     * @param $what
     * @param $where
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
     * @param $conditions
     * @return AndCondition
     */
    public static function andWhereFilter($conditions) {
        return new AndCondition(self::_setConditions($conditions));
    }

    /**
     * @param $conditions
     * @return OrCondition
     */
    public static function orWhereFilter($conditions) {
        return new OrCondition(self::_setConditions($conditions));
    }

    /**
     * @param $conditions
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
}
