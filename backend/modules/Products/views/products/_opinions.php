<div class="item active">
    <div class="row mrow">
        <?php
        $i=1;
        foreach ($model->opinions as $opinion) {
            echo $this->render('@webroot/modules/Products/views/products/_opinion', ['model'=> $opinion]);
            if(($i%4)==0 && $i!=count($model->opinions))
                echo '</div></div><div class="item"><div class="row mrow">';
            $i++;        
            
        } ?>
  </div>
</div>