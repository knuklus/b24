<?php

declare(strict_types=1);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * @var $USER
*/

$el = new CIBlockElement;
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(),
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID"      => 16,
    "PROPERTY_VALUES"=> [
        'PROCEDURE' => [31, 30]
    ],
    "NAME"           => "Новый доктор",
);
if($PRODUCT_ID = $el->Add($arLoadProductArray))
    echo "New ID: ".$PRODUCT_ID;
else
    echo "Error: ".$el->LAST_ERROR;