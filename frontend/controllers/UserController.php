<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\helpers\PaginationHelper;
use frontend\helpers\DropDownListHelper;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Address;
use frontend\models\UserToAddress;
use frontend\helpers\QueryHelper;
use yii\web\NotFoundHttpException;

/**
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $users = User::find()->orderBy(['created_at' => SORT_DESC]);
        (new QueryHelper())->checkQuery($users);

        $paginationData = (new PaginationHelper())->createPagination(
            $users,
            Yii::$app->params['pageSizeForUserList']
        );
        $userList = $paginationData['dataList'];
        $pages = $paginationData['pages'];

        return $this->render('index', [
            'userList' => $userList,
            'pages' => $pages
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $id = (int)strip_tags($id);
        $user = User::findOne($id);
        (new QueryHelper())->checkQuery($user);

        $addressesIds = ArrayHelper::getColumn($user->getAddresses(), 'id');
        $addresses = Address::find()->where(['in', 'id', $addressesIds]);

        $paginationData = (new PaginationHelper())->createPagination(
            $addresses,
            Yii::$app->params['pageSizeForUserAddressesList']
        );
        $addressList = $paginationData['dataList'];
        $pages = $paginationData['pages'];

        return $this->render('view', [
            'user' => $user,
            'addressList' => $addressList,
            'pages' => $pages
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionAdd()
    {
        $user = new User();
        $user->gender = User::GENDER_NO_INFORMATION;
        $address = new Address();
        $trueMessage = 'Новый пользователь успешно добавлен';

        $postAddressParams = Yii::$app->request->post('Address');
        $identicalAddress = $address->findIdenticalAddress($postAddressParams);

        if ($identicalAddress) {
            if ($user->load(Yii::$app->request->post()) && $address->load(Yii::$app->request->post()) && $user->save()) {
                (new UserToAddress())->insertNewData($user->id, $identicalAddress['id']);
                Yii::$app->session->setFlash('success', $trueMessage);

                return $this->refresh();
            }
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($user->load(Yii::$app->request->post()) && $address->load(Yii::$app->request->post()) && $user->save() && $address->save()) {
                (new UserToAddress())->insertNewData($user->id, $address->id);
                $transaction->commit();
                Yii::$app->session->setFlash('success', $trueMessage);

                return $this->refresh();
            }
        } catch (\Exception $exception) {
            $transaction->rollback();
            $user->password = '';
            $user->password_repeat = '';
            Yii::$app->session->setFlash('error', 'Не удалось добавить нового пользователя');
        }

        $countryCodeList = DropDownListHelper::getCountryCodeList();

        return $this->render('add', [
            'user' => $user,
            'address' => $address,
            'countryCodeList' => $countryCodeList
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        $id = (int)strip_tags($id);
        $user = User::findOne($id);
        (new QueryHelper())->checkQuery($user);
        $user->password = '';

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'Данные пользователя успешно отредактированы');

            return $this->refresh();
        }

        return $this->render('edit', ['user' => $user]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $id = (int)strip_tags($id);
        $user = User::findOne($id);
        (new QueryHelper())->checkQuery($user);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($user->getAddresses() as $address) {
                if ((count($addressId = (new UserToAddress())->getIdByAddressId($address->id)) - 1) === 0) {
                    (new QueryHelper())->checkQuery($addressId);
                    Address::findOne($address->id)->delete();
                }
            }

            $user->delete();

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Пользователь успешно удален');
        } catch (\Exception $exception) {
            $transaction->rollback();
            Yii::$app->session->setFlash('error', 'Не удалось удалить пользователя');
        }

        return $this->redirect(['user/index']);
    }
}
