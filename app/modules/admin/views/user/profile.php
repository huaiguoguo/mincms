<?php echo Form::open(array('enctype'=>"multipart/form-data",'class'=>"well"));?>
<div class='row'>
	<label><?php echo __('comm.my language');?></label>
	<?php echo \Form::select('language',$user->profile_fields['language'],$languages);?>
</div>	


<div class="form-actions">
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
	
<?php echo Form::close(); ?>