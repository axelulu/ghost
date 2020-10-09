<?php
require( '../../../../../wp-load.php' );
if( current_user_can( 'visitor' ) ) {
?>
<div class="ghost_setting_content">
    <div class="drafts ghost_setting_content_container">
        <fieldset class="ghost_setting_content_item">
            <legend class="ghost_setting_content_item_title">
                <span class="ghost_setting_content_primary">
                    <span class="poi-icon fa-user-circle fas fa-fw" aria-hidden="true"></span>
                    <span class="ghost_setting_content_text">答题得会员</span></span>
            </legend>
            <div class="ghost_setting_content_item_content">
                <div class="ghost_setting_content_preface">
                    <p>您可以在这个页面查看您发布过的帖子，鼠标悬浮即可见编辑按钮。</p>
                    <p>重新编辑帖子后需要二次审核，请谨慎编辑哦！</p>
                </div>
                <div class="ghost_notice_content_preface">
                    <?php 
                    global $current_user;
                    global $wpdb;
                    if(is_user_logged_in()){
                    ?>
                    <div class="user_test">
                            <!--demo1 答题卡-->
                            <div id="test_form" class="card_wrap">
                                <?php $arr=ghost_get_option( 'dati_add' );$i=0;
                                foreach($arr as $value){ ?>
                                <div id="qu_<?php echo $i; ?>" class="user_test_card_cont">
                                    <div class="user_test_card">
                                        <p data-num="<?php echo $i; ?>" class="test_content_nr_main question"><span><?php echo $i+1; ?>、</span><?php echo $value['ti_content'] ?></p>
                                        <ul class="clearfix user_test_select">
                                            <li class="user_test_item">
                                                <input class="user_test_input" id="q<?php echo $i; ?>_1" type="radio" name="answer<?php echo $i; ?>" value="a" title="<?php echo $value['ti_select_a'] ?>">
                                                <label class="user_test_label" for="q<?php echo $i; ?>_1">A. <?php echo $value['ti_select_a'] ?></label>
                                            </li>
                                            <li class="user_test_item">
                                                <input class="user_test_input" id="q<?php echo $i; ?>_2" type="radio" name="answer<?php echo $i; ?>" value="b" title="<?php echo $value['ti_select_b'] ?>">
                                                <label class="user_test_label" for="q<?php echo $i; ?>_2">B. <?php echo $value['ti_select_b'] ?></label>
                                            </li>
                                            <li class="user_test_item">
                                                <input class="user_test_input" id="q<?php echo $i; ?>_3" type="radio" name="answer<?php echo $i; ?>" value="c" title="<?php echo $value['ti_select_c'] ?>">
                                                <label class="user_test_label" for="q<?php echo $i; ?>_3">C. <?php echo $value['ti_select_c'] ?></label>
                                            </li>
                                            <li class="user_test_item">
                                                <input class="user_test_input" id="q<?php echo $i; ?>_4" type="radio" name="answer<?php echo $i; ?>" value="d" title="<?php echo $value['ti_select_d'] ?>">
                                                <label class="user_test_label" for="q<?php echo $i; ?>_4">D. <?php echo $value['ti_select_d'] ?></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php $i++;} ?>
                            </div>
                            <div class="commit"><input class="ghost_setting_content_btn_success btn_commit" value="交卷" id="test_jiaojuan" type="button" name="test_jiaojuan" value="jiaojuan"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<?php }