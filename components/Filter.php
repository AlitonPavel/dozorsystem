<?php


namespace app\components;

use yii\db\ActiveQuery;
use yii\web\Request;

class Filter
{
    const FILTER_CONDITION_LIKE = 'like';

    public static function getFilterValue($id, Request $request)
    {
        return $request->get($id);
    }

    public static function clearEmptyFilters($filters)
    {
        return array_filter($filters, function($filter) {
            return isset($filter[2]) ? true : false;
        });
    }

    public static function buildFilters(array $filters, Request $request)
    {
        $result = [];

        foreach ($filters as $key => $filter)
        {
            switch ($filter['filtercondition']) {
                case self::FILTER_CONDITION_LIKE:
                    $result[] = [self::FILTER_CONDITION_LIKE, $filter['filterfield'], self::getFilterValue($filter['reqName'], $request)];
                    break;
                default:
                    break;
            }
        }

        return self::clearEmptyFilters($result);
    }

    public static function applyFiltersToQuery(ActiveQuery $query, array $filters)
    {
        foreach ($filters as $filter)
        {
            switch ($filter[0]) {
                case self::FILTER_CONDITION_LIKE:
                    $query->andFilterWhere($filter);
                    break;
                default:
                    break;
            }
        }

        return $query;
    }
}
