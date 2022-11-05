<?php
namespace Aic\Robotics\Component;
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Aic\Robotics\Base\Block\OurPartners;
use \Bitrix\Main\Loader;

class OurPartnersComponent extends \CBitrixComponent
{
    private function checkModules(){
        Loader::includeModule('aic.robotics');
    }
    public function onPrepareComponentParams($arParams)
    {
        $arParams['CACHE_TIME'] = isset($arParams['CACHE_TIME']) ? $arParams['CACHE_TIME'] : 86400;

        return $arParams;
    }

    private function result(){
        $ourPartners = (new OurPartners())->setPropertyPhotoName($this->arParams['PROPERTY_PHOTO_NAME']);
        $this->arResult['ELEMENTS'] = $ourPartners->getElements();
    }

    public function executeComponent()
    {
        if($this->startResultCache()){
            $this->checkModules();
            $this->result();
            $this->includeComponentTemplate();
        }

    }
}
