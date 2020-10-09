<?php
$cat=get_redis('cat_'.$category_id,'cat',$category_id,$paged);
?>
<section class="cat-2 cat-col cat-col-full">
    <div class="cat-container clearfix">
            <div id="ghost_box_1" class="cms-cat cms-cat-s7">
                <?php echo $cat;?>
            </div>                            
        </div>
</section>