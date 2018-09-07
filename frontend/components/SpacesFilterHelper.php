<?php

namespace frontend\components;

/**
 * Class SpacesFilterHelper
 * @package frontend\components
 */
class SpacesFilterHelper
{
    /**
     * @param string $attribute
     * @return string
     */
    public static function removeUnnecessarySpaces($attribute)
    {
        return preg_replace('/\s+/', ' ', $attribute);
    }
}