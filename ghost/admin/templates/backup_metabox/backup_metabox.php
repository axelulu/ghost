<?php if(!defined('ABSPATH')){die;}
if(!class_exists('GHOST_Field_backup_metabox')){
class GHOST_Field_backup_metabox extends GHOST_Fields {

public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
parent::__construct( $field, $value, $unique, $where, $parent );
}

public function render(){
echo $this->field_before();
echo '
<div class="ghost-panel-field ghost-panel-field-backup">
<textarea id="ghost-admin-backup-metabox-val" class="ghost-panel-import-data" placeholder="把你备份的json设置数据复制在这里，然后点击导入按钮"></textarea>
<span class="button button-primary" onclick="ghost_amdin_backup_metabox_import()">导入数据</span>
<a href="javascript:" class="button button-primary" onclick="ghost_amdin_backup_metabox()" style="float:right;">备份数据</a>
</div>';
echo $this->field_after();
}

}
}
