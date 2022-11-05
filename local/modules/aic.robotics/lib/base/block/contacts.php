<?php

namespace Aic\Robotics\Base\Block;

use Aic\Robotics\Base\Table\ContactsPropertyTable;
use Aic\Robotics\Base\Table\OurPartnersPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ORM\Query;
use Bitrix\Main\Entity;

class Contacts extends Base
{
    protected string $iblockApiCode = 'Contacts';
    private array $elementsCode = ['phone-number-about', 'address-about', 'email-about'];

    public function setElementsCode($elementsCode) : self
    {
        $this->elementsCode = $elementsCode;
        return $this;
    }

    private function getPropertyLinkId()
    {
        if($id = $this->getPropertyInfo("LINK")['ID'])
            return $id;
        return 0;
    }

    protected function selectElements(): array
    {
        return [
            'NAME',
            'LINK_VALUE' => 'LINK.PROPERTY_'.$this->getPropertyLinkId()
        ];
    }

    protected function runtimeElements(): array
    {
        return [
            new Entity\ReferenceField(
                "LINK",
                ContactsPropertyTable::class,
                Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ),
        ];
    }

    protected function filterElements(): array
    {
        return [
            'IBLOCK_ID' => $this->iblockId,
            'CODE' => $this->elementsCode,
            'ACTIVE' => 'Y',
        ];
    }
}