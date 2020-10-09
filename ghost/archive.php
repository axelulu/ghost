<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package pink
 */

get_header();
global $wp_query;
?>
<div class="main archive container">
    <!-- 面包屑 -->
    <div style="margin: 0px auto;padding: 5px 5px 0px 5px;" class="header white crumb-container"> 
        <nav class="poi-crumb"> 
            <a href="<?php echo get_bloginfo('url'); ?>" class="poi-crumb__item poi-crumb__link poi-crumb__item_home" title="返回到首页" aria-label="返回到首页"> <i class="fa-home fas poi-icon poi-crumb__item__icon poi-crumb__item__home__icon" aria-hidden="true"></i> </a>
            <span class="poi-crumb__split"><i class="fa-angle-right fas poi-icon" aria-hidden="true"></i> </span>
            <a class="poi-crumb__item poi-crumb__link" href="<?php echo $parent_link ?>">动漫美图</a>
            <span class="poi-crumb__split"><i class="fa-angle-right fas poi-icon" aria-hidden="true"></i> </span>
            <a class="poi-crumb__item poi-crumb__link" href="<?php echo $category_link ?>">P站美图</a>
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
        <?php require(get_template_directory().'/mod/archive.php'); ?>
    </div>
</div>
<?php
get_footer();
