<?php
$user = (object) [
    'name' => 'Jane Doe',
    'email' => 'janedoe@gmail.com',
    'logged' => true
];
?>
    <link rel="stylesheet" href="/app/assets/css/app.css" type="text/css">

<script type="text/javascript">
    var STATIC_URL = 'http://localhost/my-app';
    var myApp = {
        user : <?php echo json_encode($user); ?>,
        logged : <?php echo $user->logged; ?>
    };
</script>


<div id="madrapurScreens"></div>

<script type="text/javascript" src="../../react/app/assets/bundle/main.bundle.js" ></script>
