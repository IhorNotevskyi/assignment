<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use frontend\components\SpacesFilterHelper;

/**
 * This is the model class for table "user".
 *
 * @package frontend\models
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $created_at
 * @property string $email
 *
 * @property UserToAddress[] $userToAddresses
 */
class User extends ActiveRecord
{
    const GENDER_NO_INFORMATION = 0;
    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;

    /**
     * @var string $password_repeat
     */
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'password_repeat', 'first_name', 'last_name', 'email'], 'required'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
            [['login', 'first_name', 'last_name', 'email'], 'trim'],

            [['login'], 'unique', 'targetClass' => User::className()],
            [['login'], 'string', 'length' => [4, 100]],

            [['password'], 'string', 'min' => 6],

            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['first_name', 'last_name'], 'filter', 'filter' => 'ucfirst'],

            [['gender'], 'default', 'value' => self::GENDER_NO_INFORMATION],
            [['gender'], 'in', 'range' => [self::GENDER_NO_INFORMATION, self::GENDER_FEMALE, self::GENDER_MALE,]],

            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::className()],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert) {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);

        $this->login = SpacesFilterHelper::removeUnnecessarySpaces($this->login);
        $this->first_name = SpacesFilterHelper::removeUnnecessarySpaces($this->first_name);
        $this->last_name = SpacesFilterHelper::removeUnnecessarySpaces($this->last_name);

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'gender' => 'Пол',
            'created_at' => 'Дата создания',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserToAddresses()
    {
        return $this->hasMany(UserToAddress::className(), ['user_id' => 'id']);
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getAddresses()
    {
        return $this
            ->hasMany(Address::className(), ['id' => 'address_id'])
            ->via('userToAddresses')
            ->all();
    }

    /**
     * @return array
     */
    public function getGenderList()
    {
        return [
            self::GENDER_NO_INFORMATION => 'Нет информации',
            self::GENDER_FEMALE => 'Женский',
            self::GENDER_MALE => 'Мужской'
        ];
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGenderValue($value)
    {
        return ArrayHelper::getValue($this->getGenderList(), $value);
    }

    /**
     * @param string $createdAt
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormatCreatedAt($createdAt)
    {
        return Yii::$app->formatter->asDate($createdAt, 'dd-MM-yyyy HH:mm');
    }
}