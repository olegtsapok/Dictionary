<?php

class UserController extends ApiController
{
    public function actionRegistration()
    {
        $this->checkRequired(array('email', 'password'));

        if (MobileUser::model()->findAllByAttributes(array('email' => $this->data->email))) {
            $this->returnError(150, "User already exist");
        }

        $mobileUser = new MobileUser();
        $mobileUser->email = $this->data->email;
        $mobileUser->password = md5($this->data->password);
        $mobileUser->save();

        $this->returnResult(array('user_id' => $mobileUser->id));
    }

    public function actionLogin()
    {
        $this->checkRequired(array('email', 'password'));

        $mobileUser = MobileUser::model()->findByAttributes(
                array(
                    'email' => $this->data->email,
                    'password' => md5($this->data->password),
                )
        );
        if (!$mobileUser) {
            $this->returnError(151, "Wrong credentials");
        }

        $this->returnResult(array('user_id' => $mobileUser->id));
    }

}