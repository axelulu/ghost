<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $current_user->ID;?>
<div class="ghost_guajian_shop_title">挂件购买</div>
    <?php foreach(ghost_get_option('ghost_shop_guajian_svip') as $value) {?>
    <div class="ghost_shops_item">
        <a class="ghost_shop_item_link <?php echo ghost_shop_item_link_submit_svip($user_id); ?> clearfix" title="<?php echo $value['ghost_shop_guajian_name'] ?>">
            <div class="ghost_shop_item_thumbnail float-left">
                <img class="ghost_shop_item_img" src="<?php echo $value['ghost_shop_guajian_img'] ?>" alt="<?php echo $value['ghost_shop_guajian_name'] ?>" width="40" height="65"></div>
            <div class="ghost_shop_item_body float-left">
                <div class="ghost_shop_item_title"><?php echo $value['ghost_shop_guajian_name'] ?></div></div>
        </a>
    </div>
    <?php } ?>
</div>