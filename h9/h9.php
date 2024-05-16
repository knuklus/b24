<?php

declare(strict_types=1);

namespace Otus;

use Bitrix\Main\Application;
use Bitrix\Main\FileTable;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;
use Bitrix\Main\ORM\Data\DataManager;

use Bitrix\Main\ORM\Fields\{Relations, Validators, IntegerField, StringField};

/*
 * h9 - в честь номера дз
 * */

class H9Table extends DataManager
{

    public static function getTableName(): string
    {
        return 'h9';
    }

    /**
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true
                ]
            ),
            new StringField(
                'NAME',
                [
                    'required' => true,
                    'validation' => fn() => [new Validators\LengthValidator(3, 255)]
                ]
            ),
            new IntegerField(
                'AVATAR_ID'
            ),
            new IntegerField(
                'DOCTOR_ID'
            ),
            new IntegerField(
                'PROCEDURE_ID'
            ),
            (new Relations\Reference(
                'AVATAR_ID_REF',
                FileTable::class,
                Join::on('this.AVATAR_ID', 'ref.ID')
            ))->configureJoinType('inner'),
        ];
    }

    /**
     * @throws SqlQueryException
     */
    public static function dropTable(): void
    {
        $connection = Application::getConnection();
        $connection->dropTable(self::getTableName());
    }
}