<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage iblock
 * @copyright  2001-2018 Bitrix
 */

namespace Aic\Robotics\Base\Table;

use Bitrix\Main\Entity\StringField;

class OurPartnersMNPropertyTable extends BaseForNNIblocks20
{
    protected static string $iblockApiCode = 'OurPartners';

    public static function getTableName() : string
    {
        return 'b_iblock_element_prop_m' . static::getIblockId();
    }

    public static function properties () : array
    {
        return [
            new StringField('VALUE'),
            new StringField('IBLOCK_PROPERTY_ID'),
        ];
    }
}
