<?php
$cat_id = $cms_group['ghost_pc_cms_id'];
$headbox3=get_redis('headbox3'.$cat_id,'headbox3',$cat_id);
?>
<div class="headbox3">
	<div class="headbox3_bg">
		<section class="container ghost_nav style-1 cat-col cat-col-full">
			<div data-cat="<?php echo $cat_id;?>" class="cat-container clearfix">
				<div class="ghost-homebox__header ghost-panel__header poi-panel__header"> 
					<h4 class="ghost-homebox__title ghost-panel__title poi-panel__title"> <a href="https://ghost.com/dmzx" class="ghost-homebox__title__link"> <span class="ghost-homebox__title__icon__mask" style="color: #61b4ca"> <i class="<?php echo $cms_group['ghost_pc_cms_icon'] ?> poi-icon ghost-homebox__title__icon" aria-hidden="true"></i> </span> <span style="color:#000" class="ghost-homebox__title__text"><?php echo get_cat_name($cat_id) ?></span> </a> </h4> 
						<span style="-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;"></span>
						<a data-type="data" class="active home_title_menu_item">最新</a>
						<a data-type="comment_count" class="home_title_menu_item">评论</a>
						<a data-type="views" class="home_title_menu_item">浏览</a>
						</div>
					<div id="ghost_box_1" class="cms-cat cms-cat-s7">
						<?php 
						echo $headbox3;
						?>
					</div>
				</div>
			<div class="ghost_home_more_post">
				<a class="more-post" href="<?php echo get_category_link($cat_id); ?>">更多文章 <i class="tico tico-angle-right"></i></a>
			</div>
		</section>
	</div>
</div>
<?php 