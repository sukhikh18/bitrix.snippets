<?php

namespace Boilerplate\Module\Rest;

class Service extends \IRestService
{
    /** @const SCOPE Имя разрешения */
    const SCOPE = 'boilerplate.module.rest';

    public function getDescription(): array
    {
        $scopes = [
            // Если нужно добавить методы к уже существующему разрешению просто указываем его
            // 'crm' => [],
            // Если нужно добавить методы которые не требуют разрешения и доступны всем приложениям
            // \CRestUtil::GLOBAL_SCOPE = [];
            self::SCOPE => [
                self::SCOPE . '.news.get' => [NewsService::class, 'get'],
                self::SCOPE . '.news.list' => [NewsService::class, 'list'],
            ]
        ];

        return $scopes;
    }
}
