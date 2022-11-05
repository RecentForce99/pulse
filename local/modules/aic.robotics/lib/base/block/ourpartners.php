<?php

namespace Aic\Robotics\Base\Block;

use Aic\Robotics\Base\Table\OurPartnersPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ORM\Query;
use Bitrix\Main\Entity;
use CFile;

class OurPartners extends Base
{
    protected string $iblockApiCode = 'OurPartners';
   
    //Используется в названии свойства при помощи конкатенации
    private string $propPhotoName = 'DARK';

    public function setPropertyPhotoName($propPhotoName) : self
    {
        $this->propPhotoName = $propPhotoName;
        return $this;
    }

    function getElements(): ?array
    {
        $elements = parent::getElements();
        foreach ($elements as &$arItem)
            $arItem["PHOTO_VALUE"] = CFile::GetPath($arItem["{$this->propPhotoName}_PHOTO_VALUE"]);

        return $elements;
    }

    private function getPropertyPhotoId()
    {
        if($id = $this->getPropertyInfo("{$this->propPhotoName}_PHOTO")['ID'])
            return $id;
        return 0;
    }

    protected function selectElements(): array
    {
        return [
            "{$this->propPhotoName}_PHOTO_VALUE" => "{$this->propPhotoName}_PHOTO.PROPERTY_".$this->getPropertyPhotoId(),
        ];
    }

    protected function runtimeElements(): array
    {
        return [
            new Entity\ReferenceField(
                "{$this->propPhotoName}_PHOTO",
                OurPartnersPropertyTable::class,
                Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ),
        ];
    }

    protected function filterElements(): array
    {
        return [
            'IBLOCK_ID' => $this->iblockId,
            'ACTIVE' => 'Y',
        ];
    }
}