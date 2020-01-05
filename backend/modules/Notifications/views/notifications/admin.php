<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-dark ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-bell fa-fw" aria-hidden="true"></i>Notifications
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn  btn-tool" data-card-widget="collapse"><i class="fas
                    fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class=" card-body bg-gradient-gray-dark">
                <p>Hello, <strong><?=Yii::$app->user->getIdentity()->username?></strong></p>

                <?php use yii\helpers\Html;
                        \frontend\assets\MdbButtonsAsset::register($this);
                    echo Html::submitButton(Yii::t('backend', 'Sign up for notifications <i class="fa fa-check" aria-hidden="true"></i>'), ['class' => 'btn 
                    btn-deep-purple text-white']) ?>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>


<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-analytics.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyB-94v6fBOnYn5N9uwKRIpRpM-QOMulfTY",
        authDomain: "madapp-261810.firebaseapp.com",
        databaseURL: "https://madapp-261810.firebaseio.com",
        projectId: "madapp-261810",
        storageBucket: "madapp-261810.appspot.com",
        messagingSenderId: "166074247690",
        appId: "1:166074247690:web:d17ac61d41c9577ce98df3",
        measurementId: "G-NELQFX961G"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
</script>
<script src="/js/firebase-messaging-sw.js?ver=<?=rand()?>"></script>