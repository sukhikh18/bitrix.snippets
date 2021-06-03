<?php

namespace Boilerplate\Module\ORM;

use Bitrix\Main\Entity;

/**
 * Class Boilerplate\DataTable
 *
 * Fields:
 * <ul>
 * <li> ID int
 * <li> TITLE string
 * <li> SORT int optional default 500
 * <li> UPDATED datetime default 'CURRENT_TIMESTAMP'
 * </ul>
 **/

class DataTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'boilerplate_module';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
            'ID' => [
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID',
            ],
            'TITLE' => [
                'data_type' => 'text',
                'required' => true,
                'title' => 'Заголовок',
            ],
            'SORT' => [
                'data_type' => 'integer',
                'title' => 'Сортировка',
            ],
            'UPDATED' => [
                'data_type' => 'datetime',
                'title' => 'Дата изменения',
            ],
        ];
	}
}