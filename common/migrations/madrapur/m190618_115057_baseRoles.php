<?php

use backend\modules\Product\models\Product;
use backend\modules\Reservations\models\Reservations;
use backend\modules\Tickets\models\Tickets;
use common\models\User;
use yii\db\Migration;

class m190618_115057_baseRoles extends Migration {
    public $tableName = "tableName";
    public $tableOptions = "";
    private $_roles = [
        User::ROLE_ADMINISTRATOR => 'Administrator role.',
        User::ROLE_USER => 'User role.',
        User::ROLE_OFFICE_ADMIN => 'Office Admin role.',
        User::ROLE_TICKET_EDITOR => 'Ticket Editor role.',
        User::ROLE_HOTEL_EDITOR => 'Hotel Editor role.',
        User::ROLE_OFFICE_VISITOR => 'Office Visitor role.',
        User::ROLE_STREET_ADMIN => 'Street Admin role.',
        User::ROLE_STREET_SELLER => 'Street Seller role.',
        User::ROLE_HOTLINE => 'Hotline role.',
    ];
    private $_permissions = [
        'loginToBackend' => 'Group can log in to backend.',
        'accessUsers' => 'Group can access Users module.',
        User::ASSIGN_OFFICE_ADMIN => 'Group can assign office admins.',
        User::ASSIGN_TICKET_EDITOR => 'Group can assign ticket editors.',
        User::ASSIGN_HOTEL_EDITOR => 'Group can assign hotel editors.',
        User::ASSIGN_OFFICE_VISITOR => 'Group can assign office visitors.',
        User::ASSIGN_STREET_ADMIN => 'Group can assign street admins.',
        User::ASSIGN_STREET_SELLER => 'Group can assign street sellers.',
        User::ASSIGN_HOTLINE => 'Group can assign hotline users.',

        'accessContent' => 'Group can access Content module.',
        'accessTranslation' => 'Group can access Translation module.',
        'accessSystem' => 'Group can access Translation module.',
        'accessRBAC' => 'Group can access RBAC rules.',
        'accessFiles' => 'Group can access Files module.',
        'accessPayments' => 'Group can access Payments module.',
        'accessKeyValueStorage' => 'Group can access Key-Value Storage.',
        'accessSystemCache' => 'Group can access system cacge.',
        'accessSystemInformation' => 'Group can access system information.',
        'accessSystemLogs' => 'Group can access system logs.',

        'accessProducts' => 'Group can access Products module.',
        Product::ACCESS_PRODUCT_ADMIN => 'Group can access product admin.',
        Product::CREATE_PRODUCT => 'Group create product.',
        Product::UPDATE_PRODUCT => 'Group update any product.',
        Product::UPDATE_OWN_PRODUCT => 'Group can update own products.',
        Product::ACCESS_TIME_TABLE => 'Group can access time table for any desired date.',
        Product::BLOCK_DAYS => 'Group can block days.',
        Product::BLOCK_TIMES => 'Group can block times.',

        'accessBookings' => 'Group can access Bookings module.',
        Reservations::ACCESS_BOOKINGS_ADMIN => 'Group can access bookings admin.',
        Reservations::CREATE_BOOKING => 'Group create booking.',
        Reservations::EDIT_BOOKING => 'Group update any booking.',
        Reservations::VIEW_BOOKINGS => 'Group can view any booking.',
        Reservations::EDIT_OWN_BOOKING => 'Group can update own bookings.',
        Reservations::VIEW_OWN_BOOKINGS => 'Group can view own bookings.',

        'accessTickets' => 'Group can access Tickets module.',
        Tickets::ACCESS_TICKETS_ADMIN => 'Group can access bookings admin.',
        Tickets::ADD_TICKET_BLOCK => 'Group can add ticket blocks.',
        Tickets::ASSIGN_TICKET_BLOCK => 'Group can assign ticket blocks.',
        Tickets::VIEW_TICKET_BLOCKS => 'Group can view ticket blocks.',
        Tickets::VIEW_OWN_TICKET_BLOCKS => 'Group can view own ticket blocks.',
        Tickets::VIEW_OWN_TICKET_BLOCKS => 'Group can view own ticket blocks.',

        'accessStatistics' => 'Group can access Statistics module.',
        'viewStatisticsAdmin' => '',
    ];

    public function safeUp() {
        Yii::$app->authManager->removeAll();

        $this->createRoles();
        $this->createPermissions();
        $this->assignAdminPermissions();
        $this->assignOfficeAdminPermissions();
        $this->assignTicketEditorPermissions();
        $this->assignHotelEditorPermissions();
        $this->assignOfficeVisitorPermissions();
        $this->assignStreetAdminPermissions();
        $this->assignStreetSellerPermissions();
        $this->assignHotlinePermissions();

        try {
            // webmaster user
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole(User::ROLE_ADMINISTRATOR), 1);

            // officeAdmin user
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole(User::ROLE_OFFICE_ADMIN), 13);

            // streetAdmin user
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole(User::ROLE_STREET_ADMIN), 17);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_assignPermission');
        }
    }

    protected function assignAdminPermissions() {
        $adminPermissions = [
            'loginToBackend',
            'accessUsers',
            'assignAdministrator',
            'assignUser',
            User::ASSIGN_OFFICE_ADMIN,
            User::ASSIGN_TICKET_EDITOR,
            User::ASSIGN_HOTEL_EDITOR,
            User::ASSIGN_OFFICE_VISITOR,
            User::ASSIGN_STREET_ADMIN,
            User::ASSIGN_STREET_SELLER,
            User::ASSIGN_HOTLINE,
            'accessContent',
            'accessTranslation',
            'accessSystem',
            'accessRBAC',
            'accessFiles',
            'accessProducts',
            'accessPayments',
            'accessBookings',
            'accessStatistics',
            'viewStatisticsAdmin',
            'accessKeyValueStorage',
            'accessSystemCache',
            'accessSystemInformation',
            'accessSystemLogs',
            'accessTickets',
        ];

        $this->assignPermissionsToRole(User::ROLE_ADMINISTRATOR, $adminPermissions);
    }

    protected function assignOfficeAdminPermissions() {
        $officeAdminPermissions = [
            'loginToBackend',
            'accessUsers',
            User::ASSIGN_TICKET_EDITOR,
            User::ASSIGN_HOTEL_EDITOR,
            User::ASSIGN_OFFICE_VISITOR,
            User::ASSIGN_STREET_ADMIN,
            User::ASSIGN_STREET_SELLER,
            User::ASSIGN_HOTLINE,
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::EDIT_BOOKING,
            Reservations::VIEW_BOOKINGS,
            Reservations::EDIT_OWN_BOOKING,
            Reservations::VIEW_OWN_BOOKINGS,
            'accessStatistics',
            'viewStatisticsAdmin',
            'accessTickets',
            Tickets::ACCESS_TICKETS_ADMIN,
            Tickets::ADD_TICKET_BLOCK,
            Tickets::ASSIGN_TICKET_BLOCK,
            Tickets::VIEW_TICKET_BLOCKS,
            Tickets::VIEW_OWN_TICKET_BLOCKS,
        ];

        $this->assignPermissionsToRole(User::ROLE_OFFICE_ADMIN, $officeAdminPermissions);
    }

    protected function assignTicketEditorPermissions() {
        $ticketEditorPermissions = [
            'loginToBackend',
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::EDIT_BOOKING,
            Reservations::EDIT_OWN_BOOKING,
            'accessTickets',
            Tickets::ACCESS_TICKETS_ADMIN,
            Tickets::ADD_TICKET_BLOCK,
            Tickets::ASSIGN_TICKET_BLOCK,
            Tickets::VIEW_TICKET_BLOCKS,
            Tickets::VIEW_OWN_TICKET_BLOCKS,
            'accessStatistics',
            'viewStatisticsAdmin',
        ];

        $this->assignPermissionsToRole(User::ROLE_TICKET_EDITOR, $ticketEditorPermissions);
    }

    protected function assignHotelEditorPermissions() {
        $hotelEditorPermissions = [
            'loginToBackend',
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::VIEW_OWN_BOOKINGS,
            Reservations::EDIT_OWN_BOOKING,
            'accessStatistics',
            'viewStatisticsAdmin',
        ];

        $this->assignPermissionsToRole(User::ROLE_HOTEL_EDITOR, $hotelEditorPermissions);
    }

    protected function assignOfficeVisitorPermissions() {
        $officeVisitorPermissions = [
            'loginToBackend',
            'accessStatistics',
            'viewStatisticsAdmin',
        ];

        $this->assignPermissionsToRole(User::ROLE_OFFICE_VISITOR, $officeVisitorPermissions);
    }

    protected function assignStreetAdminPermissions() {
        $streetAdminPermissions = [
            'loginToBackend',
            'accessUsers',
            User::ASSIGN_STREET_SELLER,
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::EDIT_BOOKING,
            Reservations::VIEW_BOOKINGS,
            Reservations::EDIT_OWN_BOOKING,
            Reservations::VIEW_OWN_BOOKINGS,
            'accessTickets',
            Tickets::ACCESS_TICKETS_ADMIN,
            Tickets::ASSIGN_TICKET_BLOCK,
            Tickets::VIEW_OWN_TICKET_BLOCKS,
            'accessStatistics',
        ];

        $this->assignPermissionsToRole(User::ROLE_STREET_ADMIN, $streetAdminPermissions);
    }

    protected function assignStreetSellerPermissions() {
        $streetSellerPermissions = [
            'loginToBackend',
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::EDIT_OWN_BOOKING,
            Reservations::VIEW_OWN_BOOKINGS,
            'accessTickets',
            Tickets::ACCESS_TICKETS_ADMIN,
            Tickets::VIEW_OWN_TICKET_BLOCKS,
            'accessStatistics',
            'viewStatisticsAdmin',
        ];

        $this->assignPermissionsToRole(User::ROLE_STREET_SELLER, $streetSellerPermissions);
    }

    protected function assignHotlinePermissions() {
        $hotlinePermissions = [
            'loginToBackend',
            'accessBookings',
            Reservations::ACCESS_BOOKINGS_ADMIN,
            Reservations::CREATE_BOOKING,
            Reservations::EDIT_OWN_BOOKING,
            Reservations::VIEW_OWN_BOOKINGS,
            'accessStatistics',
            'viewStatisticsAdmin',
        ];

        $this->assignPermissionsToRole(User::ROLE_HOTLINE, $hotlinePermissions);
    }

    protected function addChildRolesToRole($role, $childRoles) {
        foreach ($childRoles as $childRole) {
            self::_addChildRoleToRole($role, $childRole);
        }
    }

    protected function assignPermissionsToRole($role, $permissions) {
        foreach ($permissions as $permission) {
            self::_assignPermissionToRole($role, $permission);
        }
    }

    protected function createRoles() {
        foreach ($this->_roles as $roleName => $roleDescription) {
            self::_createRole($roleName, $roleDescription);
        }
    }

    protected function createPermissions() {
        foreach ($this->_permissions as $permissionName => $permissionDescription) {
            self::_createPermission($permissionName, $permissionDescription);
        }
    }

    private function _addChildRoleToRole($roleName, $childRoleName) {
        $role = Yii::$app->authManager->getRole($roleName);
        $childRole = Yii::$app->authManager->getRole($childRoleName);

        try {
            Yii::$app->authManager->addChild($role, $childRole);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_assignPermission');
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

    private function _createRole($name, $description = '') {
        $role = Yii::$app->authManager->createRole($name);
        $role->description = $description;

        try {
            Yii::$app->authManager->add($role);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), '_createRole');
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

    public function safeDown() {
        Yii::$app->authManager->removeAll();
    }
}
