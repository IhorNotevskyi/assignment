<?php

namespace frontend\helpers;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Class PaginationHelper
 * @package frontend\helpers
 */
class PaginationHelper
{
    /**
     * @param yii\db\ActiveQuery $data
     * @param int $pageSize
     * @return array
     * @throws NotFoundHttpException
     */
    public function createPagination($data, $pageSize)
    {
        $pages = new Pagination([
            'defaultPageSize' => $pageSize,
            'totalCount' => $data->count()
        ]);

        $dataList = $data->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $totalExistingPages = ceil(intval($pages->totalCount) / $pages->defaultPageSize);
        $currentPage = intval(Yii::$app->request->get('page'));
        if ($currentPage > $totalExistingPages) {
            throw new NotFoundHttpException('Запрашиваемая страница не существует');
        }

        $data = array_combine(['pages', 'dataList'], [$pages, $dataList]);

        return $data;
    }
}
