<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images">

	<?php

    $attachment_ids = $product->get_gallery_attachment_ids();

    if ( has_post_thumbnail() ) {
        $thumb_id = get_post_thumbnail_id();
        $attachment_ids = array_merge(array('key0' => $thumb_id), $attachment_ids);
    }

	$image_size = get_option( 'shop_single_image_size' ) ? get_option( 'shop_single_image_size' ) : false;

	if($image_size){
		$img_width = $image_size['width'];
		$img_height = $image_size['height'];
		$img_crop = $image_size['crop'] ? true : false;

	} else {
		$img_width = '405';
		$img_height = '510';
		$img_crop = true;
	}

    if ( $attachment_ids ) {
        ?>
        <div class="master-slider ms-skin-default" id="masterslider"><?php

            foreach ($attachment_ids as $attachment_key => $attachment_id) {
                $image_src = wp_get_attachment_image_src($attachment_id, 'full'); // returns an array

                $main_image = theme_thumb($image_src[0],$img_width , $img_height, $img_crop);
                $thumb_image = theme_thumb($image_src[0], 80, 80, true);

                echo '<div class="ms-slide">';
                echo '<img src="' . $main_image . '" alt="" />';
                echo '<img class="ms-thumb" src="' . $thumb_image . '" alt="" />';
                echo '<a href="' . $image_src[0] . '" class="ms-lightbox magnific-gallery"><i class="embrace-zoom_in2"></i></a>';
                echo '</div>';
            }

            wp_enqueue_script('masterslider');
            ?>
            <script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        var slider = new MasterSlider();

                        slider.control('arrows');
                        slider.control('lightbox');
                        slider.control('thumblist', {
                            autohide: false,
                            dir: 'h',
                            align: 'bottom',
                            width: 80,
                            height: 80,
                            margin: 2,
                            space: 10,
                            hideUnder: 400
                        });

                        slider.setup('masterslider', {
                            width: <?php echo $img_width;?>,
                            height: <?php echo $img_height;?>,
                            space: 5,
                            loop: true,
                            view: 'fade'
                        });
                    });
                })(jQuery);
            </script>
        </div>
    <?php
    }
    ?>

</div>
