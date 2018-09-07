<?php

namespace frontend\models;

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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_id' => 'Address ID',
            'user_id' => 'User ID',
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

    public function getIdByAddressId($addressId)
    {
        return (new Query())
            ->select('id')
            ->from('user_to_address')
            ->where('address_id = :address', [':address' => $addressId])
            ->all();
    }
}
