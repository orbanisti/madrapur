<?php
define('MAX_FILE_LIMIT', 1024 * 1024 * 2);//2 Megabytes max html file size

function sanitizeFileName($fileName)
{
	//sanitize, remove double dot .. and remove get parameters if any
	$fileName = __DIR__ . '/' . preg_replace('@\?.*$@' , '', preg_replace('@\.{2,}@' , '', preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $fileName)));
    $fileName= str_replace("/VvvebJs","",$fileName);
	return $fileName;
}

$html = "";
if (isset($_POST['startTemplateUrl']) && !empty($_POST['startTemplateUrl'])) 
{
	$startTemplateUrl = sanitizeFileName($_POST['startTemplateUrl']);
	$html = file_get_contents($startTemplateUrl);
} else if (isset($_POST['html']))
{
	$html = substr($_POST['html'], 0, MAX_FILE_LIMIT);
}

$fileName = sanitizeFileName($_POST['fileName']);

/**
 * It kiveszem a dependencyket
 *
 */



$stripFromEndArray=['</body>',
                    '</html>'];
$stripfromStartArray=[
    '<html>',
    '<head>',
    '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">',
    '<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>',
    '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>',
    '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>',
    '</head>',
    '<body>'
];



if (file_put_contents($fileName, $html))
    echo $fileName;
else
    echo 'Error saving file '  . $fileName;

foreach($stripfromStartArray as $i=>$rule){
    $html2=str_replace($rule,"",$html);
}

foreach($stripfromStartArray as $i=>$rule){
    $html2=str_replace($rule,"",$html2);
}


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api.budapestrivercruise.co.uk/v1/rester/update-page-html-slug");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    "slug=".$_POST['slug']."&content=".$html2);

$exec=curl_exec($ch);





