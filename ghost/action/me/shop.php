<?php
require( '../../../../../wp-load.php' );
global $current_user;
$user_id = $current_user->ID;
$credit = !empty(ghost_get_option('ghost_shop_guajian_month_credit')) ? ghost_get_option('ghost_shop_guajian_month_credit') : 10;?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
							  <span class="ghost_setting_content_text">商城中心</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_notice_content_preface clearfix">
                    <div class="ghost_guajian_shop_title_menu clearfix">
                        <div><a data-type="credit" class="active ghost_guajian_shop_title_menu_item">积分挂件</a></div>
                        <div><a data-type="vip" class="ghost_guajian_shop_title_menu_item">正式会员挂件</a></div>
                        <div><a data-type="svip" class="ghost_guajian_shop_title_menu_item">大会员挂件</a></div>
                    </div>
                    <div class="ghost_shop_guajian_body">
                        <div class="ghost_guajian_shop_title">挂件购买</div>
                            <?php foreach(ghost_get_option('ghost_shop_guajian_credit') as $value) {?>
                            <div class="ghost_shops_item">
                                <a class="ghost_shop_item_link <?php echo ghost_shop_item_link_submit_credit($user_id); ?> clearfix" title="<?php echo $value['ghost_shop_guajian_name'] ?>">
                                    <div class="ghost_shop_item_thumbnail float-left">
                                        <img class="ghost_shop_item_img" src="<?php echo $value['ghost_shop_guajian_img'] ?>" alt="<?php echo $value['ghost_shop_guajian_name'] ?>" width="40" height="65"></div>
                                    <div class="ghost_shop_item_body float-left">
                                        <div class="ghost_shop_item_title"><?php echo $value['ghost_shop_guajian_name'] ?></div></div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
            </div>
        </fieldset>
    </div>
</div>