<?php

?>

<div
    class="row">
    <div
        class="col-12">
        <!-- interactive chart -->
        <div
            class="card card-primary card-outline">
            <div
                class="card-header">
                <h3
                    class="card-title">

                </h3>
                ​
                <div
                    class="card-tools">

                </div>
            </div>
            <div
                class="card-body">
                ​​<?php use kartik\helpers\Html;

                foreach ($modelAddOns as $i => $modelAddOn): ?>
                    <div class="row item-times">
                        <div class="col-12">
                            <!-- interactive chart -->
                            <?php
                            echo $form->field(
                                    $modelAddOn, "[{$i}]id"
                                )->checkbox([
                                    'value' => $modelAddOn->id,
                                    'checked' => in_array($modelAddOn->id, $selectedModelAddOns),
                                ])->label($modelAddOn->name);
                            ?>
                            ​
                        </div>

                        <!-- /.col -->
                    </div>

                <?php endforeach; ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->
        ​
    </div>

    <!-- /.col -->
</div>
