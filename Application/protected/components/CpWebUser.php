<?php

class CpWebUser extends CWebUser
{
    public function isSuperAdmin()
    {
        if (Yii::app()->user->getData()->role == CpRole::roleAdmin) {
            return true;
        }
        return false;
    }

    public function getData()
    {
        if ($this->hasState('data')) {
            return $this->data;
        }
        return new User();
    }

}