<?php echo Form::open();?>
<ul class="nav nav-tabs tab">
  <li><a rel="t0"><?php echo __('comm.front settings');?></a></li>
  <li><a rel="t1"><?php echo __('comm.admin settings');?></a></li>
  <li><a rel="t2"><?php echo __('comm.email settings');?></a></li>
</ul>
<table id='t0' class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.setting name'); ?></td>
	<td><?php echo __('comm.setting value'); ?></td> 
  </tr>
  
  <tr>
	<td><?php echo __('comm.enable website');?></td>
	<td>
		<?php echo Asset::img('right.png'); if($post['open'] == 1)$a = true; echo Form::radio('config[open]', 1,$a);?> <?php echo __('comm.yes');?> 
		<?php echo Asset::img('error.png'); if($post['open'] == 0)$b = true; echo Form::radio('config[open]', 0,$b);?> <?php echo __('comm.no');?> 
	</td> 
	 
  </tr>

  <tr>
	<td><?php echo __('comm.close website display');?></td>
	<td><?php echo Form::textarea('config[close_info]', $post['close_info'], array('rows' => 3, 'cols' => 20));?> </td>  
  </tr>
  
  <tr>
	<td><?php echo __('comm.website title');?></td>
	<td><?php echo Form::input('config[title]',$post['title']);?> </td>  
  </tr> 
   <tr>
	<td><?php echo __('comm.url_suffix');?></td>
	<td><?php echo Form::input('config[url_suffix]',$post['url_suffix']);?> </td>  
  </tr> 
 
  <tr>
	<td><?php echo __('comm.seo key');?></td>
	<td><?php echo Form::textarea('config[seo]', $post['seo'], array('rows' => 3, 'cols' => 20));?> </td>  
  </tr>
  <tr>
	<td><?php echo __('comm.seo author');?></td>
	<td><?php echo Form::textarea('config[seo_author]', $post['seo_author'], array('rows' => 3, 'cols' => 20));?> </td>  
  </tr>
  <tr>
	<td><?php echo __('comm.seo copyright');?></td>
	<td><?php echo Form::textarea('config[seo_copyright]', $post['seo_copyright'], array('rows' => 3, 'cols' => 20));?> </td>  
  </tr>

  <tr>
	<td><?php echo __('comm.statistics');?></td>
	<td><?php echo Form::textarea('config[stat]', $post['stat'], array('rows' => 3, 'cols' => 20));?> </td>  
  </tr>
  
  <tr>
	<td><?php echo __('comm.website footer');?></td>
	<td><?php echo Form::textarea('config[footer]',$post['footer'], array('rows' => 3, 'cols' => 20,'id'=>'footer'));?> </td>  
  </tr>
  
</table> 

<table  id='t1' class="table table-striped table-bordered table-condensed">
 <tr>
	<td><?php echo __('comm.admin title');?></td>
	<td><?php echo Form::input('config[admin_title]',$post['admin_title']);?> </td>  
  </tr> 
  <tr>
	<td><?php echo __('comm.enable cck');?></td>
	<td>
		<?php echo Asset::img('right.png'); if($post['admin_cck_enable'] == 1)$a = true; echo Form::radio('config[admin_cck_enable]', 1,$a);?> <?php echo __('comm.yes');?> 
		<?php echo Asset::img('error.png'); if($post['admin_cck_enable'] !=1)$b = true; echo Form::radio('config[admin_cck_enable]', $post['admin_cck_enable'],$b);?> <?php echo __('comm.no');?> 
	</td> 
	 
  </tr>
  <tr>
	<td><?php echo __('comm.pagination size');?></td>
	<td><?php echo Form::input('config[admin_pagination]',$post['admin_pagination']);?> </td>  
  </tr> 
</table>
<div  id='t2' >
	<table class="table table-striped table-bordered table-condensed">
	 <tr>
		<td><?php echo __('comm.email useragent');?></td>
		<td><?php echo Form::input('config[email_useragent]',$post['email_useragent']);?> </td>  
	  </tr> 
	  <tr>
		<td><?php echo __('comm.email driver');?></td>
		<td><?php echo Form::select('config[email_driver]',$post['email_driver'], array(
					    'mail' => 'mail',
					    'sendmail' => 'sendmail',
					    'smtp' => 'smtp'
					),array('class'=>'smtp'));?> 
	  </td>  
	  </tr>   
	   
	  <tr>
		<td><?php echo __('comm.email from');?></td>
		<td><?php echo Form::input('config[email_from]',$post['email_from']);?> </td>  
	  </tr>
	  <tr>
		<td><?php echo __('comm.email from name');?></td>
		<td><?php echo Form::input('config[email_from_name]',$post['email_from_name']);?> </td>  
	  </tr>
	</table>
		
	<table  id='smtp' <?php if($post['email_driver']!='smtp'){?>style='display:none;'<?php }?> class="table table-striped table-bordered table-condensed"> 
	  
	  <tr>
		<td><?php echo __('comm.smtp host');?></td>
		<td><?php echo Form::input('config[email_smtp_host]',$post['email_smtp_host']);?> </td>  
	  </tr>
	  <tr>
		<td><?php echo __('comm.smtp port');?></td>
		<td><?php echo Form::input('config[email_smtp_port]',$post['email_smtp_port']);?> </td>  
	  </tr>
	  <tr>
		<td><?php echo __('comm.smtp username');?></td>
		<td><?php echo Form::input('config[email_smtp_username]',$post['email_smtp_username']);?> </td>  
	  </tr>
	   <tr>
		<td><?php echo __('comm.smtp password');?></td>
		<td><?php echo Form::input('config[email_smtp_password]',null,array('type'=>'password'));?> </td>  
	  </tr>
	</table>
</div>
<div class="form-actions">
<button type="submit" class="btn btn-primary"><?php echo __('comm.save');?></button>
<button class="btn" type="reset"><?php echo __('comm.reset');?></button>
</div>
<?php echo Form::close();?>
<script>
$(function(){
	  $('.tab').tab();  
});		  
</script>