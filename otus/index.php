<?php

declare(strict_types=1);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::query()
    ->setSelect(['ID', 'NAME', 'PROCEDURE.ELEMENT'])
    ->where('ACTIVE', 'Y')
    ->exec()
    ->fetchCollection();

foreach($doctors as $doctor){
    $res[$doctor->getId()]['NAME'] = $doctor->getName();
    if(!is_null($procedures = $doctor->getProcedure()->getAll())){
        foreach ($procedures as $procedure){
            $res[$doctor->getId()]['PROCEDURE'][] = $procedure->getElement()->getName();
        }
    }
}

?>

<?php

foreach ($res as $k => $v):?>
    <div>
        <label for="toggle"><?php echo $v['NAME']?></label>
        <?php if(isset($v['PROCEDURE'])):?>
            <input type="checkbox" id="toggle">
            <span class="toggle-element"><?php echo implode('; ', $v['PROCEDURE'])?></span>
        <?php endif;?>
    </div>
<?php endforeach;?>

<style>
    span {
        display: none;
    }
    input[type="checkbox"]:checked + span {
        display: block;
    }
</style>
