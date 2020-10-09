<?php 
$popular=get_redis('popular','popular');
?>
<section id="mod-show" class="content-section clearfix full">
    <div id="popular">
        <div id="ghost-popular-container" class="ghost-popular-container">
            <div class="ghost-popular">
            <?php echo $popular; ?>
            </div>
        </div>
    </div>
</section>