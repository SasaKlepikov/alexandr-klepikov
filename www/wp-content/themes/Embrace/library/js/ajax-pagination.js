(function ($) {
	'use strict';

	if (window.crum_pagination_data == undefined) {
		return false;
	}

	$(document).ready(function() {

		var page_num = parseInt(crum_pagination_data.startPage) + 1;
		var max_pages = parseInt(crum_pagination_data.maxPages);
		var next_link = crum_pagination_data.nextLink;

		var loaded_text = crum_pagination_data.loaded_text;

		var container = crum_pagination_data.container;
		var $container = $(container);
		var container_has_isotope = false;


		function cr_isotope_items_counter(){
			var $sorting_buttons = $('.filter-nav button');

			$sorting_buttons.each( function(){

				var selector = $(this).attr('data-filter');
				var count = $container.find(selector).length;

				if (count == 0){
					$(this).css('display','none');
				} else {
					$(this).css('display','inline-block');
					$(this).find('.count').html(count);
				}

			});
		}


		var $button = $('#ajax-pagination-load-more');

		if (page_num > max_pages) {
			$button.addClass('last-page').children('span').text(loaded_text);
		}

		$button.bind('click', function() {

			if (page_num <= max_pages && !$(this).hasClass('loading') && !$(this).hasClass('last-page')) {

				$.ajax({
					type: 'GET',
					url: next_link,
					dataType: 'html',
					beforeSend: function() {
						$button.addClass('loading');
					},
					complete: function(XMLHttpRequest) {
						$button.removeClass('loading');

						if (XMLHttpRequest.status == 200 && XMLHttpRequest.responseText != '') {
							page_num++;
							next_link = next_link.replace(/\/page\/[0-9]?/, '/page/'+ page_num);

							if (page_num > max_pages) {
								$button.addClass('last-page').children('span').text( loaded_text );
							}

							if ($(XMLHttpRequest.responseText).find(container).length > 0) {
								container_has_isotope = (typeof($container.isotope) === 'function');
								$(XMLHttpRequest.responseText).find(container).children().each(function() {
									if (!container_has_isotope) {
										$container.append($(this));
										$('body').trigger('container-add-item', $(this));
									} else {
										$container.isotope().isotope( 'insert', $(this), cr_isotope_items_counter() );
										$('body').trigger('isotope-add-item', $(this));

										$container.imagesLoaded(function () {
											$container.isotope('layout');
										});
										$container.magnificPopup({
											delegate: 'a.zoom',
											type: 'image'

										});
									}
								});
							}
						}
					}
				});
			}

			return false;

		});

	});
}(jQuery));