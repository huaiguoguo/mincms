<button class="btn btn-success"><?php echo __('comm.plugin_name');?>: <?php echo $post->plugin->name;?></button>

<hr>
<p><?php echo $post->plugin->discription;?></p>
<?php echo \View::forge('plugin/form',array('post'=>$post,'type'=>$post->plugin->type,'edit'=>true));?>