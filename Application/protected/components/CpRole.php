<?php

class CpRole extends CComponent
{
    const roleAdmin = 'admin';
    const roleUser  = 'user';

    // available to web interface
    static public function getAvailableRoles()
    {
        return CHtml::listData(Role::model()->findAll("role <> 'super_admin'"), 'role', 'name');
    }

    public function init()
    {
        $auth=Yii::app()->authManager;
        $bizRule='return 1 == 1;';

        $crudModules = array(
            'Dictionary',
            'Word',
            'Learned',
            'User',
            'Language',
        );

        // create operations
        foreach ($crudModules as $moduleName) {
            $auth->createOperation('index'.$moduleName, 'view list records');
            $auth->createOperation('create'.$moduleName, 'create record');
            $auth->createOperation('view'.$moduleName, 'read record',$bizRule);
            $auth->createOperation('update'.$moduleName, 'update record',$bizRule);
            $auth->createOperation('delete'.$moduleName, 'delete record',$bizRule);
        }

        // create tasks
        foreach ($crudModules as $moduleName) {
            $task=$auth->createTask($moduleName.'_managing');
            $task->addChild('index'.$moduleName);
            $task->addChild('create'.$moduleName);
            $task->addChild('view'.$moduleName);
            $task->addChild('update'.$moduleName);
            $task->addChild('delete'.$moduleName);
        }

        // create roles
        $role=$auth->createRole('user');
        foreach ($crudModules as $moduleName) {
            $role->addChild($moduleName.'_managing');
        }

        $role=$auth->createRole('admin');
        $role->addChild('user');

        if (!Yii::app()->user->isGuest) {
            $auth->assign(Yii::app()->user->getData()->role, Yii::app()->user->id);
        }
        //$auth->save();
    }
}