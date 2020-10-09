<?php
get_header();
?>
<div class="main">
        <!-- 幻灯片 -->
        <?php require(get_template_directory().'/mod/popular.php'); ?>
			<div class="container">
			<!-- 公告 -->
			<?php if(ghost_get_option('ghost_site_notice')):?>
			<div class="container">
				<div class="ghost_site_notice">
					<?php echo ghost_get_option('ghost_site_notice'); ?>
				</div>
			</div>
			<?php endif;?>
			<div class="container">
			<!--广告-->
        <?php echo ghost_get_option('ghost_adv_main'); ?>
			<!-- box -->
        <?php 
        $cms = ghost_get_option('ghost_pc_cms');
        if(is_array($cms)){
        foreach ($cms as $cms_group){
            if($cms_group['ghost_pc_cms_box']==1){
                require(get_template_directory().'/mod/style/box-1.php'); 
            }else if($cms_group['ghost_pc_cms_box']==2){
                require(get_template_directory().'/mod/style/box-2.php'); 
            }else if($cms_group['ghost_pc_cms_box']==3){
                require(get_template_directory().'/mod/style/box-3.php');
            }
        }}?>
    </div>
</div>
<?php get_footer();?>