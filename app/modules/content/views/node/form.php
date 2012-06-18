

<?php echo Form::open(array('enctype'=>"multipart/form-data",'class'=>"well"));?>
<?php 


foreach($form as $vo){
	$t = false;
	unset($type,$values,$value,$exists,$name,$plug);
	$name = $vo['name'];
	$type = $vo['form'];
	$value = $vo['value'];
	$values = $vo['values']; 
	
	switch($type){
		case 'file':
			$type = 'input';
			$values = array('type'=>'file');
			if($value){
				$file = \DB::select('*')->from('files')->where('id',$value)->execute()->current();
				//ÏÔÊ¾Í¼Æ¬
				if(in_array($file['ext'],array('jpg','png','gif','jpeg'))){
					$t = true;
					$exists = Html::img(\Uri::base(false).$file['path'],array('width'=>100,'height'=>80));
				}
			 
			}
			break;
	}	
 	//¼ÓÔØ²å¼þ
	if($plugins[$name]){
		if($plugins[$name]['code']){
			$plug = $plugins[$name]['code'];
			$plug = html_entity_decode($plug);
			$plug = str_replace('###',$name,$plug);
		 	
		}
	}
	//	
 	
?>
	<div class='row'>
		<label><?php echo $vo['label'];?></label> 
		<?php if(!$plug) {?>
				<?php echo \Form::$type($name,$value,$values);?>
				<?php if(true === $t){?>
					</div><div class='row'>
						<?php 
							echo "<p><span class='btn btn-warning'>".__('comm.exists file and if upload will remove this one').'</span></p>'.$exists;
						?>
				<?php }?>
		<?php }else{?>
				<?php echo $plug;?>
		<?php }?>
	</div>
<?php }?>		 

<div class="form-actions">
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
	
<?php echo Form::close(); ?>
	
	