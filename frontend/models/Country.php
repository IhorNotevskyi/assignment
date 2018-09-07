<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @package frontend\models
 *
 * @property int $id
 * @property string $country_code
 *
 * @property Address[] $addresses
 */
class Country extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_code'], 'required'],
            [['country_code'], 'string', 'max' => 2],
            [['country_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Код страны',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['country_code_id' => 'id']);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getCountryIdList()
    {
        return ArrayHelper::getColumn(self::find()->asArray()->all(), 'id');
    }

    /**
     * @return array|ActiveRecord[]
     */
    public static function getCountryData()
    {
        return self::find()->asArray()->all();
    }
}