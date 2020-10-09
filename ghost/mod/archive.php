<?php 
$tagName = single_tag_title('',false);
$tagObject = get_term_by('name',$tagName,'post_tag');
$tagID = $tagObject->term_id;
$archive=get_redis('archive'.$tagID,'archive',0,0,$tagID);
?>
<section class="cat-2 cat-col cat-col-full">
    <div class="cat-container clearfix">
            <div id="ghost_box_1" class="cms-cat cms-cat-s7">
                <?php echo $archive;?>
                <div class="ghost_other_more_post">
                    <a data-paged="<?php echo get_query_var('paged') ?>" data-tag="<?php echo $tagID ?>" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
                </div>
                </div>
                <script>
                    jQuery(function ($) {
                        $(".ajax-morepost").click(function(){
                            $page = $('.ajax-morepost').attr('data-paged');
                            $tag = $('.ajax-morepost').attr('data-tag');
                            $('.ajax-morepost').attr('data-paged',++$page);
                            $.ajax({
                                url:ghost.ghost_ajax+"/action/archive.php",
                                type:'POST',   
                                data:{page: $page,tag: $tag},
                                success:function(msg){
                                    if(msg.status==0){
                                        $('.ajax-morepost').html("加载完毕");
                                    }else{
                                        $('#ghost_box_1').append(msg);
                                        $('.page-'+($page+1)+' img.lazy').lazyload({
                                            effect: "fadeIn",
                                        });
                                    }
                                }
                            });
                        });
                    });
                </script>                    
        </div>
</section>