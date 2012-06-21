<div class='block'>
<?php if($type=='content' || $type=='cck' ){?>
<?php echo Form::open(array('class'=>'well form-vertical'));?> 
	<div class='row'> 
	<label><?php echo __('comm.filed');?></label>
	<?php echo Form::input('html_element',$edit==true?$post->html_element:null); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.content type');?></label>
	<?php echo Form::input('page',$edit==true?$post->page:null); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.params');?></label>
	<?php echo Form::textarea('params',$edit==true?$post->params:null); ?>
	</div>
	<p>
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset" ><?php echo __('comm.reset');?></button>
 	</p>
 
<?php echo Form::close();?>
	
<?php }else{?>
	<?php echo Form::open(array('class'=>'well form-vertical'));?> 
	<div class='row'> 
	<label><?php echo __('comm.html_element');?></label>
	<?php echo Form::input('html_element',$edit==true?$post->html_element:null); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.page');?></label>
	<?php echo Form::input('page',$edit==true?$post->page:null); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.params');?></label>
	<?php echo Form::textarea('params',$edit==true?$post->params:null); ?>
	</div>
	<p>
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset" ><?php echo __('comm.reset');?></button>
 	</p>
 
<?php echo Form::close();?>
	<?php }?>
</div>