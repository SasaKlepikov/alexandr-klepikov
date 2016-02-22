<?php
/**
 * The main loop for displaying posts
 *
 * @package Reactor
 * @subpackage loops
 * @since 1.0.0
 */
?>

<?php // get post format and display template for that format
if ( !get_post_format() ) : get_template_part('post-formats/format', 'standard');
else : get_template_part('post-formats/format', get_post_format()); endif; ?>