<?php

/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

/**
 *
 * @return int|string
 */
function getMyId() {
    return Yii::$app->user->getId();
}

/**
 *
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = []) {
    return Yii::$app->controller->render($view, $params);
}

/**
 *
 * @param
 *            $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
//function redirect($url, $statusCode = 302) {
//    return Yii::$app->controller->redirect($url, $statusCode);
//}

/**
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null) {
    $value = getenv($key) ?? $_ENV[$key] ?? $_SERVER[$key];

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

function isLocalhost() {
    return in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
}

/**
 * @param $string
 * @param $start
 * @param $end
 *
 * @return array
 */
function get_string_between($string, $start, $end){
    $between = [];

    for ($i = 0; $i < count($start); ++$i) {
        $between[] = substr($string, $start[$i], $end[$i] - $start[$i]);
    }
    return $between;
}

/**
 * @param $body
 * @param $templateFields
 *
 * @return string
 */
function set_strings($body, $templateFields){
    foreach ($templateFields as $field) {
        $body = str_replace("{{".$field."}}", Yii::$app->request->post($field), $body);
    }
    return $body;
}

/**
 * @param $type
 * @param $message
 * @param string $category
 */
function sessionSetFlashAlert($type, $message, $category = 'backend') {
    Yii::$app->session->setFlash(
        'alert',
        [
            'options' => [
                'class' => 'alert-' . $type
            ],
            'body' => Yii::t($category, $message)
        ]
    );
}

function table_exists($tableName) {
    return !(Yii::$app->db->getTableSchema(Yii::$app->db->tablePrefix . $tableName, true) === null);
}