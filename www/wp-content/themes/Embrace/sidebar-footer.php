<?php
/**
 * The sidebar template containing the footer widget area
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php
$sidebar_count = reactor_option('footer_columns_count');

switch( $sidebar_count ) {
	case 1 : $num = 12; break;
	case 2 : $num = 6; break;
	case 3 : $num = 4; break;
	case 4 : $num = 3; break;
	case 5 : $num = 2; break;
	case 6 : $num = 2; break;
}
?>

<div class="row">
<?php if (is_active_sidebar('footer-column-1')) : ?>


        <div id="sidebar-footer" class="sidebar large-<?php echo $num;?>  small-<?php echo $num;?> columns" role="complementary">
            <?php dynamic_sidebar('footer-column-1'); ?>
        </div>
        <!-- #sidebar-footer -->


<?php endif; ?>

<?php if (is_active_sidebar('footer-column-2')) : ?>


        <div id="sidebar-footer2" class="sidebar large-<?php echo $num;?> small-<?php echo $num;?> columns" role="complementary">
            <?php dynamic_sidebar('footer-column-2'); ?>
        </div>
        <!-- #sidebar-footer -->


<?php endif; ?>

<?php if (is_active_sidebar('footer-column-3')) : ?>


		<div id="sidebar-footer3" class="sidebar large-<?php echo $num;?> small-<?php echo $num;?> columns" role="complementary">
			<?php dynamic_sidebar('footer-column-3'); ?>
		</div>
		<!-- #sidebar-footer -->


<?php endif; ?>

<?php if (is_active_sidebar('footer-column-4')) : ?>


		<div id="sidebar-footer4" class="sidebar large-<?php echo $num;?> small-<?php echo $num;?> columns" role="complementary">
			<?php dynamic_sidebar('footer-column-4'); ?>
		</div>
		<!-- #sidebar-footer -->


<?php endif; ?>

<?php if (is_active_sidebar('footer-column-5')) : ?>


		<div id="sidebar-footer5" class="sidebar large-<?php echo $num;?> small-<?php echo $num;?> columns" role="complementary">
			<?php dynamic_sidebar('footer-column-5'); ?>
		</div>
		<!-- #sidebar-footer -->


<?php endif; ?>

<?php if (is_active_sidebar('footer-column-6')) : ?>


		<div id="sidebar-footer6" class="sidebar large-<?php echo $num;?> small-<?php echo $num;?> columns" role="complementary">
			<?php dynamic_sidebar('footer-column-6'); ?>
		</div>
		<!-- #sidebar-footer -->


<?php endif; ?>
</div><!-- .row -->