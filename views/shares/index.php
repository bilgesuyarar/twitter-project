
<div>
	<?php if(isset($_SESSION['is_logged_in'])) : ?>
		<?php //require('add.php'); ?>

	<a class="btn btn-success btn-share" href="<?php echo ROOT_PATH; ?>shares/add">Share Something</a>
	<?php endif; ?>
	<?php foreach($viewmodel as $item) : ?>
		<div class="well">
			<h3><?php echo $item['share_title']; ?></h3>
			<small><?php echo $item['share_date']; ?></small>
			
			<small>posted by <?php  echo $item['username']; ?></small>
			<hr />
			<p><?php echo $item['share_content']; ?></p>
			<br />
			
		</div>
	<?php endforeach; ?>
</div>