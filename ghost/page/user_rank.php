<?php 
/* Template Name: 用户排行 */ 
get_header();
$userrank=get_redis('userrank','user_rank');
?>
<div style="margin-top:10px;padding-bottom: 40px;" class="main user_credit container">
	<nav>
    <ul class="ghost_sign_nav">
        <li data-type="new" class="active ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
						<span class="ghost_sign_nav_text">最新签到</span></a>
        </li>
        <li data-type="num" class="ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
						<span class="ghost_sign_nav_text">签到最多</span></a>
        </li>
        <li data-type="credit" class="ghost_sign_nav_item">
            <a class="ghost_sign_nav_item_link">
                <span class="poi-icon fa-star fas fa-fw" aria-hidden="true"></span>
						<span class="ghost_sign_nav_text">积分排行</span></a>
        </li>
    </ul>
</nav>
    <div class="clearfix ajax_moreuser">
        <?php echo $userrank;?>
    </div>
		<div class="float-right ghost_other_more_post">
			<a data-paged="1" class="more-post ajax-morepost">更多文章 <i class="tico tico-angle-right"></i></a>
		</div>
</div>
<?php get_footer();?>