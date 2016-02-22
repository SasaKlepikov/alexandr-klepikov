<?php
/**
 * The template for displaying the search form
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>">
	<div class="row collapse">
		<label class="screen-reader-text" for="s"><?php _e('Search for:', 'crum'); ?></label>
		<div class="<?php reactor_columns( 12 ) ?>">
			<input type="text" value="<?php get_search_query(); ?>" name="s" id="s" placeholder="<?php echo esc_attr__('Enter search request', 'crum'); ?>" />
			<i class="crumicon-search"></i>
            <input class="search-submit" type="submit" id="searchsubmit" value="<?php echo esc_attr__('Search', 'crum'); ?>" />
		</div>

    </div>
</form>
