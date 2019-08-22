<?php

namespace backend\modules\Modmail\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use backend\modules\Product\models\ProductAdminSearchModel;
use PhpParser\Node\Expr\AssignOp\Mod;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Default model for the `Modmail` module
 */
class Modmail extends MadActiveRecord {

    public $templateId;
 
    public static function tableName() {
        return 'modmail';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['type','from','to','status','subject'], 'string', 'max' => 255],
            [['body'], 'string', 'max' => 100000],
            [['date'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'source' => Yii::t('app', 'Forrás'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }

    public function search($params)
    {
        #  $invoiceDate = '2016-02-05';
        # $bookingDate = '2020-08-20';

        $what = ['*'];
        $from = self::tableName();
        $where = self::andWhereFilter([
            ['id', '!=', '0'],
        ]);


        $rows = self::aSelect(Modmail::class, $what, $from,$where);

        $dataProvider = new ActiveDataProvider([
            'query' => $rows,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }
    public function returnId() {
        return $this['id'];
    }

    public static function send($postedData) {
        $bootstrap='<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
        $bootstrap.='<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >';

        $to = $postedData['to'];
        $from = $postedData['from'];
        $subject = $postedData['subject'];
        $type = $postedData['type'];

        $postedData['date'] = date('Y-m-d h:i');

        $txt = "";//Modmail::insertVars($asd);

        $postedData['body'] = $txt;

        $txt = $bootstrap;//.$welcomeHTML;
        $headers = "From: $from" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if (mail("alpe15.1992@gmail.com", $subject, $txt, $headers)) {
            $postedData['status'] = 'sent';
            Modmail::insertOne(new Modmail(), $postedData);
        } else {
            $postedData['status'] = 'unsent';
            Modmail::insertOne(new Modmail(), $postedData);
        }
    }

    public static function sendWithReplace($postedData, $startPositions, $endPositions, $templateFields) {
        $bootstrap='<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
        $bootstrap.='<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >';

        $to = $postedData['to'];
        $from = $postedData['from'];
        $subject = $postedData['subject'];
        $templateId = $postedData['type'];

        $template = Mailtemplate::findOne(['=', 'id', $templateId]);
        $body = $template['body'];

        $postedData['date'] = date('Y-m-d h:i');

        function set_strings($body, $templateFields){
            foreach ($templateFields as $field) {
                $body = str_replace("{{".$field."}}", Yii::$app->request->post($field), $body);
            }
            return $body;
        }

        $txt = set_strings($body, $templateFields);

        $postedData['body'] = $txt;

        $txt = $bootstrap;//.$welcomeHTML;
        $headers = "From: $from" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if(mail($to,$subject,$txt,$headers)){
            $postedData['status'] = 'sent';
            Modmail::insertOne(new Modmail(), $postedData);
        } else {
            $postedData['status'] = 'unsent';
            Modmail::insertOne(new Modmail(), $postedData);
        }
    }
}
