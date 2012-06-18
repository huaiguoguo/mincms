<?php
 
	if($posts):
		foreach($posts as $post):
	?>

	<div class="post">
		<h2><?php echo $post->post_title; ?> <small><?php echo \Html::anchor('posts/edit/'.$post->id, '[Edit]');?></small></h2>
		<p><?php echo $post->post_content; ?></p>
		<p>
			<small>By <?php echo $post->author_name; ?></small><br />
			<small><?php echo $post->author_email; ?></small><br />
			<small><?php echo $post->author_website; ?></small><br />
		</p>
	</div>

	<?php
		endforeach;
	endif;
	?>
	<?php echo $pagination;?>