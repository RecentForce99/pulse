<?php
namespace Aic\Robotics\Base\Block;

use Aic\Robotics\Base\Helper;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Iblock\PropertyTable;

class Base{
    protected string $iblockApiCode = '';
    protected string $code = '';
    protected int $sectionId;
    protected int $iblockId;
    protected string $sectionEntity;

    public function __construct()
    {
        $this->init();
        return $this;
    }

    protected function init():void{
        $this->getIblockId();
        $this->compileSectionEntity();
        $this->selectElements();
        $this->runtimeElements();
        $this->filterElements();
        $this->orderElements();
        $this->groupElements();
    }

    protected function getIblockId(): ?int{
        $this->iblockId = Helper::getIblockIdByApicode($this->iblockApiCode);
        return $this->iblockId;
    }

    protected function compileSectionEntity(): void{
        $this->sectionEntity = Section::compileEntityByIblock($this->iblockId);
    }

    protected function getPropertyInfo(string $code) :array{
        return PropertyTable::getRow([
            'filter' => [
                'IBLOCK_ID' => $this->iblockId,
                'CODE' => $code
            ],
            'select' => [
                'ID', 'CODE'
            ]
        ]);
    }

    protected function selectElements(): array{
        return [];
    }

    protected function runtimeElements(): array{
        return [];
    }

    protected function filterElements(): array{
        return [];
    }

    protected function orderElements(): array{
        return ['SORT' => 'ASC'];
    }

    protected function groupElements(): array{
        return ['ID'];
    }

    function setCode(string $code) :self{
        $this->code = $code;
        return $this;
    }

    function getSection() :array{
        $section = $this->sectionEntity::getRow([
            'select' => ['IBLOCK_ID', 'ID', 'NAME', 'DESCRIPTION', 'TITLE' => 'UF_TITLE'],
            'filter' => [
                'IBLOCK_ID' => $this->iblockId,
                'CODE' => $this->code,
                'ACTIVE' => 'Y'
            ],
        ]);
        if(!empty($section)){
            $this->sectionId = $section['ID'];
            return $section;
        }
        return [];
    }

    function getElement(): ?array{
        return ElementTable::getRow([
            'select' => $this->selectElements(),
            'runtime' => $this->runtimeElements(),
            'filter' => $this->filterElements(),
        ]);
    }

    function getElements(): ?array{
        $elements = [];
        $listElements = ElementTable::getList([
            'select' => $this->selectElements(),
            'runtime' => $this->runtimeElements(),
            'filter' => $this->filterElements(),
            'order' => $this->orderElements(),
            'group' => $this->groupElements(),
        ]);
        while ($tmpElement = $listElements->fetch()){
            $elements[] = $tmpElement;
        }
        return $elements;
    }


}