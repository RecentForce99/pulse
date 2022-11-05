<?php

namespace Aic\Robotics\Base\Block;

use Aic\Robotics\Base\Table\OurPartnersMNPropertyTable;
use Aic\Robotics\Base\Table\OurPartnersNNPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ORM\Query;
use Bitrix\Main\Entity;
use CFile;

class OurPartners extends Base
{
    protected string $iblockApiCode = 'OurPartners';

    //Используется в названии свойства при помощи конкатенации
    private string $propPhotoName = 'DARK';

    public function setPropertyPhotoName($propPhotoName): self
    {
        $this->propPhotoName = $propPhotoName;
        return $this;
    }

    function getElements(): ?array
    {
        $elements = $result = [];
        $listElements = ElementTable::getList(
            [
                'select' => $this->selectElements(),
                'runtime' => $this->runtimeElements(),
                'filter' => $this->filterElements(),
                'order' => $this->orderElements(),
                'group' => $this->groupElements(),
            ]
        );
        while ($tmpElement = $listElements->fetch())
        {
            $ID = $tmpElement['ID'];
            if(key_exists($ID, $elements))
                $elements[$ID]['TEXT'][] = $tmpElement['TEXT_VALUE'];
            else
            {
                $elements[$ID] = $tmpElement;
                $elements[$ID]['TEXT'][] = $tmpElement['TEXT_VALUE'];
                unset($elements[$tmpElement['ID']]['TEXT_VALUE']);
            }
        }

        return $this->resultModify($elements);
    }

    private function resultModify(array $elements) : array
    {
        foreach ($elements as &$arItem)
        {
            $arItem["PHOTO_VALUE"] = CFile::GetPath($arItem["{$this->propPhotoName}_PHOTO_VALUE"]);
            $result[] = $arItem;
        }

        return $result;
    }

    private function getPropertyPhotoId()
    {
        if ($id = $this->getPropertyInfo("{$this->propPhotoName}_PHOTO")['ID']) {
            return $id;
        }
        return 0;
    }

    private function getPropertyTextId()
    {
        if ($id = $this->getPropertyInfo("TEXT")['ID']) {
            return $id;
        }
        return 0;
    }

    protected function selectElements(): array
    {
        return [
            "ID",
            "{$this->propPhotoName}_PHOTO_VALUE" => "{$this->propPhotoName}_PHOTO.PROPERTY_" . $this->getPropertyPhotoId(
                ),
            "TEXT_VALUE" => "TEXT.VALUE",
        ];
    }

    protected function runtimeElements(): array
    {
        return [
            new Entity\ReferenceField(
                "{$this->propPhotoName}_PHOTO",
                OurPartnersNNPropertyTable::class,
                Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ),
            new Entity\ReferenceField(
                "TEXT",
                OurPartnersMNPropertyTable::class,
                Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                    ->where("ref.IBLOCK_PROPERTY_ID", "=", $this->getPropertyTextId())
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