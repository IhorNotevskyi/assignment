<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "user_to_address".
 *
 * @package frontend\models
 *
 * @property int $id
 * @property int $address_id
 * @property int $user_id
 *
 * @property Address $address
 * @property User $user
 */
class UserToAddress extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{user_to_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_id', 'user_id'], 'required'],
            [['address_id', 'user_id'], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param int $addressId
     * @return array
     */
    public function getIdByAddressId($addressId)
    {
        return (new Query())
            ->select('id')
            ->from('user_to_address')
            ->where('address_id = :address', [':address' => $addressId])
            ->all();
    }

    /**
     * @param int $userId
     * @param int $addressId
     * @throws \yii\db\Exception
     */
    public function insertNewData($userId, $addressId)
    {
        Yii::$app->db->createCommand()->insert('user_to_address', [
            'user_id' => $userId,
            'address_id' => $addressId
        ])->execute();
    }

    /**
     * @param int $userId
     * @param int $addressId
     * @return UserToAddress|null
     */
    public function findIdenticalData($userId, $addressId)
    {
        return self::findOne([
            'user_id' => $userId,
            'address_id' => $addressId
        ]);
    }
}
