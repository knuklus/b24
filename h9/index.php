<?php

declare(strict_types=1);

use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Iblock\ElementTable;
use Otus\H9Table;


use Bitrix\Main\Application;
use Bitrix\Main\FileTable;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;
use Bitrix\Main\ORM\Data\DataManager;

use Bitrix\Main\ORM\Fields\{Relations, Validators, IntegerField, StringField};

/**
 * @global  \CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');


$doctors = ElementTable::getEntity();

$doctors->addField(
    (new Relations\Reference(
        'H9',
        H9Table::class,
        Join::on('this.ID', 'ref.DOCTOR_ID')
    ))->configureJoinType('inner'),
);

$doctors = (new Query($doctors))
    ->setSelect(['ID', 'NAME', 'H9'])
    ->setFilter([
        '=IBLOCK_ID' => 16,
        '=ACTIVE' => 'Y'
    ])
    ->setLimit(4)
    ->exec()
    ->fetchAll();

/*
 *     Array
(
    [0] => Array
        (
            [ID] => 32
            [NAME] => Иванов И.И
            [IBLOCK_ELEMENT_H9_ID] => 1
            [IBLOCK_ELEMENT_H9_NAME] => Маша
            [IBLOCK_ELEMENT_H9_AVATAR_ID] => 1
            [IBLOCK_ELEMENT_H9_DOCTOR_ID] => 32
            [IBLOCK_ELEMENT_H9_PROCEDURE_ID] => 29
        )

    [1] => Array
        (
            [ID] => 33
            [NAME] => Петров С.М
            [IBLOCK_ELEMENT_H9_ID] => 2
            [IBLOCK_ELEMENT_H9_NAME] => Олег
            [IBLOCK_ELEMENT_H9_AVATAR_ID] => 2
            [IBLOCK_ELEMENT_H9_DOCTOR_ID] => 33
            [IBLOCK_ELEMENT_H9_PROCEDURE_ID] => 30
        )

    [2] => Array
        (
            [ID] => 34
            [NAME] => Сидоров М.И
            [IBLOCK_ELEMENT_H9_ID] => 3
            [IBLOCK_ELEMENT_H9_NAME] => Рыжий
            [IBLOCK_ELEMENT_H9_AVATAR_ID] => 3
            [IBLOCK_ELEMENT_H9_DOCTOR_ID] => 34
            [IBLOCK_ELEMENT_H9_PROCEDURE_ID] => 31
        )

)
 * */


$procedure = ElementTable::getEntity();

$procedure->addField(
    (new Relations\Reference(
        'H9_v2',
        H9Table::class,
        Join::on('this.ID', 'ref.PROCEDURE_ID')
    ))->configureJoinType('inner'),
);

$procedure = (new Query($procedure))
    ->setSelect(['ID', 'NAME', 'H9_v2'])
    ->setFilter([
        '=IBLOCK_ID' => 17,
        '=ACTIVE' => 'Y'
    ])
    ->setLimit(4)
    ->exec()
    ->fetchAll();


/*
       Array
(
    [0] => Array
        (
            [ID] => 29
            [NAME] => стереотаксис
            [IBLOCK_ELEMENT_H9_v2_ID] => 1
            [IBLOCK_ELEMENT_H9_v2_NAME] => Маша
            [IBLOCK_ELEMENT_H9_v2_AVATAR_ID] => 1
            [IBLOCK_ELEMENT_H9_v2_DOCTOR_ID] => 32
            [IBLOCK_ELEMENT_H9_v2_PROCEDURE_ID] => 29
        )

    [1] => Array
        (
            [ID] => 30
            [NAME] => радиохирургия
            [IBLOCK_ELEMENT_H9_v2_ID] => 2
            [IBLOCK_ELEMENT_H9_v2_NAME] => Олег
            [IBLOCK_ELEMENT_H9_v2_AVATAR_ID] => 2
            [IBLOCK_ELEMENT_H9_v2_DOCTOR_ID] => 33
            [IBLOCK_ELEMENT_H9_v2_PROCEDURE_ID] => 30
        )

    [2] => Array
        (
            [ID] => 31
            [NAME] => электроэнцефалография
            [IBLOCK_ELEMENT_H9_v2_ID] => 3
            [IBLOCK_ELEMENT_H9_v2_NAME] => Рыжий
            [IBLOCK_ELEMENT_H9_v2_AVATAR_ID] => 3
            [IBLOCK_ELEMENT_H9_v2_DOCTOR_ID] => 34
            [IBLOCK_ELEMENT_H9_v2_PROCEDURE_ID] => 31
        )

)

 * */