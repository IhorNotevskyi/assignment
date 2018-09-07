<?php

namespace frontend\components;

use yii\web\NotFoundHttpException;

/**
 * Class QueryHelper
 * @package frontend\components
 */
class QueryHelper
{
    /**
     * @param mixed $data
     * @throws NotFoundHttpException
     */
    public function checkQuery($data)
    {
        if ($data === null) {
            throw new NotFoundHttpException('Не удалось получить запрошенные данные');
        }
    }
}