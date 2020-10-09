<?php
require_once get_theme_file_path() .'/admin/classes/setup.class.php';
if(isset($_GET['page'])&&$_GET['page']=='ghost'){
$theme_url=get_template_directory_uri();


$prefix = 'ghost_options';
GHOST::createOptions($prefix);
GHOST::createSection($prefix,
array(
'title'  => '<span>'.__('网站数据','ghost').'</span>',
'icon'   => 'fa fa-bar-chart',
'fields' => array(
array(
'type'       => 'panel',
),
)
));

GHOST::createSection($prefix,
array(
'id'    => 'ghost_pc',
'title'  => '<span>'.__('电脑端设置','ghost').'</span>',
'icon'   => 'fa fa-cog',
));

//ghost_pc_cms
GHOST::createSection( $prefix, array(
'parent'      => 'ghost_pc',
'title'       => '<span>'.__('首页设置','ghost').'</span>',
'icon'        => 'fa fa-vcard-o',
'fields'      => array(

array(
'id' => 'ghost_pc_cms',
'type' => 'group',
'title' => __('首页cms布局','ghost'),
'subtitle' => __('给网站首页添加cms布局','ghost'),
'button_title' => __('添加','ghost'),
'fields' => array(

array(
'id' => 'ghost_pc_cms_id',
'type' => 'text',
'title' => __('分类id','ghost'),
'subtitle'=>__('例如：1','ghost'),
),


array(
'id'      => 'ghost_pc_cms_icon',
'type'    => 'text',
'title'   => __('分类图标','ghost'),
'subtitle'=>__('例如：fa','ghost'),
'placeholder' => ''
),

array(
    'id'                 => 'ghost_pc_cms_box',
    'type'               => 'radio',
    'title'              => '模板样式',
    'subtitle'              => '选择模板样式',
    'options'            => array(
    '1'              => '样式一',
    '2'         => '样式二',
    '3'           => '样式三',
    ),
)
),
)
)
)
);


// 网站信息
GHOST::createSection($prefix,
array(
'id'    => 'ghost_site',
'title'  => '<span>'.__('基本设置','ghost').'</span>',
'icon'   => 'fa fa-cog',
));

//广告设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('广告设置','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'ghost_adv_main',
					'type' => 'textarea',
					'title' => '网站首页幻灯片下方广告',
					'subtitle'=>'网站首页幻灯片下方广告'
        ),
)));

//页面设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('其他设置','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'page_postrank_num',
            'type' => 'spinner',
            'default' => '18',
					'title' => '文章排行每页显示数量',
            'subtitle'=>'文章排行每页显示数量'
        ),
        array(
            'id' => 'user_visit_strtotime',
            'type' => 'spinner',
            'default' => '60',
            'title' => '用户访问记录时间',
            'subtitle'=>'用户访问统计的时间间隔时间(单位秒)'
        ),
        array(
            'id' => 'key_ip',
            'type' => 'text',
            'default' => '*******',
					'title' => '腾讯位置服务Key',
            'subtitle'=>'请到https://lbs.qq.com/申请接口'
        ),
        array(
            'id' => 'ghost_sign_url',
            'type' => 'text',
            'default' => 'https://pinkacg.com/sign',
					'title' => '签到页面地址',
            'subtitle'=>'签到页面地址'
        ),
        array(
            'id' => 'site-color',
            'type' => 'color',
            'default' => '#ff6699',
            'title' => '站点主体颜色',
            'subtitle'=>'站点主体颜色'
        ),
        array(
            'id' => 'site-color-tag',
            'type' => 'color',
            'default' => '#ff669996',
            'title' => '站点标签颜色',
            'subtitle'=>'站点标签颜色'
        ),
        array(
            'id' => 'site-background-bg',
            'type' => 'color',
            'default' => '#ff669957',
            'title' => '网站背景颜色',
            'subtitle'=>'网站背景颜色'
        ),
        array(
            'id' => 'site-background-hover',
            'type' => 'color',
            'default' => '#ff669957',
            'title' => '网站悬停颜色',
            'subtitle'=>'网站悬停颜色'
        ),
        array(
            'id' => 'box-shadow',
            'type' => 'text',
            'default' => 'rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.2) 0px 3px 1px -2px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px',
            'title' => '网站盒子阴影',
            'subtitle'=>'网站盒子阴影'
        ),
        array(
            'id' => 'box-shadow-hover',
            'type' => 'text',
            'default' => 'none',
            'title' => '网站盒子悬停阴影',
            'subtitle'=>'网站盒子悬停阴影'
        ),
)));

//redis设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('redis设置','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'redis_switch',
            'type' => 'switcher',
            'default' => '60',
					'title' => '开启redis',
            'subtitle'=>'开启redis'
        ),
        array(
            'id' => 'redis_past_time',
            'type' => 'spinner',
            'default' => '60',
					'title' => 'redis过期时间',
					'dependency' => array('redis_switch','==','true') ,
            'subtitle'=>'redis过期时间'
        ),
        array(
            'id' => 'redis_port',
            'type' => 'spinner',
            'default' => '6379',
					'title' => 'redis端口',
					'dependency' => array('redis_switch','==','true') ,
            'subtitle'=>'请勿随便修改，小心网站无法访问'
        ),
        array(
            'id' => 'redis_localhost',
            'type' => 'text',
            'default' => '127.0.0.1',
					'title' => 'redis地址',
					'dependency' => array('redis_switch','==','true') ,
            'subtitle'=>'请勿随便修改，小心网站无法访问'
        ),
			array(
			'id' => 'clear_redis',
			'type' => 'content',
			'content' => '<a target="_blank" href="'.get_template_directory_uri().'/action/clear_redis.php" style=" text-align: center; color: red; font-size: 16px; ">清除redis缓存</a>',
			),
)));

//商城设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('商城设置','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
	array(
	'id' => 'ghost_shop_guajian_month_credit',
	'type' => 'spinner',
		'title' => __('每月所需积分','ghost'),
		'subtitle'=>__('开通积分挂件每月所需积分','ghost'),
	),
    array(
        'id' => 'ghost_shop_guajian_credit',
        'type' => 'group',
		'title' => __('积分挂件','ghost'),
		   'subtitle' => __('积分挂件','ghost'),
        'button_title' => __('添加积分挂件','ghost'),
        'fields' => array(
        
        array(
        'id' => 'ghost_shop_guajian_name',
        'type' => 'text',
			'title' => __('名称','ghost'),
        'subtitle'=>__('名称','ghost'),
        ),
        array(
        'id' => 'ghost_shop_guajian_img',
        'type' => 'upload',
			'title' => __('图片','ghost'),
        'subtitle'=>__('图片','ghost'),
        ),
        ),
        
    ),
    array(
        'id' => 'ghost_shop_guajian_vip',
        'type' => 'group',
		'title' => __('正式会员挂件','ghost'),
		   'subtitle' => __('正式会员挂件','ghost'),
        'button_title' => __('添加正式会员挂件','ghost'),
        'fields' => array(
        
        array(
        'id' => 'ghost_shop_guajian_name',
        'type' => 'text',
			'title' => __('名称','ghost'),
        'subtitle'=>__('名称','ghost'),
        ),
        array(
        'id' => 'ghost_shop_guajian_img',
        'type' => 'upload',
			'title' => __('图片','ghost'),
        'subtitle'=>__('图片','ghost'),
        ),
        ),
        
    ),
    array(
        'id' => 'ghost_shop_guajian_svip',
        'type' => 'group',
		'title' => __('大会员挂件','ghost'),
		   'subtitle' => __('大会员挂件','ghost'),
        'button_title' => __('添加大会员挂件','ghost'),
        'fields' => array(
        
        array(
        'id' => 'ghost_shop_guajian_name',
        'type' => 'text',
			'title' => __('名称','ghost'),
        'subtitle'=>__('名称','ghost'),
        ),
        array(
        'id' => 'ghost_shop_guajian_img',
        'type' => 'upload',
			'title' => __('图片','ghost'),
        'subtitle'=>__('图片','ghost'),
        ),
        ),
        
    ),
)));

//网站信息
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('网站信息','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    

    array(
        'id' => 'ghost_head_menu',
        'type' => 'group',
		   'title' => __('网站头部菜单','ghost'),
        'subtitle' => __('网站头部菜单','ghost'),
        'button_title' => __('添加头部菜单','ghost'),
        'fields' => array(
        
        array(
        'id' => 'ghost_head_menu_name',
        'type' => 'text',
			'title' => __('名称','ghost'),
        'subtitle'=>__('名称','ghost'),
        ),
        array(
        'id' => 'ghost_head_menu_fa',
        'type' => 'text',
			'title' => __('图标','ghost'),
        'subtitle'=>__('图标','ghost'),
        ),
        array(
        'id' => 'ghost_head_menu_link',
        'type' => 'text',
			'title' => __('链接','ghost'),
        'subtitle'=>__('链接','ghost'),
        ),
        ),
        
    ),
    array(
        'id' => 'ghost_site_name',
        'type' => 'text',
        'title' => __('网站名称','ghost'),
        'subtitle' => __('网站名称','ghost'),
    ),
    array(
        'id' => 'ghost_site_logo',
        'type' => 'upload',
        'title' => __('网站logo','ghost'),
        'subtitle' => __('网站logo','ghost'),
    ),

    array(
        'id' => 'ghost_site_head_pic',
        'type' => 'upload',
        'title' => __('网站头部图片','ghost'),
        'subtitle' => __('网站头部图片','ghost'),
    ),

    array(
        'id' => 'header_site_icon',
        'type' => 'upload',
        'title' => __('网站头部icon','ghost'),
        'subtitle' => __('网站头部icon','ghost'),
    ),

    array(
        'id' => 'ghost_site_dec',
        'type' => 'text',
        'title' => __('网站描述','ghost'),
        'subtitle'=>__('网站描述','ghost'),
    ),
    
    
    array(
        'id'      => 'ghost_site_word',
        'type'    => 'text',
        'title'   => __('网站关键词','ghost'),
        'subtitle'=>__('网站关键词','ghost'),
    ),

    array(
        'id' => 'ghost_pc_search',
        'type' => 'group',
        'title' => __('网站搜索词','ghost'),
        'subtitle' => __('网站搜索词预设','ghost'),
        'button_title' => __('添加搜索词','ghost'),
        'fields' => array(
        
        array(
        'id' => 'ghost_pc_search_word',
        'type' => 'text',
        'title' => __('搜索词','ghost'),
        'subtitle'=>__('纯文本','ghost'),
        ),
        ),
        
    ),

    array(
        'id' => 'ghost_site_me_link',
        'type' => 'text',
        'title' => __('个人中心固定链接','ghost'),
        'subtitle' => __('自定义用户页链接,默认me,更改后需要在固定连接处保存设置','ghost'),
    ),

    array(
        'id' => 'ghost_site_author_link',
        'type' => 'text',
        'title' => __('用户页链接','ghost'),
        'subtitle' => __('自定义用户页链接,默认author,更改后需要在固定连接处保存设置','ghost'),
    ),

    array(
        'id' => 'ghost_site_footer',
        'type' => 'textarea',
        'title' => __('网站底部','ghost'),
        'subtitle' => __('网站底部','ghost'),
    ),

    array(
        'id' => 'login_news',
        'type' => 'textarea',
        'title' => __('网站登录弹窗公告','ghost'),
        'subtitle' => __('网站登录弹窗公告','ghost'),
    ),

    array(
        'id' => 'user_avatar',
        'type' => 'upload',
        'title' => __('用户默认头像','ghost'),
        'subtitle' => __('用户默认头像','ghost'),
    ),

    array(
        'id' => 'post_lazy_img',
        'type' => 'upload',
        'title' => __('懒加载图片','ghost'),
        'subtitle' => __('文章默认懒加载图片','ghost'),
    ),
    array(
        'id' => 'ghost_site_notice',
        'type' => 'textarea',
        'title' => __('网站公告','ghost'),
        'subtitle' => __('网站公告','ghost'),
    ),

    array(
        'id' => 'post_link_max_credit',
        'type' => 'spinner',
			'default' => 20,
        'title' => __('文章投稿最大积分数量','ghost'),
        'subtitle' => __('文章投稿最大积分数量','ghost'),
    ),

)));

//网站seo
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('网站seo','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    

    array(
        'id' => 'switch_category',
        'type' => 'switcher',
        'title' => __('去除category','ghost'),
        'subtitle' => __('去除category','ghost'),
    ),

    array(
    'id'      => 'baidu_site',
    'type'    => 'text',
    'title'   => __('百度站点地址','ghost'),
    'subtitle'=>__('百度站点地址','ghost'),
    'placeholder' => ''
    ),


    array(
    'id'      => 'baidu_site_token',
    'type'    => 'text',
    'title'   => __('百度网站token','ghost'),
    'subtitle'=>__('百度网站token','ghost'),
    'placeholder' => ''
    ),
        
    array(
    'id'      => 'baidu_auto_submit',
    'type'    => 'switcher',
    'title'   => __('百度自动提交','ghost'),
    'subtitle'=>__('百度自动提交','ghost'),
    'placeholder' => ''
    ),

    array(
    'id'      => '360_auto_submit',
    'type'    => 'switcher',
    'title'   => __('360自动提交','ghost'),
    'subtitle'=>__('360自动提交','ghost'),
    'placeholder' => ''
    ),
    
)));

//邮箱功能
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('邮箱功能','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    

    array(
        'id' => 'email_switch',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启邮箱',
        'subtitle'=>'开启之后，您可以使用邮箱功能'
    ),
    array(
        'id' => 'SMTPAuth',
        'type' => 'switcher',
        'title' => 'SMTP认证',
        'desc' => 'SMTP认证',
        'dependency' => array('email_switch','==','true') ,
        'default' => true,
        ),
    array(
        'id' => 'FromName',
        'type' => 'text',
        'title' => '发信人昵称',
        'desc' => '发信人昵称',
        'dependency' => array('email_switch','==','true') ,
        'default' => 'ghost',
        ),
    array(
        'id' => 'From',
        'type' => 'text',
        'title' => '显示的发信邮箱',
        'desc' => '显示的发信邮箱',
        'dependency' => array('email_switch','==','true') ,
        'default' => 'admin@xxx.com',
        ),
    array(
        'id' => 'Host',
        'type' => 'text',
        'title' => '邮箱的SMTP服务器地址',
        'desc' => '邮箱的SMTP服务器地址',
        'dependency' => array('email_switch','==','true') ,
        'default' => 'smtpdm.aliyun.com',
        ),
    array(
        'id' => 'Port',
        'type' => 'text',
        'title' => 'SMTP服务器端口',
        'desc' => 'SMTP服务器端口',
        'dependency' => array('email_switch','==','true') ,
        'default' => 465,
        ),
    array(
        'id' => 'SMTPSecure',
        'type' => 'switcher',
        'title' => '开启ssl',
        'desc' => '开启ssl',
        'dependency' => array('email_switch','==','true') ,
        'default' => true,
        ),
    array(
        'id' => 'Username',
        'type' => 'text',
        'title' => '邮箱地址',
        'desc' => '邮箱地址',
        'dependency' => array('email_switch','==','true') ,
        'default' => 'admin@xxx.com',
        ),
    array(
        'id' => 'Password',
        'type' => 'text',
        'title' => '邮件授权码',
        'desc' => '邮件授权码',
        'dependency' => array('email_switch','==','true') ,
        'default' => '123456',
        ),

)));

//提醒显示
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('提醒显示','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
    array(
        'id' => 'login_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启登录提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到登录邮件通知'
    ),
    array(
        'id' => 'reg_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启注册提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到注册邮件通知'
    ),
    array(
        'id' => 'forget_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启忘记密码提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到忘记密码邮件通知'
    ),
    array(
        'id' => 'post_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启发布文章提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到发布文章邮件通知'
    ),
    array(
        'id' => 'comment_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启发布评论提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到发布评论邮件通知'
    ),
    array(
        'id' => 'avatar_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启修改头像提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到修改头像邮件通知'
    ),
    array(
        'id' => 'myemail_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启修改邮箱提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到修改邮箱邮件通知'
    ),
    array(
        'id' => 'pwd_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启修改密码提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到修改密码邮件通知'
    ),
    array(
        'id' => 'buy_download_link',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启积分购买链接提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到发布评论邮件通知'
    ),
    array(
        'id' => 'message_email_msg',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启私信提醒',
        'subtitle'=>'用户没有自定义开启情况下的默认选项，开启之后，您将收到发布评论邮件通知'
    ),

)));

//积分设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('积分策略','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'ghost_user_gem',
            'type' => 'text',
            'default' => 'fa-gem',
            'title' => '积分图标',
            'subtitle'=>'积分图标，如fa-gem'
        ),
        array(
            'id' => 'ghost_sign_daily',
            'type' => 'spinner',
            'default' => 10,
            'title' => '每日签到',
            'subtitle'=>'每日签到奖励积分'
        ),
        array(
            'id' => 'del_flowers',
            'type' => 'spinner',
            'default' => -10,
            'title' => '取消关注扣除积分',
            'subtitle'=>'取消关注扣除积分'
        ),
        array(
            'id' => 'flowers',
            'type' => 'spinner',
            'default' => 10,
            'title' => '关注奖励积分',
            'subtitle'=>'关注奖励积分'
        ),
        array(
            'id' => 'user_reg_credit',
            'type' => 'spinner',
            'default' => 100,
            'title' => '用户注册积分',
            'subtitle'=>'用户注册积分奖励'
        ),
        array(
            'id' => 'avatar_credit_msg',
            'type' => 'spinner',
            'default' => -10,
            'title' => '修改头像积分',
            'subtitle'=>'修改头像积分，如-10为扣除10积分'
        ),
        array(
            'id' => 'myemail_credit_msg',
            'type' => 'spinner',
            'default' => -10,
            'title' => '修改邮箱',
            'subtitle'=>'修改邮箱扣除积分'
        ),
        array(
            'id' => 'pwd_credit_msg',
            'type' => 'spinner',
            'default' => -10,
            'title' => '修改密码',
            'subtitle'=>'修改密码扣除积分'
        ),
        array(
            'id' => 'user_forget_credit',
            'type' => 'spinner',
            'default' => -10,
					'title' => '忘记密码',
            'subtitle'=>'忘记密码扣除积分'
        ),
        array(
            'id' => 'comment_credit_msg',
            'type' => 'spinner',
            'default' => 10,
            'title' => '评论奖励',
            'subtitle'=>'用户评论积分奖励'
        ),
        array(
            'id' => 'post_credit_msg',
            'type' => 'spinner',
            'default' => 10,
            'title' => '发表文章',
            'subtitle'=>'用户发表文章积分奖励'
        ),
)));

//发送限制
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('发送限制','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'daily_msg_num',
            'type' => 'spinner',
            'default' => 30,
            'title' => '日发送消息限制',
            'subtitle'=>'日发送消息限制'
        ),
)));

//oss存储设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('oss存储','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
    
        array(
            'id' => 'pic_size',
            'type' => 'spinner',
            'default' => 2,
            'title' => '上传文章图片大小',
            'subtitle'=>'多少m，如2m'
        ),
        array(
            'id' => 'pic_avatar_size',
            'type' => 'spinner',
            'default' => 2,
            'title' => '上传头像图片大小',
            'subtitle'=>'多少m，如2m'
        ),
        array(
            'id' => 'open_cdn_url',
            'type' => 'switcher',
            'default' => true,
            'title' => '开启cdn',
            'subtitle'=>'开启cdn'
        ),
        array(
            'id' => 'my_cdn_url',
            'type' => 'text',
            'default' => 'https://img.catacg.cn/',
            'dependency' => array('open_cdn_url','==','true') ,
            'title' => '静态cdn地址',
            'subtitle'=>'静态cdn地址'
        ),
        array(
            'id' => 'ghost_oss',
            'type' => 'switcher',
            'default' => 10,
            'title' => '开启阿里云oss',
            'subtitle'=>'是否开启阿里云oss'
        ),
        array(
            'id' => 'ghost_oss_accessKeyId',
            'type' => 'text',
            'default' => false,
            'title' => 'accessKeyId',
            'dependency' => array('ghost_oss','==','true') ,
            'subtitle'=>'阿里云accessKeyId'
        ),
        array(
            'id' => 'ghost_oss_accessKeySecret',
            'type' => 'text',
            'default' => false,
            'title' => 'accessKeySecret',
            'dependency' => array('ghost_oss','==','true') ,
            'subtitle'=>'阿里云accessKeySecret'
        ),
        array(
            'id' => 'ghost_oss_endpoint',
            'type' => 'text',
            'default' => false,
            'title' => 'endpoint',
            'dependency' => array('ghost_oss','==','true') ,
            'subtitle'=>'Endpoint以杭州为例，其它Region请按实际情况填写。 $endpoint="http://oss-cn-hangzhou.aliyuncs.com"'
        ),
        array(
            'id' => 'ghost_oss_bucket',
            'type' => 'text',
            'default' => false,
            'title' => '存储空间名称',
            'dependency' => array('ghost_oss','==','true') ,
            'subtitle'=>'存储空间名称'
        ),
        array(
            'id' => 'ghost_thumbnail',
            'type' => 'text',
            'default' => '?x-oss-process=style/style-pinkacg',
            'title' => 'oss缩略图',
            'dependency' => array('ghost_oss','==','true') ,
            'subtitle'=>'缩略图格式:?x-oss-process=style/规则名称'
        ),
)));

//答题设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('答题功能','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(
        array(
        'id' => 'dati_switch',
        'type' => 'switcher',
        'default' => false,
        'title' => '开启答题',
        'subtitle'=>'开启之后，您可以使用答题注册功能'
        ),
        
        array(
        'id' => 'dati_name',
        'type' => 'text',
        'title' => '答题页面名称',
        'desc' => '留空则显示“答题加入我们”',
        'dependency' => array('dati_switch','==','true') ,
        'default' => '答题加入我们',
        ),
        array(
        'id' => 'dati_switcher',
        'type' => 'switcher',
        'default' => false,
        'title' => '答题加入会员',
        'desc' => '开启则答题加入本站会员，不开启则答题加入本站',
        'dependency' => array('dati_switch','==','true') ,
        ),
        array(
        'id' => 'dati_month',
        'type' => 'spinner',
        'title' => __('开通会员时长','ghost'),
        'subtitle'=>__('开通几个月会员','ghost'),
        'dependency' => array('dati_switcher','==','true') ,
        'default' => 12,
        ),
        array(
        'id' => 'ti_jige',
        'type' => 'spinner',
        'title' => __('答题及格分','ghost'),
        'subtitle'=>__('达到此分数即可加入','ghost'),
        'dependency' => array('dati_switch','==','true') ,
        'default' => 60,
        ),
        array(
        'id' => 'dati_add',
        'type' => 'group',
        'title' => __('添加题目','ghost'),
        'subtitle' => __('添加题目','ghost'),
        'button_title' => __('添加','ghost'),
        'dependency' => array('dati_switch','==','true') ,
        'fields' => array(
            
            array(
            'id'      => 'ti_content',
            'type'    => 'textarea',
            'title' => __('题目内容','ghost'),
            'subtitle'=>__('题目内容','ghost'),
            'placeholder' => '题目内容'
            ),
            array(
            'id' => 'ti_select_daan',
            'type' => 'text',
            'title' => __('题目答案','ghost'),
            'subtitle'=>__('题目答案','ghost'),
            ),
            array(
            'id' => 'ti_select_a',
            'type' => 'text',
            'title' => __('选项A','ghost'),
            'subtitle'=>__('选项A','ghost'),
            ),
            array(
            'id' => 'ti_select_b',
            'type' => 'text',
            'title' => __('选项B','ghost'),
            'subtitle'=>__('选项B','ghost'),
            ),
            array(
            'id' => 'ti_select_c',
            'type' => 'text',
            'title' => __('选项C','ghost'),
            'subtitle'=>__('选项C','ghost'),
            ),
            array(
            'id' => 'ti_select_d',
            'type' => 'text',
            'title' => __('选项D','ghost'),
            'subtitle'=>__('选项D','ghost'),
            ),
        )
    ),
)));

//底部设置
GHOST::createSection( $prefix, array(
    'parent'      => 'ghost_site',
    'title'       => '<span>'.__('底部设置','ghost').'</span>',
    'icon'        => 'fa fa-vcard-o',
    'fields'      => array(

    array(
        'id' => 'ghost_footer_links',
        'type' => 'group',
        'title' => __('底部链接','ghost'),
        'subtitle' => __('底部链接','ghost'),
        'button_title' => __('添加底部链接','ghost'),
        'fields' => array(
        
            array(
                'id' => 'ghost_footer_text',
                'type' => 'text',
                'title' => __('链接名称','ghost'),
                'subtitle'=>__('链接名称','ghost'),
            ),
            array(
                'id' => 'ghost_footer_link',
                'type' => 'text',
                'title' => __('链接地址','ghost'),
                'subtitle'=>__('链接地址','ghost'),
            ),
    ),
        
    ),

    array(
        'id' => 'ghost_site_footer_shenming',
        'type' => 'textarea',
        'title' => __('申明','ghost'),
        'subtitle' => __('申明','ghost'),
    ),

    array(
        'id' => 'ghost_site_footer_about',
        'type' => 'textarea',
        'title' => __('关于我们','ghost'),
        'subtitle' => __('关于我们','ghost'),
    ),

    array(
        'id' => 'ghost_site_footer_contact',
        'type' => 'textarea',
        'title' => __('联系我们','ghost'),
        'subtitle' => __('联系我们','ghost'),
    ),

    )));

//面板设置
GHOST::createSection( $prefix, array(
    'title'       => '<span>面板设置</span>',
    'icon'        => 'fa fa-star',
    'fields'      => array(
    
    array(
    'id'                 => 'ghost_panel_skin',
    'type'               => 'radio',
    'title'              => '面板风格',
    'options'            => array(
    'dark'              => '深色',
    'light'           => '浅色',
    ),
    'default'       =>'dark',
    ),
    
    
    array(
    'id'         => 'ghost_panel_name',
    'type'       => 'text',
    'title'      => '面板logo名称',
    'desc'      => '如果是中文，建议五个字内',
    'default' => 'GHOST'
    ),
    
    
    array(
    'id' => 'ghost_panel_menu_add',
    'type' => 'group',
    'title' => '面板头部菜单',
    'subtitle'      => '可以添加一些常用的网站链接在顶部方便日常使用',
    'button_title' => '添加',
    'fields' => array(
    
    array(
    'id' => 'title',
    'type' => 'text',
    'title' => '菜单名称',
    ),
    
    array(
    'id' => 'link',
    'type' => 'text',
    'title' => '菜单链接',
    'placeholder' => 'http://',
    ),
    
    
    ),
    'default' => array(
    array(
    'title' => '网站首页',
    'link' => '/',
    ),
    array(
    'title' => 'GHOST官网',
    'link' => 'https://q.ghost.cn/',
    ),
    )
    ) ,
    
    
    )
    ));
    
    
    
    
GHOST::createSection( $prefix, array(
'title'       => '<span>设置备份<k>重要</k></span>',
'icon'        => 'fa fa-cloud',
'fields'      => array(

array(
'type' => 'backup',
),

)
));

GHOST::createSection( $prefix, array(
'title'       => '<span>更新授权</span>',
'icon'        => 'fa fa-key',
'fields'      => array(

array(
'type'    => 'verify',
),


)
));


}else{
$prefix = 'ghost_options';
GHOST::createOptions($prefix);
GHOST::createSection($prefix,array());
}