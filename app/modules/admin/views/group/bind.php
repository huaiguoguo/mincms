<?php echo Form::open();?>
	<table class="table table-striped table-bordered table-condensed">
	  <tr>	
		<td> 
		<?php if($user){?>
		<button class="btn "  >
	 		<?php echo __('comm.current user').': '. $user->username;?>
		</button>
		<?php }?>
		<button class="btn btn-success"  ><?php echo $post->name; ?></button>
		</td>  
	  </tr>
	 <?php foreach($role as $v){?>
	  <tr>	
		<td class='first hand'>
		  <span><?php echo Form::checkbox('roles[]',$v->id ,array('class'=>'roles')).' '.$v->val; ?> </span>
		</td>  
	  </tr>
	  <tr>
	 	 <td class='next hand'>
		  <?php foreach($v->actions as $ac){
		  unset($cls);
		  $check = in_array($ac->id,$actions)?true:false;
		  if($check==true) $cls = 'label label-info';
		  ?>
		  <span class="left_20 <?php echo $cls;?>">
		  	  <?php echo Form::checkbox('role[]',
			  			$ac->id,
			  			$check,
			  			array('class'=>"roles_".$v->id) ).' '.$ac->val; ?>
		  </span>&nbsp;
		  <?php }?>
		  
	  	</td>
	  </tr>
	  <?php }?>
	</table>
	<div class="form-actions">
	    <button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	    <button class="btn" type="reset" ><?php echo __('comm.reset');?></button>
	 </div>
<?php echo Form::close();?>
 