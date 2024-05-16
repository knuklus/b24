<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
/** @global CIntranetToolbar $INTRANET_TOOLBAR */


use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyTable,
	Bitrix\Main\Application,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Engine\Contract\Controllerable,
	Bitrix\Iblock;
use Bitrix\Main\Engine\Contract;
use Bitrix\Main\SystemException;


class CurrenciesList extends \CBitrixComponent
{

    protected $request;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
    */
    public function onPrepareComponentParams($arParams) {
       return $arParams;
    }


    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exception
    */
    private function checkModules()
    {
        if(!Loader::includeModule('sale') || !Loader::includeModule('crm')){
            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }


    private function getList($page = 1, $limit = 1)
    {

        $offset = $limit * ($page-1);
        $list = [];

        $data = CurrencyTable::query()
            ->setSelect([
                'CURRENCY',
                'AMOUNT_CNT',
                'AMOUNT',
                'SORT',
                'BASE',
                'DATE_CREATE',
                'NAME' => 'LANG_FORMAT.FULL_NAME'
            ])
            ->setFilter(['=LANG_FORMAT.LID' => 'ru'])
            ->setOrder(['SORT' => 'ASC'])
            ->setLimit($limit)
            ->setOffset($offset)
            ->exec();
        
        while ($item = $data->fetch()) {
            $list[] = array('data' => $item);
        }

        return $list;
    }

    private function getColumn()
    {
        $fieldMap = CurrencyTable::getMap();
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            $columns[] = array(
                'id' => $field->getName(),
                'name' => $field->getTitle()
            );
        }

        $columns[] = [
            'id' => 'NAME',
            'name' => 'Название',
        ];

        return $columns;
    }



    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам 
     */
    public function executeComponent() {

        try
        {

            $this->checkModules();
            $this->request = Application::getInstance()->getContext()->getRequest();

           if(isset($this->request['report_list'])){
                $page = explode('page-', $this->request['report_list']);
                $page = $page[1];
            }else{
                $page = 1;
            }

            $this->arResult['SHOW_ROW_CHECKBOXES'] = false;
            
            if($this->arParams['SHOW_CHECKBOXES'] == 'Y'){
                $this->arResult['SHOW_ROW_CHECKBOXES'] = true;
            }

            $this->arResult['COLUMNS'] = $this->getColumn();
            $this->arResult['LISTS'] = $this->getList($page, $this->arParams['NUM_PAGE']);
            $this->arResult['COUNT'] =  CurrencyTable::getCount();

            // подключаем шаблон
            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }

    }


} 