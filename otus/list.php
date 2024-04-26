<?php

declare(strict_types=1);

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Context;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$isGetId = Context::getCurrent()->getRequest()->get('id') > 0 ? Context::getCurrent()->getRequest()->get('id') : null;

if($isGetId !== null){
    $doctor = \Bitrix\Iblock\Elements\ElementDoctorsTable::query()
        ->setSelect(['ID', 'NAME', 'PROCEDURE.ELEMENT'])
        ->setFilter(['=ACTIVE' => 'Y', '=ID' => $isGetId])
        ->exec()
        ->fetchObject();
    ?>

    <div><?php echo $doctor->getName()?></div>
    <?php
    if(!is_null($procedures = $doctor->getProcedure()->getAll())){
        ?><ol><?php
        foreach ($procedures as $procedure){
            echo "<li>".$procedure->getElement()->getName()."</li>";
        }
        ?></ol><?php
    }

}else{
    $doctors = ElementTable::query()
        ->setSelect(['ID', 'NAME'])
        ->setFilter(['=ACTIVE' => 'Y', '=IBLOCK_ID' => 16])
        ->exec()
        ->fetchAll();

    foreach($doctors as $doctor){
        ?>

        <div>
            <a href="/otus/list.php?id=<?php echo $doctor['ID']?>"><?php echo $doctor['NAME']?></a>
        </div>

        <?php
    }
}
?>

<style>
    span {
        display: none;
    }
    input[type="checkbox"]:checked + span {
        display: block;
    }
</style>