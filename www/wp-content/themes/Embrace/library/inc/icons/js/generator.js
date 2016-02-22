jQuery(document).ready(function($) {

    var icon_field;

    $(document).on('click', '.crum-icon-add', function(evt){

        icon_field = $(this).siblings('.iconname');

		var icon;

        $("#mnky-generator-wrap, #mnky-generator-overlay").show();

		jQuery(document).ready(function(){
			jQuery(".preview-icon").html("<i class=''></i>");
			jQuery("li[data-icon='']").addClass("selected");
		});
		jQuery(".icons-list li").click(function() {
			jQuery(this).attr("class","selected").siblings().removeAttr("class");
			icon = jQuery(this).attr("data-icon");
			jQuery("input[name='']").val(icon);
			jQuery(".preview-icon").html("<i class='"+icon+"'></i>");
		});


		$('#mnky-generator-insert').on('click', function(event) {
			$("#mnky-generator-wrap, #mnky-generator-overlay").hide();

			icon_field.val(icon);

			// Prevent default action
			event.preventDefault();
		});
		return false;
    });

    $("#mnky-generator-close").click(function(){
        $("#mnky-generator-wrap, #mnky-generator-overlay").hide();
        return false;
    });

/*
    $(".edit-menu-item-_crum_mega_menu_enabled").change(function(){
        if ($(this).val() == '1'){
            $(this).parent('field-_crum_mega_menu_enabled').siblings('.field-_crum_mega_menu_columns, .field-_crum_mega_menu_full, .field-_crum_mega_menu_page, .field-_crum_mega_menu_image, .field-_crum_mega_menu_color, .field-_crum_mega_menu_font_color').show();
        } else {
            $(this).parent('field-_crum_mega_menu_enabled').siblings('.field-_crum_mega_menu_columns, .field-_crum_mega_menu_full, .field-_crum_mega_menu_page, .field-_crum_mega_menu_image, .field-_crum_mega_menu_color, .field-_crum_mega_menu_font_color').hide();
        }
    });
*/

    var menu_icon = $("input.edit-menu-item-_crum_mega_menu_icon");
    if (0 == menu_icon.siblings("a").length && false == menu_icon.hasClass("iconname"))
        menu_icon.addClass("iconname").after('<a href="#" class="button crum-icon-add">Add icon</a>');

    //Add colorpicker
	if (jQuery("body").hasClass("nav-menus-php")) {
		jQuery(".edit-menu-item-_crum_mega_menu_color").wpColorPicker();
		jQuery(".edit-menu-item-_crum_mega_menu_font_color").wpColorPicker();
	}
    //Add and remove image buttons


    var menu_image = $("input.edit-menu-item-_crum_mega_menu_image");
    if (0 == menu_image.siblings("a").length) {
        menu_image.after('<a href="#" class="remove-item-image button">Remove image</a>');
        menu_image.after('<a href="#" class="add-item-image button">Add image</a>');
    }

    var tgm_media_frame;
    var image_field;

    jQuery(document.body).on("click", '.add-item-image', function (e) {
        image_field = $(this).siblings("input.edit-menu-item-_crum_mega_menu_image");
        e.preventDefault();
        if (tgm_media_frame) {
            tgm_media_frame.open();
            return false;
        }

        tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
            frame: 'select',
            multiple: false,
            library: {type: 'image'}
        });

        tgm_media_frame.on("select", function () {
            var media_attachment = tgm_media_frame.state().get('selection').first().toJSON();
            var image_link = media_attachment.url;
            jQuery(image_field).val(image_link);
        });
        // Now that everything has been set, let's open up the frame.
        tgm_media_frame.open();
    });

    //Remove image button
    jQuery(".remove-item-image").on("click",function(){
        $(this).siblings('.edit-menu-item-_crum_mega_menu_image').val("");
        return false;
    });

	/** Metabox options show/hide **/

	(function($){
		$(document).ready(function(){
			$("#meta_header_custom_options").hide();
			$("#page_custom_stunning_header").hide();
			$("#stun-head-options").hide();
			$("#page_custom_subtitle").hide();

			if($('#meta_options_bar_show2').is(':checked')) {
				$("#meta_header_custom_options").show();
				$("#page_custom_stunning_header").hide();
				$("#stun-head-options").hide();
				$("#page_custom_subtitle").hide();
			}else if($('#meta_options_bar_show3').is(':checked')) {
				$("#meta_header_custom_options").hide();
				$("#page_custom_stunning_header").show();
				$("#stun-head-options").show();
				$("#page_custom_subtitle").hide();
			}else if($('#meta_options_bar_show4').is(':checked')) {
				$("#meta_header_custom_options").hide();
				$("#page_custom_stunning_header").hide();
				$("#stun-head-options").hide();
				$("#page_custom_subtitle").show();
			}else{
				$("#meta_header_custom_options").hide();
				$("#page_custom_stunning_header").hide();
				$("#stun-head-options").hide();
				$("#page_custom_subtitle").hide();
			}

			$('.cmb_radio_list').click(function() {
				if($('#meta_options_bar_show2').is(':checked')) {
					$("#meta_header_custom_options").show();
					$("#page_custom_stunning_header").hide();
					$("#stun-head-options").hide();
					$("#page_custom_subtitle").hide();
				}else if($('#meta_options_bar_show3').is(':checked')) {
					$("#meta_header_custom_options").hide();
					$("#page_custom_stunning_header").show();
					$("#stun-head-options").show();
					$("#page_custom_subtitle").hide();
				}else if($('#meta_options_bar_show4').is(':checked')) {
					$("#meta_header_custom_options").hide();
					$("#page_custom_stunning_header").hide();
					$("#stun-head-options").hide();
					$("#page_custom_subtitle").show();
				}else{
					$("#meta_header_custom_options").hide();
					$("#page_custom_stunning_header").hide();
					$("#stun-head-options").hide();
					$("#page_custom_subtitle").hide();
				}
			});

		})
	})(jQuery);

	/** Metabox options post columns on blog show/hide **/

	(function($){
		$(document).ready(function(){
			$(".cmb_id_newspage_post_columns").hide();

			if ($("#blog_post_style1").is(':checked')){
				$(".cmb_id_newspage_post_columns").show();
			}

			$('.cmb_radio_list').click(function() {
				if($('#blog_post_style1').is(':checked')) {
					$(".cmb_id_newspage_post_columns").show();
				}else if($('#blog_post_style2').is(':checked')) {
					$(".cmb_id_newspage_post_columns").hide();
				}else if($('#blog_post_style3').is(':checked')) {
					$(".cmb_id_newspage_post_columns").hide();
				}else{
					$(".cmb_id_newspage_post_columns").hide();
				}
			});

		})
	})(jQuery);

	/** Metabox show/hide **/

	(function($){
		$(document).ready(function(){
			$(".cmb_id_meta_header_color_bg").hide();
			$(".cmb_id_meta_header_opacity_bg").hide();
			$(".cmb_id_meta_header_color_font").hide();
			$(".cmb_id_meta_header_banner_code").hide();

			$('.cmb_radio_list').click(function() {
				if($('#meta_header_style5').is(':checked')) {
					$(".cmb_id_meta_header_color_bg").show();
					$(".cmb_id_meta_header_opacity_bg").show();
					$(".cmb_id_meta_header_color_font").show();
					$(".cmb_id_meta_header_banner_code").hide();
				}else if($('#meta_header_style4').is(':checked')) {
					$(".cmb_id_meta_header_color_bg").show();
					$(".cmb_id_meta_header_opacity_bg").show();
					$(".cmb_id_meta_header_color_font").show();
					$(".cmb_id_meta_header_banner_code").hide();
				}else if($('#meta_header_style3').is(':checked')) {
					$(".cmb_id_meta_header_color_bg").show();
					$(".cmb_id_meta_header_opacity_bg").show();
					$(".cmb_id_meta_header_color_font").show();
					$(".cmb_id_meta_header_banner_code").show();
				}else if($('#meta_header_style2').is(':checked')) {
					$(".cmb_id_meta_header_color_bg").show();
					$(".cmb_id_meta_header_opacity_bg").show();
					$(".cmb_id_meta_header_color_font").show();
					$(".cmb_id_meta_header_banner_code").hide();
				}else{
					$(".cmb_id_meta_header_color_bg").hide();
					$(".cmb_id_meta_header_opacity_bg").hide();
					$(".cmb_id_meta_header_color_font").hide();
					$(".cmb_id_meta_header_banner_code").hide();
				}
			});

		})
	})(jQuery);

	/*Folio options metaboxes*/
	(function($){
		$(document).ready(function(){
			$(".cmb_id_single_folio_list_style").hide();
			$(".cmb_id_single_folio_grid_columns").hide();
			$(".cmb_id_single_folio_space_gap").hide();
			$(".cmb_id_single_folio_sorting_panel").hide();
			$(".cmb_id_single_folio_item_description").hide();
			$(".cmb_id_single_folio_read_more").hide();

			$('.cmb_radio_list').click(function() {
				if($('#single_folio_template2').is(':checked')) {
					$(".cmb_id_single_folio_list_style").show();
					$(".cmb_id_single_folio_grid_columns").hide();
					$(".cmb_id_single_folio_space_gap").hide();
					$(".cmb_id_single_folio_sorting_panel").hide();
					$(".cmb_id_single_folio_item_description").hide();
					$(".cmb_id_single_folio_read_more").hide();
				}else if($('#single_folio_template3').is(':checked')){
					$(".cmb_id_single_folio_list_style").hide();
					$(".cmb_id_single_folio_grid_columns").show();
					$(".cmb_id_single_folio_space_gap").show();
					$(".cmb_id_single_folio_sorting_panel").show();
					$(".cmb_id_single_folio_item_description").show();
					$(".cmb_id_single_folio_read_more").hide();
				}else if ($('#single_folio_template4').is(':checked')){
					$(".cmb_id_single_folio_list_style").hide();
					$(".cmb_id_single_folio_grid_columns").show();
					$(".cmb_id_single_folio_space_gap").show();
					$(".cmb_id_single_folio_sorting_panel").hide();
					$(".cmb_id_single_folio_item_description").hide();
					$(".cmb_id_single_folio_read_more").show();
				}else{
					$(".cmb_id_single_folio_list_style").hide();
					$(".cmb_id_single_folio_grid_columns").hide();
					$(".cmb_id_single_folio_space_gap").hide();
					$(".cmb_id_single_folio_sorting_panel").hide();
					$(".cmb_id_single_folio_item_description").hide();
					$(".cmb_id_single_folio_read_more").hide();
				}
			});

		})
	})(jQuery);
});