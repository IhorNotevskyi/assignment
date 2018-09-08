<?php

namespace frontend\helpers;

use frontend\models\Country;
use yii\helpers\ArrayHelper;

/**
 * Class DropDownListHelper
 * @package frontend\helpers
 */
class DropDownListHelper
{
    /**
     * @return array
     */
    public static function getCountryCodeList()
    {
        return ArrayHelper::map(Country::getCountryData(), 'id', 'country_code');
    }
}
