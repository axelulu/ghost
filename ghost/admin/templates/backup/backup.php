<?php if(!defined('ABSPATH')){die;}
if(!class_exists('GHOST_Field_backup')){
class GHOST_Field_backup extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render(){
$download_url = get_template_directory_uri().'/module/admin/action/admin-setting.php?download';
echo $this->field_before();
echo '<div class="ghost-panel-notice ghost-panel-notice-danger" style="margin-bottom: 30px;">【注意】请一定要及时备份一份最新的设置数据，以防万一。关于造成后台设置数据丢失的原因请<a href="https://q.ghost.cn/11671.html" target="_blank" style="color:#f00;">《点击这里查看》</a></div>';
echo '<div class="ghost-panel-notice ghost-panel-notice-danger" style="margin-bottom: 30px;">这里备份的仅仅是面板的设置数据，并不包括WordPress的内容、导航菜单、小工具等数据</div>';

echo '<textarea readonly="readonly" class="ghost-panel-export-data">'.json_encode(get_option($this->unique)).'</textarea>';
echo '<a href="'.$download_url.'" class="button button-primary ghost-panel-export target="_blank">下载设置数据</a>';
echo '<small style="color:#f00;">提醒：平时有空的时候可以下载一份后台设置数据进行备份，毕竟要设置的东西太多了。</small>';
echo '<hr />';

echo '<textarea id="ghost-admin-backup-export-val" class="ghost-panel-import-data" placeholder="把你的备份的json设置数据复制在这里，然后点击导入按钮"></textarea>';
echo '<span class="button button-primary" onclick="ghost_admin_backup_export()">导入设置数据</span>';
echo '<small>如果需要清空设置数据，请输入：<font style="color:#f00;">delete</font></small>';
echo $this->field_after();
}

}
}
