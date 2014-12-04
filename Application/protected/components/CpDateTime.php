<?php

class CpDateTime extends CComponent
{
    // timezone in seconds
    public $zone = +0;

    public function init()
    {
        $hours = 0;
        $this->zone = (60 * 60 * $hours);
    }

    public function toDb($value)
    {
        return date(
            "Y-m-d H:i",
            CDateTimeParser::parse($value, Yii::app()->params['dateTimeFormat']) - $this->zone
        );
    }
    public function toDisplay($value)
    {
        return Yii::app()->dateFormatter->format(
                Yii::app()->params['dateTimeFormat'],
                strtotime($value) + $this->zone
        );
    }


}
