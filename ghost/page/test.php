<?php 
/* Template Name: 测试 */ 
// 	for($i=0;$i<78200;$i++){
$i = 33926;
						$downloadsss = get_post($i)->post_content;
		if($downloadsss){
			$exex = explode('<!--wechatfans start-->',$downloadsss);
			$links = strip_tags($exex[1]);
			$tiquma = str_replace("[/content_hide]","",$links);
			echo $tiquma;
// 			$jieyama = explode('解压码：',$tiquma);
// 			$tiqu = $jieyama[0] ? $jieyama[0] : '';
// 			$jieya = $jieyama[1] ? $jieyama[1] : '';
// 			$link = $exex2[0] ? $exex2[0] : '';
// 			echo $link.'<br>'.$jieya.'<br>'.$tiqu.'<br>';
// 			$linksss = array();
// 			$linksss[0] = [
// 				'name' => get_the_title($i),
// 				'link' => $link,
// 				'pwd' => $tiqu,
// 				'pwd2' => $jieya,
// 				'credit' => 10,
// 			];
// 			if(!get_post_meta($i,'ghost_download',true)){
// 				update_post_meta($i,'ghost_download',$linksss);
// 			}

			}
// 		}