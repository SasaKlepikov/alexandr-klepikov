<?php
/*
 * Atlantis item template part
 *
 * Crumina team
 */
?>


<?php if ($format == 'video') {

    $post_video = get_post_meta(get_the_ID(), '_format_video_embed', true);

    if ($post_video && !empty($post_video)):

        echo '<div class="flex-video widescreen vimeo">';

        echo apply_filters('the_content', $post_video);

        echo '</div>';

    endif;

} elseif ($format == 'gallery') {
    if (!get_post_gallery()) {
        echo 'Please, insert gallery into post!';
    } else {
        $gallery = get_post_gallery(get_the_ID(), false);

        echo '<div class="gallery-slide">';

        echo '<div id="post-' . get_the_ID() . '-slider" class="gallery-post-slider cursor-move"><div class="slides-' . get_the_ID() . '">';

        /* Loop through all the image and output them one by one */
        foreach ($gallery['src'] AS $src) {

            $full_image = str_replace('-150x150', '', $src);

            if ($large_image_w && $large_image_h) {
                $thumb_width = $large_image_w;
                $thumb_height = $large_image_h;
            } else {
                $thumb_width = $small_image_w;
                $thumb_height = $small_image_h;
            }

            $thumb_crop = true;

            $post_thumbnail = theme_thumb($full_image, $thumb_width, $thumb_height, $thumb_crop);

            ?>
            <div class="slide">
                <div class="entry-thumbnail">
                    <img src="<?php echo $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>"/>

                    <div class="overlay"></div>
                    <div class="links">
                        <a href="<?php echo $post_thumbnail; ?>" class="zoom" rel="bookmark"
                           title="<?php the_title_attribute(); ?>"><i class="crumicon-resize-enlarge"></i></a>
                    </div>
                </div>
            </div>
        <?php
        }

        echo '</div></div></div>';

        ?>

        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $('.slides-<?php echo get_the_ID()?>').slick({
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 4000

                    });
                });
            })(jQuery);

        </script>

    <?php
    }
} elseif ($format == 'audio') {
    ?>

    <div class="audio-slide">

        <?php $post_audio = get_post_meta(get_the_ID(), '_format_audio_embed', true);

        echo apply_filters('the_content', $post_audio);

        ?>

        <img src="<?php if ($large) : echo $large_image;
        else: echo $small_image; endif; ?>" alt="<?php the_title(); ?>"/>

    </div>

<?php

} else {

    $tax = get_post_type();

    ?>
    <img src="<?php if ($large) : echo $large_image; else: echo $small_image; endif; ?>" alt="<?php the_title(); ?>"/>
    <span class="bg"></span>
    <span class="text-desc">

		<?php if ($show_title):  if ($large) { ?>
            <?php if ($show_link) { ?>
                <h3 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <?php }else{ ?>
                <h3 class="item-title"><?php the_title(); ?></h3>
        <?php }} else { ?>
                <?php if ($show_link) { ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><div class="icon"></div>
                    <h6 class="item-title"><?php the_title(); ?></h6></a>
                <?php }else{ ?>
                    <h6 class="item-title"><?php the_title(); ?></h6>
                <?php }} endif; ?>

        <?php if ($show_category && $large): ?>

            <span class="item-meta"><?php reactor_post_meta($args = array('show_date' => true, 'show_icons' => false, 'show_uncategorized' => true)); ?> </span>

        <?php endif; ?>

        <?php if ($show_description): ?>
            <p class="item-desc">
                <?php
                $content = get_the_content();

                if ($content == "") {
                    $content = get_the_excerpt();
                }
                if ($tax == 'portfolio') {
                    $content = get_post_meta(get_the_ID(), '_folio_description', true);
                }
                if ($large) {
                    $content = wp_trim_words($content, $decription_limit, ' ...');
                } else {
                    $content = wp_trim_words($content, ($decription_limit / 2), ' ...');
                }
                echo $content;

                ?>
            </p>
        <?php endif; ?>
        <?php if ($show_link && $large) { ?>
            <div class="read-more-button"><a class="button" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php _e('Read more &raquo;', 'crum'); ?></a>
            </div>
        <?php } else { ?>

        <?php } ?>

				</span>

<?php } ?>