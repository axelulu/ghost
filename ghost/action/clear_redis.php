<?php 
//后台设置
require( '../../../../wp-load.php' );
if(is_super_admin()){
	//实例化redis
	$redis = new \Redis();
	//连接redis
	$redis->connect( ghost_get_option('redis_localhost') ,ghost_get_option('redis_port'));
	$redis = $redis->flushall();
	if($redis){
		echo 'ok';
	}else{
		echo 'error';
	}
}