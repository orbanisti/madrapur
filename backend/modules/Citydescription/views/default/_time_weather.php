<?php
use kartik\helpers\Html;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
backend\assets\MomenttimezoneAsset::register($this);

$lang=substr(Yii::$app->language, 0, 2);
if($lang!='en' && $lang!='ru' && $lang!='it' && $lang!='es' && $lang!='sp' && $lang!='uk' && $lang!='ua' &&
    $lang!='de' && $lang!='pt' && $lang!='ro' && $lang!='pl' && $lang!='fi' && $lang!='nl' && $lang!='fr'
    && $lang!='bg' && $lang!='sv' && $lang!='se' && $lang!='zh' && $lang!='tr' && $lang!='hr' && $lang!='ca')
$lang='en';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';
$unitsimp = 'imperial';

// Create OpenWeatherMap object.
// Don't use caching (take a look into Examples/Cache.php to see how it works).
$owm = new OpenWeatherMap(Yii::$app->params['openweathermapApikey']);

?>
<div class="localtime">
    <?php
    if($code!='US') {
        $dzones=DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $code);
        $dzone=(!empty($dzones[0]))?$dzones[0]:false;
    } else {
        $dzone='America/Menominee';
    }
    if($dzone!=false) {
        echo '<h3>'.Yii::t('app','Helyi idő').'</h3>';
        $d = new DateTime("now", new DateTimeZone($dzone));
        echo '<div id="localtime">'.$d->format('H:i:s').'</div>';
        ?>
        <script>
            setInterval(function() {
                var dt = moment.tz(moment().format(), "<?= $dzone ?>");
                $("#localtime").html(dt.format('HH:mm:ss'));
            }, 1000);
        </script>
    <?php
    }
    ?>
</div>
<?php try {
    $weather = $owm->getWeather($name, $units, $lang);
    $weatherimp = $owm->getWeather($name, $unitsimp, $lang);
    ?>
<div class="localweather">
     <h3><?= Yii::t('app','Időjárás') ?></h3>
     <?php
        /*echo 'Hőmérséklet: '.$weather->temperature;
        echo "<br />\n";
        echo 'Páratartalom: '.$weather->humidity;
        echo "<br />\n";
        echo 'Város: '.$weather->city->name;
        echo "<br />\n";
        echo 'Lon: '.$weather->city->lon;
        echo "<br />\n";
        echo 'Lat: '.$weather->city->lat;
        echo "<br />\n";
        echo 'Ország: '.$weather->city->country;
        echo "<br />\n";
        echo 'Felhőzet: '.$weather->clouds->getDescription().' ('.$weather->clouds.')';
        echo "<br />\n";*/

        //echo Html::img('http://openweathermap.org/img/w/'.$weather->weather->icon.'.png').'<br/>';
        $tempc=explode(' ',$weather->temperature);
        $tempc=(int)$tempc[0].' '.end($tempc);
        $tempf=explode(' ',$weatherimp->temperature);
        $tempf=(int)$tempf[0].' '.end($tempf);
        echo Html::img('/images/weather/'.$weather->weather->icon.'.png').'<br/>';
        echo $tempc.' / '.$tempf;
    ?>
</div>
<?php
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}
?>