<?php

namespace frontend\helpers;

use yii\web\NotFoundHttpException;

/**
 * Class QueryHelper
 * @package frontend\helpers
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
