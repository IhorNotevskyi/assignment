<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "address".
 *
 * @package frontend\models
 *
 * @property int $id
 * @property string $postcode
 * @property int $country_code_id
 * @property string $city
 * @property string $street
 * @property string $house_number
 * @property string $apartment_number
 *
 * @property UserToAddress[] $userToAddresses
 */
class Address extends ActiveRecord
{
    /**
     * @var array
     */
    public $attributes;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postcode', 'country_code_id', 'city', 'street', 'house_number'], 'required'],

            [['city', 'street', 'house_number', 'apartment_number'], 'filter', 'filter' => function ($value) {
                return preg_replace('/\s+/', ' ', strip_tags($value));
            }],

            [['postcode', 'city', 'street', 'house_number', 'apartment_number'], 'trim'],

            [['country_code_id'], 'in', 'range' => Country::getCountryIdList()],

            [['postcode'], 'string', 'max' => 10],
            [['postcode'], 'match', 'pattern' => '/^\d+$/'],

            [['city', 'street'], 'string', 'max' => 50],

            [['house_number', 'apartment_number'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postcode' => 'Почтовый индекс',
            'country_code_id' => 'Код страны',
            'city' => 'Город',
            'street' => 'Улица',
            'house_number' => 'Номер дома',
            'apartment_number' => 'Номер офиса/квартиры',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToAddresses()
    {
        return $this->hasMany(UserToAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return array|null|ActiveRecord
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_code_id'])->one();
    }

    /**
     * @param array $postAddressParams
     * @return Address|null
     */
    public function findIdenticalAddress($postAddressParams)
    {
        return self::findOne([
            'postcode' => $postAddressParams['postcode'],
            'country_code_id' => $postAddressParams['country_code_id'],
            'city' => $postAddressParams['city'],
            'street' => $postAddressParams['street'],
            'house_number' => $postAddressParams['house_number'],
            'apartment_number' => $postAddressParams['apartment_number'],
        ]);
    }
}
