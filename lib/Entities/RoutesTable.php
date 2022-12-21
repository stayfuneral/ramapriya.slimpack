<?php

namespace Ramapriya\SlimPack\Entities;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\ArrayField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;
use Exception;
use Spatie\DataTransferObject\Str;

class RoutesTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'routes';
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'primary'      => true,
                'autocomplete' => true,
            ]),
            new StringField('NAME', [
                'required' => true,
            ]),
            new StringField('TYPE', [
                'required'      => true,
                'values'        => ['route', 'group'],
                'default_value' => 'route',
            ]),
            new StringField('METHOD', [
                'required' => true,
            ]),
            new ArrayField('ENABLED_METHODS'),
            new StringField('PATTERN', [
                'required' => true,
            ]),
            new IntegerField('GROUP_ID'),
            new Reference('GROUP', __CLASS__, Join::on('this.GROUP_ID', 'ref.ID')),
            new ArrayField('CONTROLLER', [
                'required' => true,
            ]),
            new ArrayField('MIDDLEWARES'),
        ];
    }
}
