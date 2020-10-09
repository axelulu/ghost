// 后台面板
jQuery(document).ready(function($) {


var patterns={validate:/^(?!_nonce)[a-zA-Z0-9_-]*(?:\[(?:\d*|(?!_nonce)[a-zA-Z0-9_-]+)\])*$/i,key:/[a-zA-Z0-9_-]+|(?=\[\])/g,named:/^[a-zA-Z0-9_-]+$/,push:/^$/,fixed:/^\d+$/};function FormSerializer(helper,$form){var data={},pushes={};function build(base,key,value){base[key]=value;return base;}
function makeObject(root,value){var keys=root.match(patterns.key),k;while((k=keys.pop())!==undefined){if(patterns.push.test(k)){var idx=incrementPush(root.replace(/\[\]$/,''));value=build([],idx,value);}
else if(patterns.fixed.test(k)){value=build([],k,value);}
else if(patterns.named.test(k)){value=build({},k,value);}}
return value;}
function incrementPush(key){if(pushes[key]===undefined){pushes[key]=0;}
return pushes[key]++;}
function addPair(pair){if(!patterns.validate.test(pair.name))return this;var obj=makeObject(pair.name,pair.value);data=helper.extend(true,data,obj);return this;}
function addPairs(pairs){if(!helper.isArray(pairs)){throw new Error("formSerializer.addPairs expects an Array");}
for(var i=0,len=pairs.length;i<len;i++){this.addPair(pairs[i]);}
return this;}
function serialize(){return data;}
function serializeJSON(){return JSON.stringify(serialize());}
this.addPair=addPair;this.addPairs=addPairs;this.serialize=serialize;this.serializeJSON=serializeJSON;}
FormSerializer.patterns=patterns;FormSerializer.serializeObject=function serializeObject(){return new FormSerializer($,this).addPairs(this.serializeArray()).serialize();};FormSerializer.serializeJSON=function serializeJSON(){return new FormSerializer($,this).addPairs(this.serializeArray()).serializeJSON();};if(typeof $.fn!=="undefined"){$.fn.serializeObjectLightSNS=FormSerializer.serializeObject;$.fn.serializeJSONLightSNS=FormSerializer.serializeJSON;}


$(".report_del_btn").click(function() {
	$this = $(this);
	$post_id = $this.attr('data-id');
	$user_id = $this.attr('data-userid');
	console.log($user_id);
	$.ajax({
		url: ghost.ghost_ajax_url+"/action/admin-del_report.php",
		data: {
			action: 'del_report',
			post_id: $post_id,
			user_id: $user_id
		},
		type: 'POST',
		success: function(msg) {
			layer.closeAll('loading');
			layer.msg(msg.msg);
			$this.closest('tr').remove();
		}
	});
});

//切换WordPress面板
$(".ghost-panel-header-left").click(function() {
if ($("#adminmenumain").css('display')=='block') {
$("#wpcontent").css("margin-left", "0px");
$("#adminmenumain").hide(0);
$(".ghost-admin-logo").removeClass('had_show')
} else {
$("#adminmenumain").show(0);
$("#wpcontent").css("margin-left", "160px");
$(".ghost-admin-logo").addClass('had_show')
}
});


//折叠菜单
$(".ghost-show-menu").click(function() {
if ($(".ghost-panel-nav").css('width')<='200px') {
$(this).children('i').addClass('fa-expand').removeClass('fa-compress');
$(".ghost-panel-nav").css("width", "48px").addClass('on');
$(".ghost-panel-content").css("margin-left", "88px");
$(".ghost-panel-nav ul li a span").hide();
$('.ghost-panel-nav ul li .ghost-panel-arrow:after').css('right','2px');

$('.ghost-panel-nav.on ul li').hover(function() {
if($('.ghost-panel-nav').hasClass('on')){
layer.tips($(this).find('span').html(), $(this));
}
}, function() {
layer.closeAll('tips');
});

} else {
$(this).children('i').addClass('fa-compress').removeClass('fa-expand');
$(".ghost-panel-nav ul li a span").show();
$(".ghost-panel-content").css("margin-left", "240px");
$('.ghost-panel-nav ul li .ghost-panel-arrow:after').css('right','10px');
$(".ghost-panel-nav").css("width", "200px").removeClass('on');

$('.ghost-panel-nav.on ul li').hover(function() {
}, function() {
});

}
});

//切换肤色
$('[name="ghost_options[ghost_panel_skin]"]').click(function(){
skin=$(this).val();
if(skin=='dark'){
$('.ghost-panel').addClass('ghost-panel-theme-dark').removeClass('ghost-panel-theme-light');
}else{
$('.ghost-panel').addClass('ghost-panel-theme-light').removeClass('ghost-panel-theme-dark');
}
});

//监听面板
$("input[name='ghost_options[ghost_panel_name]']").bind("input propertychange",function(event){
$('.ghost-panel-header-inner h1').html($(this).val());
});

layui.use(['layer'], function() {
$("#ghost-get-update-info").click(function() {
layer.load(1);
var my_domain = document.domain;
var url = ghost.author_update + "/update.php?callback=?&url=123";
jQuery.getJSON(url, function(data) {
layer.closeAll('loading');
layer.alert(data.version)
})
});
});



// 回车搜索
$(".ghost-panel-search input").keypress(function(e) {  
if(e.which == 13) {  
return false;
}  
}); 


layui.use('element', function() {
var element = layui.element
})
});

//导入备份
function ghost_admin_backup_export(){
backup=$('#ghost-admin-backup-export-val').val();
if(backup=='delete'){
title='你要确定要清空所有的设置选项吗？清空之后将恢复默认设置！';
}else{
title='你确定要导入备份设置吗？你之前的设置选项会被覆盖！';
}
layer.confirm(title,{
btnAlign: 'c',
}, function(){
layer.load(1);
$.ajax({
type:"POST",
url: ghost.ghost_ajax_url+"/admin/action/admin-setting.php",
data:{backup:backup},
success: function(msg){
layer.closeAll('loading');
layer.msg(msg.msg);
if(msg.code==1){
function c(){window.location.reload();}setTimeout(c,2000);
}
}
});
});
}

//metabox导出备份
function ghost_amdin_backup_metabox(){
post_id=ghost_getUrlParam('post');
window.open(ghost.theme_url+"/action/admin-setting-metabox-back.php?download&post_id="+post_id);
}


//metabox导入备份
function ghost_amdin_backup_metabox_import(){
backup=$('#ghost-admin-backup-metabox-val').val();
if(backup=='delete'){
title='你要确定要清空所有的设置选项吗？清空之后将恢复默认设置！';
}else{
title='你确定要导入备份设置吗？你之前的设置选项会被覆盖！';
}
post_id=ghost_getUrlParam('post');
layer.confirm(title,{
btnAlign: 'c',
}, function(){
layer.load(1);
$.ajax({
type:"POST",
url: ghost.ghost_ajax_url+"/admin/action/admin-setting-metabox-back.php",
data:{backup:backup,post_id:post_id},
success: function(msg){
layer.closeAll('loading');
layer.msg(msg.msg);
if(msg.code==1){
function c(){window.location.reload();}setTimeout(c,2000);
}
}
});
});
}


//保存设置
function ghost_admin_save_setting(){
data=$('#ghost-panel-form').serializeJSONLightSNS();
layer.load(1);
$.ajax({
type:"POST",
url: ghost.ghost_ajax_url+"/action/admin-save.php",
data:{data:data},
success: function(msg){
layer.closeAll('loading');
layer.msg(msg.msg);
if(msg.code==1){

}
}
});
}


function ghost_no(){
layer.msg("还没有写好啦！预留接口");	
}



function ghost_getUrlParam(name){
var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
var r = window.location.search.substr(1).match(reg);
if(r!=null)return  unescape(r[2]); return null;
}