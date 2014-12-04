<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CpUserIdentity extends CUserIdentity
{
    /**
     * @var string email
     */
    public $email;
    /**
     * @var string password
     */
    public $password;

    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     */
    public function __construct($email,$password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(
            array(
                'email'    => $this->email,
            )
        );

        if(!$user)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif($user->password !== md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else {
            $this->errorCode=self::ERROR_NONE;
            $this->setState("data", $user);
        }

        return !$this->errorCode;
    }

    /**
     * Returns the unique identifier for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId()
    {
        return $this->getData()->id;
    }

    /**
     * Returns the display name for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName()
    {
        return trim($this->getData()->first_name . ' ' . $this->getData()->last_name);
    }

    protected function getData()
    {
        return $this->getState('data');
    }

}