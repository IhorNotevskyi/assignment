<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\components\DropDownListHelper;
use frontend\models\User;
use frontend\models\Address;
use frontend\models\UserToAddress;
use frontend\components\QueryHelper;
use yii\web\NotFoundHttpException;

/**
 * Class AddressController
 * @package frontend\controllers
 */
class AddressController extends Controller
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
     * @param int $usr
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionAdd($usr)
    {
        $userId = (int)strip_tags($usr);
        $address = new Address();
        $userToAddress = new UserToAddress();

        $postAddressParams = Yii::$app->request->post('Address');
        $identicalAddress = $address->findIdenticalAddress($postAddressParams);

        if ($identicalAddress) {
            $identicalAddressId = current(ArrayHelper::getColumn((array)$identicalAddress, 'id'));
            $identicalUserToAddress = $userToAddress->findIdenticalData($userId, $identicalAddressId);

            if (!$identicalUserToAddress) {
                $userToAddress->insertNewData($userId, $identicalAddressId);
                Yii::$app->session->setFlash('success', 'Новый адрес успешно добавлен');
            } else {
                Yii::$app->session->setFlash('error', 'Данный адрес уже существует у пользователя');
            }

            return $this->refresh();
        } else {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($address->load(Yii::$app->request->post()) && $address->save()) {
                    $userToAddress->insertNewData($userId, $address->id);
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Новый адрес успешно добавлен');

                    return $this->refresh();
                }
            } catch (\Exception $exception) {
                $transaction->rollback();
                Yii::$app->session->setFlash('error', 'Не удалось добавить новый адрес');
            }
        }

        $countryCodeList = DropDownListHelper::getCountryCodeList();

        return $this->render('add', [
            'userId' => $userId,
            'address' => $address,
            'countryCodeList' => $countryCodeList
        ]);
    }

    /**
     * @param int $usr
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($usr, $id)
    {
        $userId = (int)strip_tags($usr);
        $addressId = (int)strip_tags($id);
        $address = Address::findOne($addressId);
        (new QueryHelper())->checkQuery($address);
        $userToAddress = new UserToAddress();

        $postAddressParams = Yii::$app->request->post('Address');
        $identicalAddress = $address->findIdenticalAddress($postAddressParams);

        if ($identicalAddress) {
            $identicalAddressId = current(ArrayHelper::getColumn((array)$identicalAddress, 'id'));
            $identicalUserToAddress = $userToAddress->findIdenticalData($userId, $identicalAddressId);

            if (!$identicalUserToAddress) {
                $userToAddress->insertNewData($userId, $identicalAddressId);
                Yii::$app->session->setFlash('success', 'Адрес успешно отредактирован');
            } else {
                Yii::$app->session->setFlash('error', 'Данный адрес уже существует у пользователя');
            }

            return $this->refresh();
        } else {
            if ($address->load(Yii::$app->request->post()) && $address->save()) {
                Yii::$app->session->setFlash('success', 'Адрес успешно отредактирован');

                return $this->refresh();
            }
        }

        $countryCodeList = DropDownListHelper::getCountryCodeList();

        return $this->render('edit', [
            'userId' => $userId,
            'address' => $address,
            'countryCodeList' => $countryCodeList
        ]);
    }

    /**
     * @param int $usr
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionDelete($usr, $id)
    {
        $userId = (int)strip_tags($usr);
        $addressId = (int)strip_tags($id);
        $address = Address::findOne($addressId);
        (new QueryHelper())->checkQuery($address);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (count(User::findOne($userId)->getAddresses()) <= 1) {
                Yii::$app->session->setFlash('error', 'У пользователя должен быть минимум один адрес');

                return $this->redirect(Yii::$app->request->referrer);
            }

            $address->delete();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Адрес успешно удален');
        } catch (\Exception $exception) {
            $transaction->rollback();
            Yii::$app->session->setFlash('error', 'Не удалось удалить адрес');
        }

        return $this->redirect(['user/view', 'id' => $userId]);
    }
}