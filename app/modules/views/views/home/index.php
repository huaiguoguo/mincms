<div class='ajax_content'>
<?php echo $hooks;?>
<?php 
if($posts){
?>
<p>
 
</p>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <?php foreach($views as $vi){ if(!$vi->field->label) continue;?>
	<td><?php echo __('comm.'.$vi->field->label); ?></td>
 	<?php }?>
		
	<td><?php echo __('comm.active'); ?></td>  
	<td><?php echo __('comm.sort'); ?></td> 
	<td><?php echo __('comm.action'); ?></td>
	
  </tr>
  <?php  
  foreach($posts as $post){ 
  ?>
  <tr>
	<?php 
 
	foreach($views as $vi){ 
		 $k = $vi->field->name; 
		 if(!$k) continue;
		 $value = $post->$k; 
		  //put column to static
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
	foreach($views as $vi){  
		 $k = $vi->field->name; 
		 if(!$k) continue;
		 $value = $post->$k; 
		
		 //关联显示对应的字段
		 unset($options);
		 $opt = $vi->field->options;		
		 if($opt){		
			 if(is_array($opt)){ 
				 $rt = $opt['rt'];
				 $rt_column = $opt['column']; 
				 if($rt && $rt_column){
				 	$ret = 'r_'.$k;  
				 	$value = $post->$ret->$rt_column;
				 }
			 } 
		 }
		if(in_array($vi->field->form->val,array('image','file'))){
			 $json =  \Format::forge($value, 'json')->to_array() ;
			 if(is_array($json)){
				$value = $json[0];
			 }
		 	 $row = \DB::select('id','path','ext')->from('files')
		 	 	->where('id',$value)->execute()->current();
		}	
		 //显示图片
		 switch($vi->field->form->val){
		 	 
		 	case 'image':
		 		
			 	 $p = $row['path'];
			 	 if($p){
			 	 	$p = \Uri::base(false).$p;
			 	 	$value = "<a href='".$p."' rel='facybox'><img  src='".$p."' width=100 height=80/></a>";
			 	 }
		 		break;
		 	case 'file':  
		 		$ps = array('title'=>$new_file_name);
		 		$value = "<a class='img_32' href='".\Uri::create('content/node/down/'.$row['id'].'/'.$new_file_name)."'>".\Vendor\Content::icon($row['ext'],$ps)."</a>";
		 		break;
		 }
	 
		 
	 ?>
	<td><?php echo $value; ?></td>
 	<?php }?>
	 
	<td>
		<a href="<?php echo Uri::create('content/node/active/'.$id.'/'.$post->id);?>">
			<?php echo $post->active==1?Asset::img('right.png'):Asset::img('error.png'); ?>
		</a> 
	</td>  
	<td class='img_16'>
		<?php if($post->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('content/node/sort/'.$id.'/'.$post->id.'/up'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($post->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('content/node/sort/'.$id.'/'.$post->id.'/down'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  
	<td>
 	<a class="btn btn-primary" href="<?php echo \Uri::create('content/node/do/'.$id.'/'.$post->id);?> ">
	  	<i class="icon-edit icon-white"></i>
	    <?php echo __('comm.edit');?>
	</a>
		
 
 
	<a class="btn btn-danger" href="<?php echo \Uri::create('content/node/del/'.$id.'/'.$post->id);?>" 
			onclick="return confirm('<?php echo __('comm.do you confirm delete');?>');">
		<i class="icon-trash icon-white"></i> 
		<?php echo __('comm.delete');?>
	</a>
 
  </tr>
  <?php } ?>
</table> 

<?php }?>

<?php echo $pagination;?>
</div>
<?php  
	echo Asset::js(array('jquery.min.js'));
?>
<script>
$(function(){ 
 
	$('.ajax_content .ajax_page a').bind('click',function(){ 
		$.get($(this).attr('href'), 
		function(data) { 
		     $('.ajax_content').html(data);
		});
		return false;
	});
	
});
</script>	
	