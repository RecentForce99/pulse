<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage iblock
 * @copyright  2001-2018 Bitrix
 */

namespace Aic\Robotics\Base\Table;

use Aic\Robotics\Base\Helper;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;


class BaseForNNIblocks20 extends DataManager
{
    protected static string $iblockApiCode = '';

    public static function getTableName() : string
    {
        return 'b_iblock_element_prop_s' . static::getIblockId();
    }

    public static function getMap()
    {
        $array = [
            (new IntegerField('IBLOCK_ELEMENT_ID'))
                ->configurePrimary(true),
        ];
        $result = array_merge($array, static::properties());

        return $result;
    }

    protected static function properties(): array
    {
        return [];
    }

    protected static function getPropertyInfo(string $code): array
    {
        return PropertyTable::getRow(
            [
                'filter' => [
                    'IBLOCK_ID' => static::getIblockId(),
                    'CODE' => $code
                ],
                'select' => [
                    'ID',
                    'CODE'
                ]
            ]
        );
    }

    protected static function getIblockId(): int
    {
        return Helper::getIblockIdByApicode(static::$iblockApiCode);
    }
}
