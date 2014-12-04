<?php

class DefaultController extends ApiController
{
    public function actionIndex()
    {
            $this->render('index');
    }

}