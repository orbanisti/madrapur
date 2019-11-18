<?php

    $bookingId=Yii::$app->request->get('id');


    ?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">



            <div class="card-body">
                <h3 class="card-title">

                    Successful order #<?=$bookingId?>, please follow the instructions sent to your Email.
                </h3>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>