
<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-times fa-lg fa-fw"></i>
                    User schedule
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div class="seo-default-index">
                    <?php

                        $Event = new \yii2fullcalendar\models\Event();
                    ?>
                    <h1><?= $this->context->action->uniqueId ?></h1>
                    <p>
                        This is the view content for action "<?= $this->context->action->id ?>".
                        The action belongs to the controller "<?= get_class($this->context) ?>"
                        in the "<?= $this->context->module->id ?>" module.
                    </p>
                    <p>
                        You may customize this page by editing the following file:<br>
                        <code><?= __FILE__ ?></code>
                    </p>
                </div>
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>