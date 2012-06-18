<p>
 	<button type="button" class="btn click btn-success" rel="set_field" ><?php echo __('comm.set colums for lists');?></button>
</p>
<div id='set_field' style='display:none;'>
<?php echo Form::open();?>
<table class="table table-striped table-bordered table-condensed">
  <tr>
	<td><?php echo __('comm.name'); ?></td>
	<td><?php echo __('comm.val'); ?></td>  
	<!--<td><?php echo __('comm.sort'); ?></td>  -->
	<td><?php echo __('comm.action'); ?></td> 
  </tr>
  <?php foreach($rows as $row){?>
  <tr>
    <td><?php echo $row->label; ?></td>
	<td><?php echo $row->name; ?></td>  
	<!--<td class='img_16'> 
		<?php if($row->view->sort != $min){?>
			<?php echo Html::anchor(\Uri::create('views/home/sort/'.$row->view->id.'/up'), Asset::img('up.png')); ?> &nbsp;
		<?php }?>
		<?php if($row->view->sort != $max){?>
			<?php echo Html::anchor(\Uri::create('views/home/sort/'.$row->view->id.'/down'), Asset::img('down.png')); ?>
		<?php }?>
	</td>  -->
	<td>	<a href="#" class='ajax' id="<?php echo $row->id;?>"  rel="<?php echo $id;?>">
				<?php echo in_array($row->id,$ids)?Asset::img('right.png'):Asset::img('error.png'); ?>
			</a>
	  </td> 
  </tr>
  <?php }?>
</table> 


<?php echo Form::close();?>
</div>
<script>
$(function(){
	var a = "<?php echo Uri::base(false).'assets/img/right.png';?>";
	var b = "<?php echo Uri::base(false).'assets/img/error.png';?>";
	$('a.ajax').click(function(){
		var obj = this;
		$.post("<?php echo \Uri::create('views/home/ajax');?>", { fid: $(this).attr('id') ,id:$(this).attr('rel')},
		function(data) { 
		     if(data==1){ 
		     	$(obj).find('img').attr('src',a);
		     }else if(data==2){ 
		     	$(obj).find('img').attr('src',b);
		     }
		      
			$.get("<?php echo $url;?>", 
			function(data) { 
			     $('.ajax_content').html(data);
			});
			return false;
			 
		});
		return false;
	});
	
});
</script>
