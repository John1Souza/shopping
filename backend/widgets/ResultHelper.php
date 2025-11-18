<?php

namespace app\widgets;

class ResultHelper
{
    public static function json($data, $relations = null)
    {
        return self::build($data, $relations);
    }

    public static function build($data, $relations = null)
    {
        if ($data === null) {
            return [];
        }
        $result = [];
        if (is_array($data)) {
            foreach ($data as $dataItem) {
                $result[] = self::buildItem($dataItem, $relations);
            }
        } else {
            $result = self::buildItem($data, $relations);
        }

        return $result;
    }

    public static function buildItem($data, $relations)
    {
        $attributes = isset($data->attributes) ? self::convertToOut($data->getOldAttributes()) : null;

        if (is_array($relations)) {

            foreach ($relations as $keyRelation => $relation) {
                if (is_array($relation)) {
                    foreach ($relation as $key => $relationItem) {
                        $attributes[$keyRelation] = self::build($data->$keyRelation, $relation);
                    }
                } else {
                    if (empty($data->$relation)) continue;

                    if (is_array($data->$relation)) {
                        foreach ($data->$relation as $key => $dataItem) {
                            $attributes[$relation][$key] = self::build($dataItem, $relation);
                        }
                    } else {
                        $attributes[$relation] = isset($data->$relation)
                            ? self::convertToOut($data->$relation->getOldAttributes()) : null;
                    }
                }
            }
        }
        return $attributes;
    }

    public static function convertToOut($data)
    {
        // remover do json
        $blocks = [
            'ds_senha',
            'co_integracao',
            'co_access_token',
            'co_refresh_token',
            'in_excluido',
            'search',
            'searchType',
            'ds_2fa',
            'ds_token_authorization'
        ];
        foreach ($blocks as $key => $block) {
            if (isset($data[$block])) {
                unset($data[$block]);
            }
        }
        return $data;
    }
}
