<?php

declare(strict_types=1);

use Otus\H9Table;

/**
 * @global  \CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');


$data = [
    [
        'NAME' => 'Маша',
        'AVATAR_ID' => 1,
        'DOCTOR_ID' => 32,
        'PROCEDURE_ID' => 29
    ],
    [
        'NAME' => 'Олег',
        'AVATAR_ID' => 2,
        'DOCTOR_ID' => 33,
        'PROCEDURE_ID' => 30
    ],
    [
        'NAME' => 'Рыжий',
        'AVATAR_ID' => 3,
        'DOCTOR_ID' => 34,
        'PROCEDURE_ID' => 31
    ],
];

foreach ($data as $d){
    H9Table::add($d);
}

echo 'Готово';