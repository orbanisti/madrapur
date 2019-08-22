<?php
$mailbody=$email->body;

 function htmlCompress($html)
{
    preg_match_all('!(<(?:code|pre|script).*>[^<]+</(?:code|pre|script)>)!',$html,$pre);
    $html = preg_replace('!<(?:code|pre).*>[^<]+</(?:code|pre)>!', '#pre#', $html);
    $html = preg_replace('#<!–[^\[].+–>#', '', $html);
    $html = preg_replace('/[\r\n\t]+/', ' ', $html);
    $html = preg_replace('/>[\s]+</', '><', $html);
    $html = preg_replace('/[\s]+/', ' ', $html);
    if (!empty($pre[0])) {
        foreach ($pre[0] as $tag) {
            $html = preg_replace('!#pre#!', $tag, $html,1);
        }
    }
    return $html;
}

$mailbody=htmlCompress($mailbody);

?>

<div class="modmail-default-index">

    <h1><?= $this->context->action->uniqueId ?></h1>

    <div class="row">
        <div class="col-xs-6">
            <iframe id="mailFrame" src="about:blank">


            </iframe>
            <script type="text/javascript">
                var doc = document.getElementById('mailFrame').contentWindow.document;
                doc.open();
                doc.write(`<?php echo $mailbody?>`);
                doc.close();
            </script>
        </div>
        <div class="col-xs-6">
s
        </div>
    </div>

</div>


