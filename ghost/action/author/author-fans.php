<?php
require( '../../../../../wp-load.php' );
global $wpdb;
$user_id =  $_POST['uid'];
$user_data = get_userdata($user_id);
$request = "SELECT fans_id FROM wp_ghost_fans WHERE user_id=$user_id";
$fan = $wpdb->get_results($request);
?>
<div class="clearfix">
    <?php 
    if($fan){
        foreach($fan as $fans ){ ?>
        <div class="ghost_user_item float-left">
            <a class="ghost_user_item_link" href="<?php echo ghost_get_user_author_link($fans->fans_id); ?>">
                <img title="<?php echo get_user_meta($fans->fans_id,'nickname',true) ?>" alt="<?php echo get_user_meta($fans->fans_id,'nickname',true) ?>" class="ghost_user_item_avatar_img" src="<?php echo get_user_meta($fans->fans_id,'ghost_user_avatar',true) ?>" width="100" height="100"></a>
            <a class="ghost_user_item_author_link" href="<?php echo ghost_get_user_author_link($fans->fans_id); ?>" target="_self" title="<?php echo get_user_meta($fans->fans_id,'nickname',true) ?>">
                <span class="ghost_user_item_author_name"><?php echo get_user_meta($fans->fans_id,'nickname',true) ?></span></a>
        </div>
        <?php } ?>
    <?php }else{
        require(get_template_directory().'/mod/error.php');
    } ?>
</div>