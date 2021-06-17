<?php

namespace Boilerplate\Module\Rest;

use Bitrix\Main;
use Bitrix\Iblock;

class NewsService
{
    private static function getNewsItems($filter = [])
    {
        Main\Loader::includeModule('iblock');

        /**
         * @var array $arElements
         */
        return Iblock\ElementTable::getList([
            'select' => ['*'],
            'filter' => array_merge(['IBLOCK.CODE' => 'news'], $filter),
            'order' => ['SORT' => 'ASC', 'DATE_CREATE' => 'DESC'],
        ])->fetchAll();
    }

    public static function list(array $_query, int $start, \CRestServer $server)
    {
        return static::getNewsItems();
    }

    public static function get(array $_query, int $start, \CRestServer $server)
    {
        $query = array_change_key_case($_query, CASE_UPPER);

        if (!isset($query['ID']) || !is_numeric($query['ID'])) {
            throw new Main\ArgumentTypeException('Не верно введен ID элемента', 'ID');
        }

        return static::getNewsItems(['ID' => intval($query['ID'])]);
    }
}