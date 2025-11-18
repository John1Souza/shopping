<?php

namespace app\models\searchs;

use yii\data\ActiveDataProvider;

class BaseSearch
{
    public static $rulesBase = [['search', 'searchType', 'page', 'pageSize', 'sortField', 'sortOrder'], 'safe'];

    public static function dataProvider($modelSearch, $query, $defaultOrder = [])
    {
        $sortField = $modelSearch->sortField;
        $sortOrder = strtolower($modelSearch->sortOrder ?? 'asc') === 'desc' ? SORT_DESC : SORT_ASC;

        if (!empty($sortField)) {
            $query->orderBy([$sortField => $sortOrder]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $modelSearch->page ?? 0,
                'pageSize' => $modelSearch->pageSize ?? 10
            ],
        ]);

        if (empty($sortField)) {
            $dataProvider->setSort([
                'defaultOrder' => $defaultOrder
            ]);
        }

        return $dataProvider;
    }
}
