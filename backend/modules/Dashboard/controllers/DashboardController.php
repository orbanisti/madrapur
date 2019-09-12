<?php

namespace backend\modules\Dashboard\controllers;

use backend\controllers\Controller;
use backend\modules\Tickets\models\TicketBlockSearchModel;
use Yii;

/**
 * Controller for the `Dashboard` module
 */
class DashboardController extends Controller {
    /**
     * Renders the admin view for the module
     *
     * @return string
     */
    public function actionAdmin() {
        $viewType = '';
        $viewName = 'admin';
        sessionSetFlashAlert('warning', "Screen under construction");

        if (Yii::$app->user->can("hotline")) {
            $viewType = 'hotline/';
            $viewName = 'admin';
            sessionSetFlashAlert('warning', "Screen under construction");
        }

        if (Yii::$app->user->can("streetSeller")) {
            $viewType = 'seller/';
            $viewName = 'admin';

            if ($cb = Yii::$app->request->get('change-ticket-block')) {
                $block = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if ($block && $block->returnStartId() !== $cb) {
                    $block->isActive = false;
                    $block->save(false);
                }

                $block = null;
            }

            if ($id = Yii::$app->request->get('id')) {
                $ticketBlockSearchModel = TicketBlockSearchModel::findOne(['=', 'id', $id]);
                $alreadyActive = false;

                if ($ticketBlockSearchModel && $ticketBlockSearchModel->isActive) {
                    $alreadyActive = true;
                } else {
                    $ticketBlockSearchModel->isActive = true;

                    if ($ticketBlockSearchModel->save(false)) {
                        sessionSetFlashAlert(
                            'success',
                            'Ticket block set successfully!<br>Have a bright day!'
                        );
                    }
                }
            }

            if ((!$id) || (isset($alreadyActive) && $alreadyActive)) {
                $assignedBlock = TicketBlockSearchModel::find()
                    ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                    ->andWhere('isActive IS TRUE')
                    ->one();

                if (!$assignedBlock) {
                    $ownBlocks = TicketBlockSearchModel::find()->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])->all();

                    if (0 === count($ownBlocks)) {
                        sessionSetFlashAlert(
                            'warning',
                            'No ticket block found. :(<br>Have a bright day!'
                        );
                    } else if (1 < count($ownBlocks)) {
                        $viewName = 'selectTicket';

                        $selectTicket = new \stdClass();
                        $selectTicket->searchModel = new TicketBlockSearchModel();
                        $selectTicket->dataProvider = $selectTicket->searchModel->search([]);
                        $selectTicket->gridColumns = [
                            'startId',
                            [
                                'label' => 'Current Ticket ID',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return $model->returnCurrentId();
                                }
                            ],
                            [
                                'label' => 'Activate block',
                                'format' => 'html',
                                'value' => function (TicketBlockSearchModel $model) {
                                    return '<a href="/Dashboard/dashboard/admin?id=' . $model->returnId() . '">Activate block' . '</a>';
                                }
                            ],
                        ];
                    } else {
                        $ticketBlockSearchModel = $ownBlocks[0];
                        $ticketBlockSearchModel->isActive = true;

                        if ($ticketBlockSearchModel->save(false)) {
                            sessionSetFlashAlert(
                                'success',
                                'Active ticket block set automatically.<br>Have a bright day!'
                            );
                        }

                        $assignedBlock = $ticketBlockSearchModel;
                    }
                }

                if ($assignedBlock && $skipTicket = Yii::$app->request->get('skip-ticket') === $assignedBlock->returnCurrentId()) {
                    sessionSetFlashAlert('warning', 'Ticket skipped.');

                    $assignedBlock->skipCurrentTicket();
                }
            }
        }

        return $this->render(
            $viewType . $viewName, [
                'ownBlocks' => isset($ownBlocks) ? $ownBlocks : [],
                'startTicketId' => isset($assignedBlock) ? $assignedBlock->returnStartId() : 'N/A',
                'nextTicketId' => isset($assignedBlock) ? $assignedBlock->returnCurrentId() : 'N/A',
                'selectTicket' => isset($selectTicket) ? $selectTicket : null,

            ]
        );
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
