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
                    <div class="form-group row">
                        <legend class="col-form-legend col-sm-1-12">Please write in a name to create new
                            partner, separate with # in case of multiple records</legend>

                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="json" id="inputName" placeholder="">
                        </div>
                    </div>
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