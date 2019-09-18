<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\User;

class m190912_120837_extendRoles extends Migration {
    //TODO improve this

    public $tableName = "tableName";
    public $tableOptions = "";

    private $_roles = [
        User::ROLE_HOTEL_SELLER=> 'Hotel seller role'

    ];

    private $_permissions = [
        User::ASSIGN_HOTEL_SELLER=> 'Assign Hotel seller role'

    ];

    private $_additionalpermissions = [
        User::ASSIGN_HOTEL_SELLER,
        'loginToBackend'

    ];

    protected function createPermissions() {
        foreach ($this->_permissions as $permissionName => $permissionDescription) {
            self::_createPermission($permissionName, $permissionDescription);
        }
    }

    private function _createPermission($name, $description = '') {
        $permission = Yii::$app->authManager->createPermission($name);
        $permission->description = $description;

        try {
            Yii::$app->authManager->add($permission);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_createPermission');
        }
    }

    protected function assignAdminPermissions() {
        $this->assignPermissionsToRole(User::ROLE_ADMINISTRATOR, array_keys($this->_permissions));
    }

    protected function assignNewRolePermissions() {
            $this->assignPermissionsToRole(User::ROLE_ADMINISTRATOR, array_keys($this->_permissions));
        }


    protected function assignPermissionsToRole($role, $permissions) {
        foreach ($permissions as $permission) {
            self::_assignPermissionToRole($role, $permission);
        }
    }

    private function _assignPermissionToRole($roleName, $permissionName) {
        $role = Yii::$app->authManager->getRole($roleName);
        $permission = Yii::$app->authManager->getPermission($permissionName);

        try {
            Yii::$app->authManager->addChild($role, $permission);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_assignPermission');
        }
    }




    protected function createRoles() {
        foreach ($this->_roles as $roleName => $roleDescription) {
            self::_createRole($roleName, $roleDescription);
        }
    }
    protected function deleteRoles() {
        foreach ($this->_roles as $roleName => $roleDescription) {
            self::_deleteRole($roleName, $roleDescription);
        }
    }



    private function _createRole($name, $description = '') {
        $role = Yii::$app->authManager->createRole($name);
        $role->description = $description;

        try {
            Yii::$app->authManager->add($role);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_createRole');
        }
    }

    private function _deleteRole($name, $description = '') {
        $role = Yii::$app->authManager->getRole($name);
        $role->description = $description;

        try {
            Yii::$app->authManager->remove($role);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_createRole');
        }
    }



    public function safeUp() {
        $this->createRoles();
        $this->createPermissions();
        $this->assignAdminPermissions();
    }

    public function safeDown() {
      $this->deleteRoles();
    }
}
