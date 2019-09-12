<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */
use backend\assets\BackendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use common\models\TimelineEvent;
    use kartik\icons\Icon;
    use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>

<div class="wrapper">
	<!-- header logo: style can be found in header.less -->
	<header class="main-header">
		<a
			href="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl('/') ?>"
			class="logo"> <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?php echo Yii::$app->name ?>
        </a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu"
				role="button"> <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
				class="icon-bar"></span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li id="timeline-notifications" class="notifications-menu"><a
						href="<?php echo Url::to(['/timeline-event/index']) ?>"> <i
							class="fa fa-bell"></i> <span class="label label-success">
                                <?php echo TimelineEvent::find()->today()->count() ?>
                            </span>
					</a></li>
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu"><a href="#"
						class="dropdown-toggle" data-toggle="dropdown"> <img
							src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
							class="user-image"> <span><?php echo Yii::$app->user->identity->username ?> <i
								class="caret"></i></span>
					</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header light-blue"><img
								src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
								class="img-circle" alt="User Image" />
								<p>
                                    <?php echo Yii::$app->user->identity->username ?>
                                    <small>
                                        <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                    </small></li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
								<div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
								<div class="pull-right">
                                    <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                </div>
							</li>
						</ul></li>
					<li>
                        <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/system/settings']) ?>
                    </li>
				</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img
						src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>"
						class="img-circle" />
				</div>
				<div class="pull-left info">
					<p><?php echo Yii::t('backend', 'Hello, {username}', ['username' => Yii::$app->user->identity->getPublicIdentity()]) ?></p>
					<a href="<?php echo Url::to(['/sign-in/profile']) ?>"> <i
						class="fa fa-circle text-success"></i>
                        <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                    </a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
            <?php
        $imaStreetAdmin=Yii::$app->authManager-> getAssignment('streetAdmin',Yii::$app->user->getId()) ;
        $imaOfficeAdmin=Yii::$app->authManager-> getAssignment('officeAdmin',Yii::$app->user->getId()) ;
        $imaStreetSeller=Yii::$app->authManager-> getAssignment('streetSeller',Yii::$app->user->getId()) ;
    $imaHotelSeller=Yii::$app->authManager-> getAssignment('hotelSeller',Yii::$app->user->getId()) ;
    $imaBookKeeper=Yii::$app->authManager-> getAssignment('bookKeeper',Yii::$app->user->getId()) ;
    $imaHotline=Yii::$app->authManager-> getAssignment('hotline',Yii::$app->user->getId()) ;
echo Menu::widget(
                    [
                        'options' => [
                            'class' => 'sidebar-menu',
                            'data-widget' => 'tree'
                        ],
                        'linkTemplate' => '<a  href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                        'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                        'activateParents' => true,
                        'items' => [
                            // MAIN
                            [
                                'label' => Yii::t('backend', 'Main'),
                                'options' => [
                                    'class' => 'header'
                                ],
                            ],

                            [
                                'label' => Yii::t('backend', 'Dashboard'),
                                'icon' => '<i class="fa fa-bar-chart-o"></i>',
                                'url' => [
                                    '/Dashboard/dashboard/admin'
                                ],

                            ],
                            [
                                'label' => Yii::t('backend', 'Timeline'),
                                'icon' => '<i class="fa fa-bar-chart-o"></i>',
                                'url' => [
                                    '/timeline-event/index'
                                ],
                                'badge' => TimelineEvent::find()->today()->count(),
                                'badgeBgClass' => 'label-success',
                                'visible'=>Yii::$app->user->can('administrator')
                            ],
                            [
                                'label' => Yii::t('backend', 'adminTools'),
                                'icon' => '<i class="fa fa-smile-o"></i>',
                                'url'=>['/Modmail/modmail/admin'],
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'items'=>[
                                    [
                                        'label' => Yii::t('backend', 'modMail'),
                                        'icon' => '<i class="fa fa-envelope-o"></i>',
                                        'url' => [
                                            '/Modmail/modmail/admin'
                                        ],

                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Db editor'),
                                        'icon' => '<i class="fa fa-table"></i>',
                                        'url' => [
                                            '/dbeditor.php?username=root2&db=mad_dev-db'
                                        ],

                                    ],
                                ],
                                'visible'=>Yii::$app->user->can('administrator')
                            ],
                            [
                                'label' => Yii::t('backend', 'Users'),
                                'icon' => '<i class="fa fa-users"></i>',
                                'url' => [
                                    '/user/index'
                                ],
                                'active' => Yii::$app->controller->id === 'user',
                                'visible' => Yii::$app->user->can('accessUsers'),
                            ],

                            [
                                'label' => Yii::t('backend', 'Tickets'),
                                'url' => [
                                    '/Tickets/tickets/admin'
                                ],
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'icon' => '<i class="fa fa-ticket"></i>',
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Summary'),
                                        'url' => [
                                            '/Tickets/tickets/admin'
                                        ],
                                        'icon' => '<i class="fa fa-list-alt"></i>',
                                        'active' => Yii::$app->controller->id === 'tickets' &&
                                            Yii::$app->controller->action->id === 'admin',
                                        'visible' => Yii::$app->user->can('accessTicketsAdmin'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Add ticket block'),
                                        'url' => [
                                            '/Tickets/tickets/add-block'
                                        ],
                                        'icon' => '<i class="fa fa-plus"></i>',
                                        'active' => Yii::$app->controller->id === 'tickets' &&
                                            Yii::$app->controller->action->id === 'add-block',
                                        'visible' => Yii::$app->user->can('addTicketBlock'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'View assigned blocks'),
                                        'url' => [
                                            '/Tickets/tickets/view-assigned-blocks'
                                        ],
                                        'icon' => '<i class="fa fa-"></i>',
                                        'active' => Yii::$app->controller->id === 'tickets' &&
                                            Yii::$app->controller->action->id === 'view-assigned-blocks',
                                        'visible' => Yii::$app->user->can('assignTicketBlock') && Yii::$app->user->can('administrator'),
                                    ],
                                ],
                                'active' => Yii::$app->controller->id === 'tickets',
                                'visible' => Yii::$app->user->can('accessTickets'),
                            ],

                            // CONTENT
                            [
                                'label' => Yii::t('backend', 'Content'),
                                'options' => [
                                    'class' => 'header'
                                ],
                                'visible' => Yii::$app->user->can('accessContent') && Yii::$app->user->can('administrator'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Email templates'),
                                'url' => [
                                    '/Modulusbuilder/modulusbuilder/email'
                                ],
                                'icon' => '<i class="fa fa-envelope"></i>',
                                'active' => Yii::$app->controller->id === 'modulusbuilder' &&
                                    Yii::$app->controller->action === 'email' && Yii::$app->user->can('administrator'),
                                'visible' => !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('hotline'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Static pages'),
                                'url' => [
                                    '/content/page/index'
                                ],
                                'icon' => '<i class="fa fa-thumb-tack"></i>',
                                'active' => Yii::$app->controller->id === 'page',
                                'visible' => Yii::$app->user->can('accessContent') && Yii::$app->user->can('administrator'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Articles'),
                                'url' => [
                                    '/content/article/index'
                                ],
                                'icon' => '<i class="fa fa-files-o"></i>',
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'active' => 'content' === Yii::$app->controller->module->id &&
                                ('article' === Yii::$app->controller->id || 'category' === Yii::$app->controller->id),
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Articles'),
                                        'url' => [
                                            '/content/article/index'
                                        ],
                                        'icon' => '<i class="fa fa-file-o"></i>',
                                        'active' => Yii::$app->controller->id === 'article',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Categories'),
                                        'url' => [
                                            '/content/category/index'
                                        ],
                                        'icon' => '<i class="fa fa-folder-open-o"></i>',
                                        'active' => Yii::$app->controller->id === 'category',
                                    ],
                                ],
                                'visible' => Yii::$app->user->can('accessContent'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Widgets'),
                                'url' => [
                                    '/content/page/index'
                                ],
                                'icon' => '<i class="fa fa-code"></i>',
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'active' => Yii::$app->controller->module->id === 'widget',
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Text Blocks'),
                                        'url' => [
                                            '/widget/text/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                        'active' => Yii::$app->controller->id === 'text',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Menu'),
                                        'url' => [
                                            '/widget/menu/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                        'active' => Yii::$app->controller->id === 'menu',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Carousel'),
                                        'url' => [
                                            '/widget/carousel/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                        'active' => in_array(Yii::$app->controller->id, [
                                            'carousel',
                                            'carousel-item'
                                        ]),
                                    ],
                                ],
                                'visible' => Yii::$app->user->can('accessContent'),
                            ],

                            // TRANSLATION
                            [
                                'label' => Yii::t('backend', 'Translation'),
                                'options' => [
                                    'class' => 'header'
                                ],
                                'visible' => Yii::$app->user->can('accessTranslation'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Translation'),
                                'url' => [
                                    '/translation/default/index'
                                ],
                                'icon' => '<i class="fa fa-language"></i>',
                                'active' => (Yii::$app->controller->module->id == 'translation'),
                                'visible' => Yii::$app->user->can('accessTranslation'),
                            ],

                            // SYSTEM
                            [
                                'label' => Yii::t('backend', 'System'),
                                'options' => [
                                    'class' => 'header'
                                ],
                                'visible' => Yii::$app->user->can('accessSystem'),
                            ],
                            [
                                'label' => Yii::t('backend', 'RBAC Rules'),
                                'url' => [
                                    '/rbac/rbac-auth-rule/index'
                                ],
                                'icon' => '<i class="fa fa-flag"></i>',
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'active' => in_array(Yii::$app->controller->id,
                                        [
                                            'rbac-auth-assignment',
                                            'rbac-auth-item',
                                            'rbac-auth-item-child',
                                            'rbac-auth-rule'
                                        ]),
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Auth Assignment'),
                                        'url' => [
                                            '/rbac/rbac-auth-assignment/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Auth Items'),
                                        'url' => [
                                            '/rbac/rbac-auth-item/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Auth Item Child'),
                                        'url' => [
                                            '/rbac/rbac-auth-item-child/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Auth Rules'),
                                        'url' => [
                                            '/rbac/rbac-auth-rule/index'
                                        ],
                                        'icon' => '<i class="fa fa-circle-o"></i>',
                                    ],
                                ],
                                'visible' => Yii::$app->user->can('accessRBAC'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Files'),
                                'url' => '#',
                                'icon' => '<i class="fa fa-th-large"></i>',
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'active' => (Yii::$app->controller->module->id == 'file'),
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Storage'),
                                        'url' => [
                                            '/file/storage/index'
                                        ],
                                        'icon' => '<i class="fa fa-database"></i>',
                                        'active' => (Yii::$app->controller->id == 'storage'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Manager'),
                                        'url' => [
                                            '/file/manager/index'
                                        ],
                                        'icon' => '<i class="fa fa-television"></i>',
                                        'active' => (Yii::$app->controller->id == 'manager'),
                                    ],
                                ],
                                'visible' => Yii::$app->user->can('accessFiles'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Products'),
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'url' => [

                                    '/Product/product/admin'
                                ],
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'icon' => '<i class="fa fa-apple"></i>',
                                'active' => Yii::$app->controller->id === 'product' &&
                                    Yii::$app->controller->action->id !== 'uiblock',
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Overview'),
                                        'url' => [
                                            '/Product/product/admin'
                                        ],
                                        'icon' => '<i class="fa fa-list-alt"></i>',
                                        'active' => (Yii::$app->controller->id == 'product') &&
                                            Yii::$app->controller->action->id === 'admin',
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Create'),
                                        'url' => [
                                            '/Product/product/create'
                                        ],
                                        'icon' => '<i class="fa fa-database"></i>',
                                        'active' => (Yii::$app->controller->id == 'product') &&
                                            Yii::$app->controller->action->id === 'create',
                                    ],

                                ],
//                                'visible' => Yii::$app->user->can('accessProducts'),
                                'visible' => !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('hotline'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Blocking'),
                                'url' => [
                                    '/Product/product/uiblock'
                                ],
                                'icon' => '<i class="fa fa-hand-stop-o"></i>',
                                'active' => (Yii::$app->controller->id == 'product') &&
                                    Yii::$app->controller->action->id === 'uiblock',
                                'visible' => !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Time table'),
                                'url' => [
                                    '/Product/product/accesstimetable'
                                ],
                                'icon' => '<i class="fa fa-hand-stop-o"></i>',
                                'active' => (Yii::$app->controller->id == 'product') &&
                                    Yii::$app->controller->action->id === 'accesstimetable',
                                'visible' => !Yii::$app->user->can('streetSeller')
                            ],
                            [
                                'label' => Yii::t('backend', 'Payments'),
                                'url' => [
                                    '/Payment/payment/admin'
                                ],
                                'icon' => '<i class="fa fa-money"></i>',
                                'active' => (Yii::$app->controller->id == 'payment'),
                                'visible' => Yii::$app->user->can('accessPayments'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Bookings'),
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'url' => [
                                    '/Reservations/reservations/admin'
                                ],
                                'options' => [
                                    'class' => 'treeview'
                                ],
                                'icon' => '<i class="fa fa-check-square"></i>',
                                'active' => (Yii::$app->controller->id == 'reservations'),
                                'items' => [
                                    [
                                        'label' => Yii::t('backend', 'Reporting'),
                                        'icon' => '<i class="fa fa-bar-chart-o"></i>',
                                        'url' => [
                                            '/Reservations/reservations/reporting'
                                        ],
                                        'badge' => TimelineEvent::find()->today()->count(),
                                        'badgeBgClass' => 'label-success',
                                        'visible'=>Yii::$app->user->can('administrator')or Yii::$app->user->can('streetAdmin')
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Overview'),
                                        'url' => [
                                            '/Reservations/reservations/admin'
                                        ],
                                        'icon' => '<i class="fa fa-list-alt"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations') &&
                                            Yii::$app->controller->action->id === 'admin',
                                        'visible' => !Yii::$app->user->can('streetSeller'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Create'),
                                        'url' => [
                                            '/Reservations/reservations/create'
                                        ],
                                        'icon' => '<i class="fa fa-database"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations' &&
                                            Yii::$app->controller->action->id === 'create'),

                                        'visible' => !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('hotline'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Create'),
                                        'url' => [
                                            '/Reservations/reservations/create2'
                                        ],
                                        'icon' => '<i class="fa fa-font-awesome"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations' &&
                                            Yii::$app->controller->action->id === 'create2'),

                                    ],
                                    [
                                        'label' => Yii::t('backend', 'Create (new)'),
                                        'url' => [
                                            '/Reservations/reservations/create-react'
                                        ],
                                        'icon' => '<i class="fa fa-database"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations' &&
                                            Yii::$app->controller->action->id === 'create-react'),

                                        'visible' => !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('hotline'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'myReservations'),
                                        'url' => [
                                            '/Reservations/reservations/myreservations'
                                        ],
                                        'icon' => '<i class="fa fa-calendar"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations' &&
                                            Yii::$app->controller->action->id === 'myreservations'),
                                    ],
                                    [
                                        'label' => Yii::t('backend', 'my Transactions'),
                                        'url' => [
                                            '/Reservations/reservations/mytransactions'
                                        ],
                                        'icon' => '<i class="fa fa-dollar"></i>',
                                        'active' => (Yii::$app->controller->id == 'reservations' &&
                                            Yii::$app->controller->action->id === 'mytransactions'),
                                    ],
                                ],
                                'visible' => Yii::$app->user->can('accessBookings'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Statistics'),
                                'url' => [
                                    '/Statistics/statistics/admin'
                                ],
                                'icon' => '<i class="fa fa-line-chart"></i>',
                                'active' => (Yii::$app->controller->id == 'statistics'),
                                'visible' => Yii::$app->user->can('accessStatistics') && Yii::$app->user->can('viewStatisticsAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('streetAdmin') && !Yii::$app->user->can('streetSeller') && !Yii::$app->user->can('hotline'),
                            ],

                            [
                                'label' => Yii::t('backend', 'Key-Value Storage'),
                                'url' => [
                                    '/system/key-storage/index'
                                ],
                                'icon' => '<i class="fa fa-arrows-h"></i>',
                                'active' => (Yii::$app->controller->id == 'key-storage'),
                                'visible' => Yii::$app->user->can('accessKeyValueStorage'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Cache'),
                                'url' => [
                                    '/system/cache/index'
                                ],
                                'icon' => '<i class="fa fa-refresh"></i>',
                                'visible' => Yii::$app->user->can('accessSystemCache'),
                            ],
                            [
                                'label' => Yii::t('backend', 'System Information'),
                                'url' => [
                                    '/system/information/index'
                                ],
                                'icon' => '<i class="fa fa-dashboard"></i>',
                                'visible' => Yii::$app->user->can('accessSystemInformation'),
                            ],
                            [
                                'label' => Yii::t('backend', 'Logs'),
                                'url' => [
                                    '/system/log/index'
                                ],
                                'icon' => '<i class="fa fa-warning"></i>',
                                'badge' => SystemLog::find()->count(),
                                'badgeBgClass' => 'label-danger',
                                'visible' => Yii::$app->user->can('accessSystemLogs'),
                            ],
                        ],
                    ]);



            ?>
        </section>
		<!-- /.sidebar -->
	</aside>

	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
                <?php echo $this->title ?>
                <?php if (isset($this->params['subtitle'])): ?>
                    <small><?php echo $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>
            <?php
echo Breadcrumbs::widget(
                    [
                        'tag' => 'ol',
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])?>
        </section>

		<!-- Main content -->
		<section class="content">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php

echo Alert::widget(
                        [
                            'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                            'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                        ])?>
            <?php endif; ?>
            <?php echo $content ?>
        </section>
		<!-- /.content -->
	</aside>
	<!-- /.right-side -->
</div>
<!-- ./wrapper -->

<?php $this->endContent(); ?>
