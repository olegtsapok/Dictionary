<?php

class CpLanguage extends CApplicationComponent
{
    /**
     * @var boolean auto detect language if not set.
     */
    public $autoDetect=false;
    /**
     * @var array allowed languages.
     */
    public $languages=array(
        'en_US'=>'English',
        'ru_RU'=>'Russian'
    );

    /**
     * @var string default language.
     */
    public $defaultLanguage='en_US';
    
    /**
     * @return void
     */
    public function init()
    {
        $this->initLanguage();
    }

    /**
     * @return void
     */
    private function initLanguage()
    {
        $language = Yii::app()->session->itemAt('language');

        if(!$language) {
            $language = $this->defaultLanguage;
        }

        if (!isset($this->languages[$language])) {
            $language = $this->defaultLanguage;
        }

        Yii::app()->setLanguage($language);
    }
}