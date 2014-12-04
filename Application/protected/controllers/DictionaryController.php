<?php

class DictionaryController extends CrudController
{
    protected function beforeSave($model)
    {
        if ($this->action->Id == "create") {
            $model->user_id = Yii::app()->user->getId();
        }
    }

}
