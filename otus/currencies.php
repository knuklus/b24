<?php

declare(strict_types=1);

/**
 * @var $APPLICATION
*/

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->IncludeComponent(
    "otus:curriencies.list",
    "",
    Array(
        "NUM_PAGE" => "20",
        "SHOW_CHECKBOXES" => "N"
    )
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');