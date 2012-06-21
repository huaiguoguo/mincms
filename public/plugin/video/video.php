<?php
/*
<video  id='first_video_player'>
	  <source src="<?php echo $video_one->path;?>" type="video/mp4"> 
</video>
*/
class plugin_video{

	
	function js(){
		return array(
			'plugin/video/jwplayer.js', 
		);
	}
	
	function run($params){
	 	$id = $params['id']?:'player';
	 	$height = $params['height']?:300;
	 	$width = $params['width']?:400;
		return '<script type="text/javascript">
			$(function(){
					jwplayer("'.$id.'").setup({
					flashplayer: "'.\Uri::base(false).'plugin/video/player.swf",
					file: "'.$params['video'].'",
					image: "'.$params['img'].'",
					
					modes: [
					{ type: "html5" },
					{ 
						type: "flash",
						src: "http://player.longtailvideo.com/player5.9.swf",
						config: {skin: "http://www.longtailvideo.com/files/skins/lightrv5/5/lightrv5.zip"}
					}],
					height: '.$height.',
					width: '.$width.'	
				});
			});
			
		</script>';
	
	}
}