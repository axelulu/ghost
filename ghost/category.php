<?php
get_header();
$category_id = get_query_var('cat');
$this_category = get_category($cat);
$paged = get_query_var('paged');
$category_link = get_category_link( $category_id );
$parents_id = salong_category_top_parent_id($category_id);
?>
<div class="main cat container">
    <!-- 面包屑 -->
    <div style="margin: 0px auto;padding: 5px 5px 0px 5px;" class="header white crumb-container"> 
        <nav class="poi-crumb"> 
            <a href="<?php echo get_bloginfo('url'); ?>" class="poi-crumb__item poi-crumb__link poi-crumb__item_home" title="返回到首页" aria-label="返回到首页"> <i class="fa-home fas poi-icon poi-crumb__item__icon poi-crumb__item__home__icon" aria-hidden="true"></i> </a>
            <span class="poi-crumb__split"><i class="fa-angle-right fas poi-icon" aria-hidden="true"></i> </span>
            <?php if($this_category->category_parent != 0){ ?>
            <a class="poi-crumb__item poi-crumb__link" href="<?php echo get_category_link($parents_id) ?>"><?php echo get_cat_name($parents_id) ?></a>
            <span class="poi-crumb__split"><i class="fa-angle-right fas poi-icon" aria-hidden="true"></i> </span>
            <?php } ?>
            <a class="poi-crumb__item poi-crumb__link" href="<?php echo $category_link ?>"><?php echo get_cat_name($category_id) ?></a>
            <span class="poi-crumb__split"><i class="fa-angle-right fas poi-icon" aria-hidden="true"></i> </span>
            <span class="poi-crumb__item">目录浏览</span> 
        </nav> 
    </div>
    <!-- 排序 -->
    <div style="margin: 0px auto;margin-top: 0px;padding: 0px 5px 5px 5px;" class="header white crumb-container"> 
        <nav data-id="<?php echo $category_id;?>" class="paixu poi-crumb"> 
            <a data-paixu="date" class="is-active ghost-paixu">按最新</a>
            <a data-paixu="comment_count" class="ghost-paixu">按评论</a>
            <a data-paixu="date" class="ghost-paixu">按日期</a>
            <a data-paixu="views" class="ghost-paixu">按查看</a>
            <a data-paixu="rand" class="ghost-paixu">随机</a>
        </nav> 
    </div>
    <!-- 分类文章 -->
    <div class="cat_ajax_post">
        <?php require(get_template_directory().'/mod/style/cat-1.php'); ?>
    </div>
</div>
<?php get_footer();?>