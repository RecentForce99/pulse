<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage iblock
 * @copyright  2001-2018 Bitrix
 */

namespace Aic\Robotics\Base\Table;

use Bitrix\Main\ORM\Fields\StringField;

class ContactsPropertyTable extends BaseForNNIblocks20
{
    protected static string $iblockApiCode = 'Contacts';

    public static function properties () : array
    {
        return [
            new StringField('PROPERTY_'.self::getPropertyInfo('LINK')['ID']),
        ];
    }
}
