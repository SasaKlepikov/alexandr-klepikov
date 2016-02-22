<?php
?>

<div class="row">

	<?php if (is_active_sidebar('side-secondary')) : ?>


		<div id="sidebar-secondary" class="sidebar" role="complementary">
			<?php dynamic_sidebar('side-secondary'); ?>
		</div>
		<!-- #sidebar-footer -->


	<?php endif; ?>

</div>