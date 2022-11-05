<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage iblock
 * @copyright  2001-2018 Bitrix
 */

namespace Aic\Robotics\Base\Table;

use Bitrix\Main\ORM\Fields\IntegerField;

class OurPartnersNNPropertyTable extends BaseForNNIblocks20
{
    protected static string $iblockApiCode = 'OurPartners';

    public static function properties () : array
    {
        return [
            new IntegerField('PROPERTY_'.self::getPropertyInfo('DARK_PHOTO')['ID']),
            new IntegerField('PROPERTY_'.self::getPropertyInfo('LIGHT_PHOTO')['ID']),
        ];
    }
}
