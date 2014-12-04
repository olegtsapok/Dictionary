<?php

return array(
    'attributes' => array("enctype"=>"multipart/form-data"),

    'elements'=>array(
        'user'=>array(
                'type'=>'form',
                'elements'=>array(
                    'first_name'=>array(
                        'type'=>'text',
                    ),
                    'last_name'=>array(
                        'type'=>'text',
                    ),
                    'email'=>array(
                        'type'=>'text',
                    ),
                    'new_password'=>array(
                        'type'=>'password',
                    ),
                ),
        ),
    ),


    'buttons'=>array(
        'registration'=>array(
            'type'=>'submit',
            'label'=>'Registration',
        ),
    ),
);