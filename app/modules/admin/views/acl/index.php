<p>
<a href="<?php echo \Uri::create('admin/acl/do');?>">
	<button class="btn " ><?php echo __('comm.load all controllers and actions');?></button>
</a>
</p>
<div id='acl'>
	<?php foreach($posts as $v){
		   $cls = 'label label-info';
	?>
	<table class="table left table-striped table-bordered table-condensed">
	  <tr>
	 	 <td>  
	  	  <div class="edit"><?php echo $v->val; ?> </div>
	  	 </td>
	  </tr>
		  <?php foreach($v->actions as $action){?>
		  <tr>
		 	 <td>
		  	  <span class="edit left_20 <?php echo $cls;?>">
			  	  <?php echo $action->val; ?>
			  </span> 
			</td>
		  </tr>
		  <?php }?>
	</table>
	<?php }?>
</div>
<?php echo Asset::js('jquery.masonry.min.js');?>
<script>
$(function(){
	$('#acl').masonry({ 
	    itemSelector : 'table',
	    columnWidth : 220
	});
	/*$('.edit').editable('http://www.example.com/save.php', {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'
     });*/
});
</script>

 