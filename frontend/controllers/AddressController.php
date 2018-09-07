<?php

namespace frontend\controllers;

use Yii;
use frontend\components\DropDownListHelper;
use yii\filters\VerbFilter;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Address;
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
        $countryCodeList = DropDownListHelper::getCountryCodeList();

        $transaction = Yii::$app->db->beginTransaction();

//        $postAddressParams = Yii::$app->request->post('Address');
//
//        $identicalAddress = Address::find()->where([
//            'postcode' => $postAddressParams['postcode'],
//            'country_code_id' => $postAddressParams['country_code_id'],
//            'city' => $postAddressParams['city'],
//            'street' => $postAddressParams['street'],
//            'house_number' => $postAddressParams['house_number'],
//            'apartment_number' => $postAddressParams['apartment_number'],
//        ])->all();

//        $iDidenticalAddress = current(ArrayHelper::getColumn($identicalAddress, 'id'));

//        var_dump(current(ArrayHelper::getColumn($identicalAddress, 'id'))); die;

        try {
            if ($address->load(Yii::$app->request->post()) && $address->save()) {
                Yii::$app->db->createCommand()->insert('user_to_address', [
                    'user_id' => $userId,
                    'address_id' => $address->id,
                ])->execute();

                $transaction->commit();

                Yii::$app->session->setFlash('success', 'Новый адрес успешно добавлен');

                return $this->refresh();
            }
        } catch (\Exception $exception) {
            $transaction->rollback();
            Yii::$app->session->setFlash('error', 'Не удалось добавить новый адрес');
        }

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
     */
    public function actionEdit($usr, $id)
    {
        $userId = (int)strip_tags($usr);
        $addressId = (int)strip_tags($id);
        $address = Address::findOne($addressId);
        (new QueryHelper())->checkQuery($address);
        $countryCodeList = DropDownListHelper::getCountryCodeList();

        if ($address->load(Yii::$app->request->post()) && $address->save()) {
            Yii::$app->session->setFlash('success', 'Адрес успешно отредактирован');

            return $this->refresh();
        }

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