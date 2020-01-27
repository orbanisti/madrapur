<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fab fa-fantasy-flight-games  "></i>
                    Importer
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>



                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <?php

                        use kartik\form\ActiveForm;
                        use kartik\widgets\Select2;

                        $form = ActiveForm::begin(
                            [
                                'id' => 'product-edit',
                                'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],


                            ]
                        );
                    ?>

                        <h6>Mass hotel Importer</h6>
                        <p class="col-form-legend col-sm-1-12">Please write in a name to create new
                            hotel, separate with # in case of multiple records</p>


                            <input type="text" class="form-control" name="json" id="inputName" placeholder="">

<hr>
                    <?php

                    ?>

                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>


                    <?php
                        ActiveForm::end();
                    ?>

                    <?php


                        $form2 = ActiveForm::begin(
                            [
                                'id' => 'product-edit',
                                'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],


                            ]
                        );
                    ?>

                        <h6>Mass online partner importer</h6>

                        <p>Please write in a name to create new online
                            partner, separate with # in case of multiple records</p>


                            <input type="text" class="form-control" name="jsonPartner" id="inputName" placeholder="">


                    <?php

                    ?>

                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>


                    <?php
                        ActiveForm::end();
                    ?>

                </div>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>