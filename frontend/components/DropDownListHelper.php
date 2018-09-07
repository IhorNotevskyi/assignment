<?php

namespace frontend\components;

use frontend\models\Country;
use yii\helpers\ArrayHelper;

/**
 * Class DropDownListHelper
 * @package frontend\components
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