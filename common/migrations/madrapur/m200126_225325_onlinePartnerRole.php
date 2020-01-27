<?php

use yii\db\Schema;
use yii\db\Migration;
    use backend\modules\Reservations\models\Reservations;
    use backend\modules\Tickets\models\Tickets;

    use common\models\User;

class m200126_225325_onlinePartnerRole extends Migration {


    private $_roles = [
        User::ROLE_ONLINE_PARTNER=> 'Online Partner role'

    ];

    private $_permissions = [
        User::ASSIGN_ONLINE_PARTNER=> 'Assign Online partner role',


    ];

    private $hotelSellerPermissions = [
        'loginToBackend',
        Reservations::CREATE_BOOKING,
        Reservations::EDIT_OWN_BOOKING,
        Reservations::VIEW_OWN_BOOKINGS,


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
        $this->assignPermissionsToRole(User::ROLE_ONLINE_PARTNER, $this->hotelSellerPermissions);
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
        $this->assignNewRolePermissions();
    }

    public function safeDown() {
        return true;
    }
}
