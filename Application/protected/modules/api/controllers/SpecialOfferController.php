<?php

class SpecialOfferController extends ApiController
{
    public function actionSearch()
    {
        $this->checkRequired(array('rows', 'offset', 'lon', 'lat', 'radius'));
        $this->checkType('number', array('rows', 'offset', 'lon', 'lat', 'radius'));

        $this->returnResult(
                Yii::app()->offer->search((array)$this->data)
        );
    }
}