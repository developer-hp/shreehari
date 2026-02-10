<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;

    const ERROR_USERNAME_NOT_ACTIVE = 3;

    public function authenticate() {
        $record = User::model()->findByAttributes(array('email' => $this->username, 'is_deleted' => 0));

        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($record->password != md5($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
			$user_session_id = $record->id.Rand(1,999999);
			Yii::app()->user->setState('user_session_id', $user_session_id);
            $this->_id = $record->id;
            $this->username = $record->email;
            Yii::app()->user->setState('modal', $record);
            $this->errorCode = self::ERROR_NONE;
        }

        // Change the return statement to return the value not just a pass condition
        // was: return $this->errorCode==self::ERROR_NONE;
//        echo $this->errorCode; die;
        return $this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
