<?php

class CpDropdown extends CComponent
{
    /*static protected $items = array(
        'countries' => array(
            '' => '',
            'ua' => 'Ukraine',
            'en' => 'England',
        ),
    );/**/

    static public function getItems($name = '')
    {
        return Yii::t('dropdown', $name);

        /*if (!isset(self::$items[$name])) {
            return array();
        }
        return self::$items[$name];/**/
    }

}
