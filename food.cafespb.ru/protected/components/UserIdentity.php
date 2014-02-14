<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    protected $_id;

    public function authenticate()
    {
         if ($this->username =='fasteda' && $this->password == 'rew123hj'){
                $this->_id = 1;
                $this->errorCode = self::ERROR_NONE;
                $this->setState('name', 'Fasteda.ru');
                $this->setState('login', 'Fasteda.ru');
                $this->setState('id_user', 1);
         } else {
               $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        return !$this->errorCode;
    }

    public static function id()
    {
        $cookies = Yii::app()->getRequest()->getCookies();

        return $cookies['yii_user_id'] ? $cookies['yii_user_id']->value : Yii::app()->user->id_user;
    }

    public static function user()
    {
        return Users::model()->findByPk(self::id());
    }


}