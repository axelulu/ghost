<?php
get_header();
?>

<div class="main">
	<div class="search container">
        <form action="<?php echo get_bloginfo('url') ?>" class="ghost_search_form">
            <div class="ghost_search_form_container">
                <label for="ghost_search_form_s" class="ghost_search_form_input_label">
                    <span class="poi-icon fa-search fas fa-fw" aria-hidden="true"></span>
                </label>
                <input type="search" name="s" class="ghost_search_form_s" placeholder="您想搜索什么？" value="<?php echo get_search_query(); ?>"></div>
            <div class="ghost_search_form_cat_container">
                <div class="ghost_search_form_group">
                    <span class="ghost_search_form_group_title">分类</span>
                    <div class="ghost_search_form_condition_container">
                        <div class="ghost_search_form_condition_group">
                        <?php 
                        $args=array(
                            'orderby' => 'name',
                            'order' => 'ASC'
                        );
                        $categories=get_categories($args);
                        foreach($categories as $category) {
                            echo '<label class="ghost_search_form_condition_label"><input type="radio" hidden="" value="0" checked=""><span data-id="'.$category->term_id.'" data-page="'.get_query_var('paged').'" class="ghost_search_form_condition_text is-checked">'.$category->name.'</span></label>';
                        }
                        ?>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </form>
        <div class="search_box">
            <?php require(get_template_directory().'/mod/search_box.php'); ?>
        </div>
    </div>
</div>
<?php
get_footer();