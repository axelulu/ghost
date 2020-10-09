<?php 
/* Template Name: 文章排行 */ 
get_header();
$postrank=get_redis('postrank','post_rank');
?>
<div style="margin-top:10px" class="main post_rank container">
	<nav>
    <ul class="ghost_sign_nav">
        <li data-type="data" class="active ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_sign_nav_text">最新文章</span></a>
        </li>
        <li data-type="comment_count" class="ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_sign_nav_text">评论最多</span></a>
        </li>
        <li data-type="views" class="ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_sign_nav_text">浏览最多</span></a>
        </li>
    </ul>
</nav>
    <div class="clearfix ajax_morepost postrank">
        <?php 
				echo $postrank;
        ?>
    </div>
    <div class="ghost_home_more_post">
        <a data-paged="1" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
    </div>
</div>
<?php get_footer();?>