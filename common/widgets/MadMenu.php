<?php
/**
 * Created
 * by
 * PhpStorm.
 * User:
 * ROG
 * Date:
 * 9/18/2019
 * Time:
 * 10:56
 * PM
 */

namespace common\widgets;

use backend\controllers\SiteController;
use backend\widgets\Menu;
use Closure;
use Yii;
use yii\helpers\Html;

class MadMenu extends Menu {

    /**
     * @param array $items
     * @param bool $active
     *
     * @return array
     */
    protected function normalizeItems($items, &$active) {
        foreach ($items as $i => $item) {
            if (isset($item["url"])) {
                if (is_array($item["url"])) {
                    $url = $item["url"][0];
                    $splitUrl = explode("/", $url);

                    if (count($splitUrl) >= 3) {
                        $controllerClass = "backend\\modules\\" . $splitUrl[1] . "\\controllers\\" . $splitUrl[1] . "Controller";
                        // backend\modules\Tickets\controllers\TicketsController
                        // /Tickets/tickets/admin


                        $visible = SiteController::getActionBan($controllerClass, $splitUrl[count($splitUrl) - 1]);

                        if (!$visible) {
                            unset($items[$i]);
                            continue;
                        }
                    }
                }
            }


            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof Closure) {
                $active = $items[$i]['active'] = call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this);
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }
}