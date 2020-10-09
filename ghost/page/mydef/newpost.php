<?php
get_header();
if(is_user_logged_in()):
?>
<div class="main">
    <div class="clearfix container setting">
        <div class="col-lg-2 float-left">
            <?php require(get_template_directory().'/mod/sidebar.php');?>
        </div>
        <div class="col-lg-10 float-right setting_box">
            <script>jQuery(function ($) {$('.ghost_sidebar_item_sub_item_link[data-type="newpost"]').trigger('click');});</script>
        </div>
    </div>
</div>
<?php require(get_template_directory().'/mod/me-footer.php');?>
<?php else:?>
    <div class="user_not_login"></div>
    <script>jQuery(function ($) {$('.user-login').trigger('click');});</script>
<?php endif;get_footer();?>