<?php

namespace app\models\searchs;

use app\models\Esqueleto;
use app\models\ShoppingList;
use Exception;
use Yii;
use yii\helpers\Html as HelpersHtml;

class ShoppingListSearch extends ShoppingList
{
    public $search;
    public $searchType;
    public $page;
    public $pageSize;
    public $sortField;
    public $sortOrder;

    public function rules()
    {
        return [
            BaseSearch::$rulesBase,
            [['id_usuario'], 'safe'],
        ];
    }

    public function search()
    {
        if (!$this->validate()) {
            throw new Exception(HelpersHtml::errorSummary($this));
        }

        $this->load(Yii::$app->request->post(), '');
        $query = ShoppingList::find();

        if (!empty($this->searchType)) {
            if (is_int($this->search)) {
                $query->andWhere([$this->searchType => $this->search]);
            } else {
                $query->andFilterWhere(['ilike', $this->searchType, $this->search]);
            }
        } else if (!empty($this->search)) {
            if (is_int($this->search)) {
                $query->andWhere(['id_usuario' => $this->search]);
            } else {
                $query->orFilterWhere(['ilike', 'no_usuario', $this->search]);
                $query->orFilterWhere(['ilike', 'ds_email', $this->search]);
            }
        }

        return BaseSearch::dataProvider($this, $query, ['id_esqueleto' => SORT_DESC]);
    }
}
