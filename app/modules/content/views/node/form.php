<?php echo Form::open(array('enctype'=>"multipart/form-data",'class'=>"well"));?>
<?php 
	//if just file not images
	foreach($form as $vo){ 
		 $k = $vo['name']; 
		 if(!$k) continue; 
		 $value = $vo['value'];
		 $key_values[$k] = $value;
		 $key[] = $k;
		 
	}
	//if file check column for display 
	if(in_array('title',$key))
 		$new_file_name = $key_values['title'];
 	else if(in_array('name',$key))
 		$new_file_name = $key_values['name'];
	else
		$new_file_name = $key_values[$key[1]];
	//end file 
 
foreach($form as $vo){
	$t = false;
	unset($type,$values,$value,$exists,$name,$plugin);
	$name = $vo['name'];
	$type = $vo['form'];
	$value = $vo['value'];
	$values = $vo['values']; 
	$muit = $vo['muit']; 
	$label_tip = $vo['label_tip'];
 	$default_value = $vo['default_value'];
 	if(!$value)
 		$value = $default_value;
	switch($type){
		case 'file':
			$type = 'input';
			$values = array('type'=>'file');
			if($value){ 
				$json =  \Format::forge($value, 'json')->to_array() ;
				if(is_array($json)){
					$value = $json;
				}
			 	else
			 		$value[] = $value;
			 	if(count($value)<1) goto A;
				$files = \DB::select('*')->from('files')->where('id','in',$value)->execute();
				foreach($files as $file){ 
					$t = true;
					$aj = \Uri::create('content/node/remove_file');
					$im = \Uri::base(false).$file['path'];
					//show images
					if(in_array(trim($file['ext']),array('jpg','png','gif','jpeg'))){ 
						$exists .= "<span><a href='".$im."' rel='facybox'>".Html::img($im,array('width'=>100,'height'=>80))."</a>"; 
						
					}else{ 
						$exists .= "<span><a href='".\Uri::create('content/node/down/'.$file['id'].'/'.$new_file_name)."' >".\Vendor\Content::icon($file['ext'],$ps)."</a>";
					}
					$exists .= "<input type='hidden' value=".$file['id']." name=".$name."[]>";
					$exists .= "<a class=\"btn btn-danger file_remove\" href=".$aj."  id='".$id."' fid='".$fid."' file_id='".$file['id']."'  field='".$name."'
		 \">
		<i class=\"icon-trash icon-white\"></i> 
		<?php echo __('comm.delete');?>
	</a></span>";
				}
			 
			}
			$values = array_merge($values,array('class'=>'file')); 
		  
			$ru = $vo['rules'];
		 
		 	$params['limit'] = $muit;
		 	$params['size'] = $ru['max_size']; 
		 	$params['type'] = $ru['ext_whitelist'];
		  
			//load cck plugin
			$plugin = \Vendor\Plugin::load_cck($cck_type,$name,'swfupload',$params);
			
		 	
			break;
			A:
	}	
   
 	
?>
	<div class='row'>
		<label><?php echo $vo['label'];?></label> 
		<?php if(!$plugin) {?>
				<?php echo \Form::$type($name,$value,$values);?>
				<?php if(true === $t){?>
					</div><div class='row'>
						<?php 
							echo "<p><span class='btn btn-warning'>".__('comm.exists file and if upload will remove this one').'</span></p>'.$exists;
						?>
				<?php }?>
		<?php }else{?>
				<?php echo $plugin['view'];?>
		<?php }?>
		<?php 
			//显示已存在的图片
			if($exists)
				echo "<div class='abs'>".$exists.'</div>';
		?>
		<?php if($label_tip){?>
				<span class='label label-info'><?php echo $label_tip;?></span>
		<?php }?>
		<div style='clear:both;'></div>
	</div>
		<?php echo $plugin['run'];?>
<?php }?>		 

<div class="form-actions">
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
	
<?php echo Form::close(); ?>
	
<script>
	$(function(){
		var s;
		$('.abs .file_remove').hide(); 
		$('.abs a img').mouseover(function(){
		 	s = $(this).parent().next().next('.file_remove');
		 	s.show();
		}).mouseout(function(){
			$(s).mouseover(function(){
	 	 		$(s).show();
	 	 	}).mouseout(function(){
	 	 		$(s).hide();
	 	 	});
		 
			$(s).hide(); 
			 
			
		});
		$('.abs .file_remove').click(function(){
			if(confirm("<?php echo __('comm.could you want to remove this content type');?>")){
				var obj = this; 
				$.post($(this).attr('href'), { id: $(this).attr('id') , fid: $(this).attr('fid'), file_id: $(this).attr('file_id'),type:'files', field: $(this).attr('field')},
				 function(data){ 
				    $(obj).parent('span').remove();
				 });
			}
			 return false;
		}); 
	});
	
</script>

	
	