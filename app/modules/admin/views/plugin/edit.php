<button class="btn btn-success"><?php echo __('comm.plugin_name');?>: <?php echo $post->plugin->name;?></button>

<hr>
<p><?php echo $post->plugin->discription;?></p>
<div class='block'>
<?php echo Form::open(array('class'=>'well form-vertical'));?> 
	<div class='row'> 
	<label><?php echo __('comm.html_element');?></label>
	<?php echo Form::input('html_element',$post->html_element); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.page');?></label>
	<?php echo Form::input('page',$post->page); ?>
	</div>
	<div class='row'> 
	<label><?php echo __('comm.params');?></label>
	<?php echo Form::textarea('params',$post->params); ?>
	</div>
	<p>
	<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
	<button class="btn" type="reset" ><?php echo __('comm.reset');?></button>
 	</p>
 
<?php echo Form::close();?>
</div>