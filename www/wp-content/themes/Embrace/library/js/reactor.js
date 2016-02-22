/* Reactor - Anthony Wilhelm - http://awtheme.com/ */

(function ($) {

    /**
     * Determine the mobile operating system.
     * This function either returns 'iOS', 'Android' or 'unknown'
     *
     * @returns {String}
     */
    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) )
        {
            return 'iOS';

        }
        else if( userAgent.match( /Android/i ) )
        {

            return 'Android';
        }
        else
        {
            return 'unknown';
        }
    }

    $(document).ready(function () {

		////////////////////////////////////
		// 1.0
		// Click on elements actions
		////////////////////////////////////


		// 1.1
		// Open search in top panel on click


        if ($('.search-form').length > 0) {

            $('html').click(function () {
                if ($('.search-form > form').hasClass('active')) {
                    $('.search-form > form').removeClass('active');
                }
            });

            $('.search-form > form').click(function (event) {
                event.stopPropagation();
            });
            $('.search-form').each(function () {

                var $form = $(this);

                $form.first('a').bind('click', function (event) {
                    if ($form.find('form').hasClass('active')) {
                        $form.find('form').submit();
                    } else {
                        $form.find('form').addClass('active');
                    }
                    return false;
                });
                $form.find('.close').bind('click', function () {
                    $form.find('form').removeClass('active');
                    return false;
                });
            });

        }
		// 1.2
		// Lang drop-down on hover

		jQuery(".lang-sel").hover(function () {

			jQuery(this).addClass("hovered");

		}, function () {

			jQuery(this).removeClass("hovered");

		});

		// Megamenu


        if ($("body").hasClass('header-style-2') || $("body").hasClass('header-style-3')) {
            jQuery(document).jetmenu({
                align: "left"
            });
        } else {
            jQuery(document).jetmenu();
        }


		// Fixed header
        if ($("body").hasClass('fixed-header')) {
            if (getMobileOperatingSystem() != 'iOS') {
                $('#header').scrollToFixed({
                    minWidth: '769',
                    dontSetWidth: true,
                    offsets: false,
                    preFixed: function () {
                        $(this).addClass('fixed');
                    },
                    postFixed: function () {
                        $(this).removeClass('fixed');
                    }
                });
            }
        }

		// 1.4
		// Fix retina logo

		$.fn.getRealDimensions = function (outer) {
			var $this = $(this);
			if ($this.length == 0) {
				return false;
			}
			var $clone = $this.clone()
				.show()
				.css('visibility','hidden')
				.appendTo('body');

                var  result = $clone.width();
                $clone.remove();

                return result;


		};

            var logo_img_real_width = $('.logo a').find('.ie').getRealDimensions();
            if (logo_img_real_width) {
                $('.logo .hideie').css('max-width', logo_img_real_width);
            }


        // Fix hover on IOS devices

        $('.entry-thumb').on("touchstart", function (e) {
            "use strict"; //satisfy the code inspectors
            var link = $(this); //preselect the link
            if (link.hasClass('hover')) {
                return true;
            } else {
                link.addClass("hover");
                $('.entry-thumb, .inner-desc-portfolio').not(this).removeClass("hover");
                e.preventDefault();
                return false; //extra, and to make sure the function has consistent return points
            }
        });


        /*---------------------------------
         Show Side MENU On icon click
         -----------------------------------*/

            var $lateral_menu_trigger = $('#cd-menu-trigger'),
                $content_wrapper = $('#primary,#stunning-header'),
                $navigation = $('#header');

                $content_wrapper.addClass('smooth-animation');

            //open-close lateral menu clicking on the menu icon
            $lateral_menu_trigger.on('click', function(event){
                event.preventDefault();

                $lateral_menu_trigger.toggleClass('is-clicked');
                $navigation.toggleClass('lateral-menu-is-open');
                $content_wrapper.toggleClass('lateral-menu-is-open');
                $('#cd-lateral-nav').toggleClass('lateral-menu-is-open');

                //check if transitions are not supported - i.e. in IE9
                if($('html').hasClass('no-csstransitions')) {
                    $('body').toggleClass('overflow-hidden');
                }
            });

            //close lateral menu clicking outside the menu itself
            $content_wrapper.on('click', function(event){
                if( !$(event.target).is('#cd-menu-trigger, #cd-menu-trigger span') ) {
                    $lateral_menu_trigger.removeClass('is-clicked');
                    $navigation.removeClass('lateral-menu-is-open');
                    $content_wrapper.removeClass('lateral-menu-is-open');
                    $('#cd-lateral-nav').removeClass('lateral-menu-is-open');
                    //check if transitions are not supported
                    if($('html').hasClass('no-csstransitions')) {
                        $('body').removeClass('overflow-hidden');
                    }

                }
            });

            //open (or close) submenu items in the lateral menu. Close all the other open submenu items.
            $('#cd-lateral-nav').find('.menu-item-has-children').children('a').on('click', function(event){
                event.preventDefault();
                $(this).toggleClass('submenu-open').next('.sub-menu').slideToggle(200).end().parent('.menu-item-has-children').siblings('.menu-item-has-children').children('a').removeClass('submenu-open').next('.sub-menu').slideUp(200);
            });


        /*---------------------------------
         Show cart On icon click
         -----------------------------------*/

        var $cart_trigger = $('#cd-cart-trigger'),
            $lateral_cart = $('#cd-cart');

        $cart_trigger.on('click', function (event) {
            event.preventDefault();
            toggle_panel_visibility($lateral_cart);
        });

        $lateral_cart.find('.og-close').on('click', function (event) {
            event.preventDefault();
            toggle_panel_visibility($lateral_cart);
        });

        function toggle_panel_visibility($lateral_panel) {
            if ($lateral_panel.hasClass('speed-in')) {
                // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
                $lateral_panel.removeClass('speed-in')

            } else {
                $lateral_panel.addClass('speed-in')
            }
        }

        /*---------------------------------
         Custom share buttons
         -----------------------------------*/

		var $share_container = jQuery('#social-share');


        if ($share_container.length) {
            $share_container.sharrre({

                share: {
                    facebook: true
                },
                template: '<span><a href="#"><i class="soc-icon soc-twitter"></i></a></span> <span><a href="#"><i class="soc-icon soc-facebook"></i></a></span> <span><a href="#"><i class="soc-icon soc-google"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-pinterest"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-linkedin"></i></a></span> <span><a href="#" ><i class="soc-icon soc-stumbleupon"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-digg"></i></a></span>',
                enableHover: false,
                enableTracking: false,
                render: function(api, options){
                    jQuery(api.element).on('click', '.soc-twitter', function() {

                        api.openPopup('twitter');
                    });
                    jQuery(api.element).on('click', '.soc-facebook', function() {

                        api.openPopup('facebook');
                    });
                    jQuery(api.element).on('click', '.soc-google', function() {

                        api.openPopup('googlePlus');
                    });
                    jQuery(api.element).on('click', '.soc-digg', function() {

                        api.openPopup('digg');
                    });
                    jQuery(api.element).on('click', '.soc-stumbleupon', function() {

                        api.openPopup('stumbleupon');
                    });
                    jQuery(api.element).on('click', '.soc-linkedin', function() {

                        api.openPopup('linkedin');
                    });
                    jQuery(api.element).on('click', '.soc-pinterest', function() {

                        api.openPopup('pinterest');
                    });
                }
            });
        }



        $(".accordion dd > a").click(function () {
            var self = this;
            setTimeout(function () {
                var theOffset = $(self).offset();
                $('body,html').animate({ scrollTop: theOffset.top - 100 });
            }, 310);
        });


        // Hide review form - it will be in a lightbox

		// Magnific Popup Lightbox modules

		//Single image
		$("a.zoom").magnificPopup({
			type: 'image'
		});

		// Gallery

		$('.magnific-gallery').magnificPopup({
			type: 'image',
			gallery:{
				enabled:true
			}
		});

		//Several galleries on same page

		$('.magnific-gallery-several').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // the selector for gallery item
				type: 'image',
				gallery: {
					enabled:true
				}
			});
		});


        /*Clients logos Testimonials*/

            var clientList = jQuery('.client-list');

            if (clientList.length > 0) {
                clientList.each(function () {
                    clientList = jQuery(this);

                    quotesWrapper = jQuery('<div class="quotes-wrapper"/>');

                    quotesWrapper.insertBefore(clientList);
                    quotesWrapper.append('<div class="quotes"/>');

                    clientList.children().each(function () {
                        jQuery(this).find('.quote').appendTo(quotesWrapper.find('.quotes'));
                    });
                    clientList.children().on('mouseenter touchend', function (e) {
                        var event = e.type;
                        if (!Modernizr.touch && event == 'mouseenter' || Modernizr.touch && event == 'touchend') {
                            index = jQuery(this).index();
                            var incomingQuote = jQuery(this).parent().parent().find('.quote').eq(index);

                            if (parseInt(incomingQuote.css('top')) != 0) {

                                incomingQuote.addClass('visible');
                                incomingQuote.siblings().removeClass('visible');

                                jQuery(this).addClass('hover').siblings().removeClass('hover');
                            }
                        }
                    });

                    clientList.children().first().addClass('hover');
                    quotesWrapper.find('.quotes').children().first().addClass('visible')
                });
            }


		/*Woocommerce Grig List Toggle*/

		if (jQuery.cookie('gridcookie') == null) {
			jQuery('ul.products').addClass('<?php echo $default; ?>');
			jQuery('.gridlist-toggle #<?php echo $default; ?>').addClass('active');
		}


        /* adjust site for fixed top-bar with wp admin bar */
        if ($('body').hasClass('admin-bar')) {
            if ($('.top-bar').parent().hasClass('fixed')) {

                if ($('body').hasClass('has-top-bar')) {
                    $('.top-bar').parent().css('margin-top', "+=32");
                }

                $('body').css('padding-top', "+=32");
            }
        }

        /* prevent default if menu links are # */
        $('nav a').each(function () {
            var nav = $(this);
            if (nav.attr('href') == '#') {
                $(this).on('click', function (e) {
                    e.preventDefault();
                });
            }
        });

    });

    /* Initialize Foundation Scripts */
    $(document).foundation();


    /***************** Add hover class ******************/

    $('.worker-item').hover(function(){
        $(this).find('.entry-thumb').addClass('hover');
    },function(){
        $(this).find('.entry-thumb').removeClass('hover');
    });


	/***************** Carousel JS ******************/

	$('.carousel').each(function(){
		var $that = $(this);

		var scrollSpeed, easing, slidesShow, slidesScroll, autoplaySpeed;
		var $autoplayBool = ($(this).attr('data-autorotate') == 'true') ? true : false;
		var $dotsBool = ($(this).attr('data-dots') == 'true') ? true : false;
		var $arrowsBool = ($(this).attr('data-arrows') == 'true') ? true : false;
		var $infiniteBool = ($(this).attr('data-infinite') == 'true') ? true : false;

		var $rtl = $(this).data('rtl');

		(parseInt($(this).attr('data-scroll-speed'))) ? scrollSpeed = parseInt($(this).attr('data-scroll-speed')) : scrollSpeed = 300;
		(parseInt($(this).attr('data-slides-show'))) ? slidesShow = parseInt($(this).attr('data-slides-show')) : slidesShow = 4;
		(parseInt($(this).attr('data-slides-scroll'))) ? slidesScroll = parseInt($(this).attr('data-slides-scroll')) : slidesScroll = 2;
		(parseInt($(this).attr('data-autoplay-speed'))) ? autoplaySpeed = parseInt($(this).attr('data-autoplay-speed')) : autoplaySpeed = 3000;
		($(this).attr('data-easing').length > 0) ? easing = $(this).attr('data-easing') : easing = 'linear';

		var $element = $that;
		if($that.find('img').length == 0) $element = $('body');

		imagesLoaded($element,function(instance){
            $(document).ready(function(){
            $that.removeClass();

			$that.slick({
                dots: $dotsBool,
				arrows: $arrowsBool,
                infinite: $infiniteBool,
                speed: scrollSpeed,
                slidesToShow: slidesShow,
                slidesToScroll: slidesScroll,
                autoplay: $autoplayBool,
                autoplaySpeed: autoplaySpeed,
                cssEase: easing,
				rtl: $rtl,
                responsive: [
                    {
                        breakpoint: 780,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },

                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });//images loaded
        });
	});//each

	// fadein for clients / carousels

	$('.fade-in-animation').each(function() {

		$(this).appear(function() {
			$(this).find('> div').each(function(i){
				$(this).delay(i*100).animate({'opacity':"1"},450);
			});

			var $that = $(this);

			//add the css transition class back in after the aniamtion is done
			setTimeout(function(){ $that.addClass('completed'); },($(this).find('> div').length*100) + 450);
		},{accX: 0, accY: -155},'easeInCubic');

	});



    /***************** Pricing Tables ******************/

	var $tallestCol;

	function pricingTableHeight(){
		$('.pricing-table').each(function(){
			$tallestCol = 0;

			$(this).find('> div ul').each(function(){
				($(this).height() > $tallestCol) ? $tallestCol = $(this).height() : $tallestCol = $tallestCol;
			});

			//safety net incase pricing tables height couldn't be determined
			if($tallestCol == 0) $tallestCol = 'auto';

			//set even height
			$(this).find('> div ul').css('height',$tallestCol);

		});
	}

	pricingTableHeight();


	/***************** Accordion Events animation ******************/

	$('.accordion.open-first').each(function(){
		$(this).find('.content').first().css('display','block');
		$(this).find('dd').first().addClass('active');
	});

	$(".accordion dd").on("click", "a:eq(0)", function (event)
	{
		var dd_parent = $(this).parent();

		if(dd_parent.hasClass('active')){
			$(".accordion dd div.content:visible").slideToggle("normal");
			dd_parent.removeClass('active');
		} else
		{
			$(".accordion dd div.content:visible").slideToggle("normal");
			$(this).parent().find(".content").slideToggle("normal");
			dd_parent.parent().find('dd').removeClass('active');
			dd_parent.addClass('active');
		}
	});


	$('.tabs_block').each(function(){
		$(this).find('.tabs-content > div:first').addClass('active');
	});



	/***************** Sliders ******************/

	// slide_paralax
	var slide_paralax = function() {
		jQuery('.crum_slide_parallax').each(function() {
			var $holder = $(this);

			$holder.find('.image-left img, .image-right img').andSelf().css({
				'width': 'auto', 'height': 'auto'
			});

			var $handler = $holder.find('.handler');
			var $pointer = $handler.find('.pointer');
			var $image_left = $holder.find('.image-left');
			var $image_right = $holder.find('.image-right');

			var pointer_height = $pointer.height();

			var hw = $holder.width();
			var lw = $image_left.find('img').width();
			var rw = $image_right.find('img').width();

			var lh = $image_left.find('img').height();
			var rh = $image_right.find('img').height();

			var w = Math.min(lw, rw, hw);
			var half_w = Math.round(w / 2);

			var new_lh = Math.floor(w*lh / lw);
			var new_rh = Math.floor(w*rh / rw);

			var h = Math.min(new_lh, new_rh);

			$holder.find('img').css({
				display: 'block',
				position: 'absolute',
				top: '0'
			}).andSelf().css({width: w, height: h});
			$image_left.css({width: half_w, height: new_lh});
			$image_right.css({width: half_w, height: new_rh});

			$holder.unbind('mousedown touchstart').bind('mousedown touchstart', function(e) {
				var $this = $holder;
				$(document).bind('mousemove touchmove', function(e) {
					var x, y;

					if (e.type == 'touchmove') {
						e.stopImmediatePropagation();
						var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
						x = touch.pageX - $this.offset().left;
						y = touch.pageY - $handler.offset().top;
					} else {
						x = e.pageX - $this.offset().left;
						y = e.pageY - $handler.offset().top;
					}

					var minY = 0;
					var maxY = ($handler.height() - pointer_height) - 4;
					if ( (y > minY) && (y < maxY) ) {
						$pointer.css('top', y);
					} else if (y < minY) {
						$pointer.css('top', minY);
					} else if (y > maxY) {
						$pointer.css('top', maxY);
					}

					var setX = null;
					var
						minX = parseInt($handler.width() / 2) + 1,
						maxX = $holder.width() - parseInt($handler.width() / 2);

					if (x > minX && x < maxX) {
						setX = x;
					} else if (x < minX) {
						// over right border
						setX = minX;
					} else if (x > maxX) {
						// over left border
						setX = maxX;
					}

					if (setX!==null) {
						$handler.css('left', setX);
						$image_left.css('width', setX);
						$image_right.css('width', $holder.width() - setX);
					}
				});
			});

			$holder.unbind('mouseup touchend').bind('mouseup touchend', function() {
				$(document).unbind('mousemove touchmove');
			});
		});
	};

	$(window).on("load resize", function(){
		slide_paralax();
	});

	function stunning_transparent(){

		var header_height = parseInt($('#header').height());
		if($('body').hasClass('header-style-4') && ($('#stunning-header').length > '0') ){
			$('#stunning-header').css("padding-top",header_height);//.addClass('animated fadeIn');
		}
	}

	stunning_transparent();

	$(window).on("resize", function(){
		stunning_transparent();
	});


    function semitransparent(){

        var header_height = parseInt($('#header').height());

        if (jQuery("body").hasClass('header-style-4') && (jQuery('body').hasClass('no-stunning-header')) && (! jQuery("body").hasClass('page-template-page-templatesno-stunning-php'))) {
            jQuery('#primary').css("padding-top",header_height);
        }
    }

    semitransparent();

    /***************************************
     *
     *  Masonry images loaded fix
     *
     **************************************/

    $('.js-masonry').each( function( i, elem ) {
        // separate jQuery object for each element
        var $elem = $( elem );
        // do imagesLoaded on it
        $elem.imagesLoaded( function() {
            // trigger .masonry() when element has loaded images
            $elem.masonry();
        });
    });

    /***************************************
     *
     *  ISOTOPE SORTING PANEL FOR PORTFOLIO
     *
     **************************************/


    $('.portfolio-sortable').each(function () {

        var $portfolio_container = $(this);
        var $window = jQuery(window);
        var $sorting_buttons = $portfolio_container.siblings('.filter-nav').find('button');

        $sorting_buttons.each(function () {

            var selector = $(this).attr('data-filter');
            var count = $portfolio_container.find(selector).length;

            if (count == 0) {
                $(this).css('display', 'none');
            } else {
                $(this).find('.count').html(count);
            }

        });

        ////filter event
        $sorting_buttons.click(function () {

            var selector = $(this).attr('data-filter');

            $(this).siblings().removeClass('active');
            $(this).addClass('active');


            $portfolio_container.isotope({
                filter: selector
            });

            return false;
        });


        //// start up isotope with default settings
        jQuery(document).ready(function () {
        $portfolio_container.imagesLoaded(function () {
                //initial call to setup isotope
                var $layoutMode = ($($portfolio_container).find('.elastic-portfolio-item').length > 0) ? 'masonry' : 'fitRows';

                $portfolio_container.isotope().isotope({
                    resizable: true,
                    itemSelector: '.isotope-item',
                    layoutMode: $layoutMode
                }).isotope('layout');

            });
        });
    });


    /** Used Only For Touch Devices **/
    ( function( window ) {

        // for touch devices: add class cs-hover to the figures when touching the items
        if( Modernizr.touch ) {

            // classie.js https://github.com/desandro/classie/blob/master/classie.js
            // class helper functions from bonzo https://github.com/ded/bonzo

            function classReg( className ) {
                return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
            }

            // classList support for class management
            // altho to be fair, the api sucks because it won't accept multiple classes at once
            var hasClass, addClass, removeClass;

            if ( 'classList' in document.documentElement ) {
                hasClass = function( elem, c ) {
                    return elem.classList.contains( c );
                };
                addClass = function( elem, c ) {
                    elem.classList.add( c );
                };
                removeClass = function( elem, c ) {
                    elem.classList.remove( c );
                };
            }
            else {
                hasClass = function( elem, c ) {
                    return classReg( c ).test( elem.className );
                };
                addClass = function( elem, c ) {
                    if ( !hasClass( elem, c ) ) {
                        elem.className = elem.className + ' ' + c;
                    }
                };
                removeClass = function( elem, c ) {
                    elem.className = elem.className.replace( classReg( c ), ' ' );
                };
            }

            function toggleClass( elem, c ) {
                var fn = hasClass( elem, c ) ? removeClass : addClass;
                fn( elem, c );
            }

            var classie = {
                // full names
                hasClass: hasClass,
                addClass: addClass,
                removeClass: removeClass,
                toggleClass: toggleClass,
                // short names
                has: hasClass,
                add: addClass,
                remove: removeClass,
                toggle: toggleClass
            };

            // transport
            if ( typeof define === 'function' && define.amd ) {
                // AMD
                define( classie );
            } else {
                // browser global
                window.classie = classie;
            }

            [].slice.call( document.querySelectorAll( '.inline-titles' ) ).forEach( function( el, i ) {
                el.querySelector( '.item-grid-title' ).addEventListener( 'touchstart', function(e) {
                    e.stopPropagation();
                }, false );
                el.addEventListener( 'touchstart', function(e) {
                    classie.toggle( this, 'cs-hover' );
                }, false );
            } );

        }

    })( window );

})(jQuery);




// The Shop toggle
jQuery(document).ready(function () {

	jQuery("#grid").click(function () {
		jQuery(this).addClass("active");
		jQuery("#list").removeClass("active");
		jQuery.cookie("gridcookie", "grid", {path: "/"});
		jQuery("ul.products").fadeOut(300, function () {
			jQuery(this).addClass("grid").removeClass("list").fadeIn(300)
		});
		jQuery('.entry-thumbnail').find('img').each(function(){
			jQuery(this).removeClass('animated');
		});
		return!1
	});
	jQuery("#list").click(function () {
		jQuery(this).addClass("active");
		jQuery("#grid").removeClass("active");
		jQuery.cookie("gridcookie", "list", {path: "/"});
		jQuery("ul.products").fadeOut(300, function () {
			jQuery(this).removeClass("grid").addClass("list").fadeIn(300)
		});
		jQuery('.entry-thumbnail').find('img').each(function(){
			jQuery(this).removeClass('animated');
		});
		return!1
	});
	jQuery.cookie("gridcookie") && jQuery("ul.products, #gridlist-toggle").addClass(jQuery.cookie("gridcookie"));
	if ((jQuery.cookie("gridcookie") == "grid") && jQuery('body').hasClass('archive')) {
		jQuery(".gridlist-toggle #grid").addClass("active");
		jQuery(".gridlist-toggle #list").removeClass("active")
	}
	if ((jQuery.cookie("gridcookie") == "list") && jQuery('body').hasClass('archive')) {
		jQuery(".gridlist-toggle #list").addClass("active");
		jQuery(".gridlist-toggle #grid").removeClass("active")
	}
	jQuery("#gridlist-toggle a").click(function (e) {
		e.preventDefault()
	})
});

// Shop Second image show
jQuery(document).ready(function ($) {
	jQuery('ul.products li.prod-has-gallery a:first-child').hover(function () {
		jQuery(this).children('.wp-post-image').removeClass('fadeIn').addClass('animated fadeOut');
		jQuery(this).children('.secondary-image').removeClass('fadeOut').addClass('animated fadeIn');
	}, function () {
		jQuery(this).children('.wp-post-image').removeClass('fadeOut').addClass('fadeIn');
		jQuery(this).children('.secondary-image').removeClass('fadeIn').addClass('fadeOut');
	});

	// Slider Second image show

		jQuery('div.slick-track div.prod-has-gallery a:first-child').hover(function () {
			jQuery(this).children('.wp-post-image').removeClass('fadeIn').addClass('animated fadeOut');
			jQuery(this).children('.secondary-image').removeClass('fadeOut').addClass('animated fadeIn');
		}, function () {
			jQuery(this).children('.wp-post-image').removeClass('fadeOut').addClass('fadeIn');
			jQuery(this).children('.secondary-image').removeClass('fadeIn').addClass('fadeOut');
		});

	//Single productSecond image show

	jQuery('div.products div.prod-has-gallery a:first-child').hover(function () {
		jQuery(this).children('.wp-post-image').removeClass('fadeIn').addClass('animated fadeOut');
		jQuery(this).children('.secondary-image').removeClass('fadeOut').addClass('animated fadeIn');
	}, function () {
		jQuery(this).children('.wp-post-image').removeClass('fadeOut').addClass('fadeIn');
		jQuery(this).children('.secondary-image').removeClass('fadeIn').addClass('fadeOut');
	});



	/*
	 * debouncedresize: special jQuery event that happens once after a window resize
	 *
	 * latest version and complete README available on Github:
	 * https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
	 *
	 * Copyright 2011 @louis_remi
	 * Licensed under the MIT license.
	 */
    var $event = $.event,
        $special,
        resizeTimeout;

    $special = $event.special.debouncedresize = {
        setup: function() {
            $( this ).on( "resize", $special.handler );
        },
        teardown: function() {
            $( this ).off( "resize", $special.handler );
        },
        handler: function( event, execAsap ) {
            // Save the context
            var context = this,
                args = arguments,
                dispatch = function() {
                    // set correct event type
                    event.type = "debouncedresize";
                    $event.dispatch.apply( context, args );
                };

            if ( resizeTimeout ) {
                clearTimeout( resizeTimeout );
            }

            execAsap ?
                dispatch() :
                resizeTimeout = setTimeout( dispatch, $special.threshold );
        },
        threshold: 250
    };

});


    var Grid = (function ($) {

        // grid selector
        var $selector = '.with-inline-desc',
        // list of items
            $grid = $($selector),
        // the items
            $items = $grid.children('li'),
        // current expanded item's index
            current = -1,
        // position (top) of the expanded item
        // used to know if the preview will expand in a different row
            previewPos = -1,
        // extra amount of pixels to scroll the window
            scrollExtra = 50,
        // extra margin when expanded (between preview overlay and the next items)
            marginExpanded = 30,
            $window = $(window), winsize,
            $body = $('html, body'),
        // transitionend events
            transEndEventNames = {
                'WebkitTransition': 'webkitTransitionEnd',
                'MozTransition': 'transitionend',
                'OTransition': 'oTransitionEnd',
                'msTransition': 'MSTransitionEnd',
                'transition': 'transitionend'
            },
            transEndEventName = transEndEventNames[Modernizr.prefixed('transition')],
        // support for csstransitions
            support = Modernizr.csstransitions,
        // default settings
            settings = {
                minHeight: 500,
                speed: 350,
                easing: 'ease'
            };

        function init(config) {

            // the settings..
            settings = $.extend(true, {}, settings, config);

            // preload all images
            $grid.imagesLoaded(function () {

                // save item´s size and offset
                saveItemInfo(true);
                // get window´s size
                getWinSize();
                // initialize some events
                initEvents();

            });

        }

        // add more items to the grid.
        // the new items need to appended to the grid.
        // after that call Grid.addItems(theItems);
        function addItems($newitems) {

            $items = $items.add($newitems);

            $newitems.each(function () {
                var $item = $(this);
                $item.data({
                    offsetTop: $item.offset().top,
                    height: $item.height()
                });
            });

            initItemsEvents($newitems);

        }

        // saves the item´s offset top and height (if saveheight is true)
        function saveItemInfo(saveheight) {
            $items.each(function () {
                var $item = $(this);
                $item.data('offsetTop', $item.offset().top);
                if (saveheight) {
                    $item.data('height', $item.height());
                }
            });
        }

        function initEvents() {

            // when clicking an item, show the preview with the item´s info and large image.
            // close the item if already expanded.
            // also close if clicking on the item´s cross
            initItemsEvents($items);

            // on window resize get the window´s size again
            // reset some values..
            $window.on('debouncedresize', function () {

                scrollExtra = 0;
                previewPos = -1;
                // save item´s offset
                saveItemInfo();
                getWinSize();
                var preview = $.data(this, 'preview');
                if (typeof preview != 'undefined') {
                    hidePreview();
                }

            });

        }

        function initItemsEvents($items) {
            $items.on('click', 'span.og-close', function () {
                hidePreview();
                return false;
            }).find('a.link').on('click', function (e) {
                var $item = $(this).parent().parent().parent();
                // check if item already opened
                current === $item.index() ? hidePreview() : showPreview($item);
                return false;

            });
        }

        function getWinSize() {
            winsize = {width: $window.width(), height: $window.height()};
        }

        function showPreview($item) {

            var preview = $.data(this, 'preview'),
            // item´s offset top
                position = $item.data('offsetTop');

            scrollExtra = 0;

            // if a preview exists and previewPos is different (different row) from item´s top then close it
            if (typeof preview != 'undefined') {

                // not in the same row
                if (previewPos !== position) {
                    // if position > previewPos then we need to take te current preview´s height in consideration when scrolling the window
                    if (position > previewPos) {
                        scrollExtra = preview.height;
                    }
                    hidePreview();
                }
                // same row
                else {
                    preview.update($item);
                    return false;
                }

            }

            // update previewPos
            previewPos = position;
            // initialize new preview for the clicked item
            preview = $.data(this, 'preview', new Preview($item));
            // expand preview overlay
            preview.open();
        }

        function hidePreview() {
            current = -1;
            var preview = $.data(this, 'preview');
            preview.close();
            $.removeData(this, 'preview');
        }

        // the preview obj / overlay
        function Preview($item) {
            this.$item = $item;
            this.expandedIdx = this.$item.index();
            this.create();
            this.update();
        }

        Preview.prototype = {
            create: function () {
                // create Preview structure:
				var $itemLink = this.$item.find('a.link');

                this.$title = $('<h3></h3>');
                this.$description = $('<p></p>');
                this.$href = $('<a href="#">'+$itemLink.data('buttontext')+'</a>');
                this.$details = $('<div class="og-details"></div>').append(this.$title, this.$description, this.$href);
                this.$loading = $('<div class="og-loading"></div>');
                this.$fullimage = $('<div class="og-fullimg"></div>');
                this.$closePreview = $('<span class="og-close"></span>');
                this.$previewInner = $('<div class="og-expander-inner"></div>').append(this.$closePreview, this.$fullimage, this.$details);
                this.$previewEl = $('<div class="og-expander"></div>').append(this.$previewInner);
                // append preview element to the item
                this.$item.append(this.getEl());
                // set the transitions for the preview and the item
                if (support) {
                    this.setTransition();
                }
            },
            update: function ($item) {

                if ($item) {
                    this.$item = $item;
                }

                // if already expanded remove class "og-expanded" from current item and add it to new item
                if (current !== -1) {
                    var $currentItem = $items.eq(current);

                    $currentItem.removeClass('og-expanded');
                    this.$item.addClass('og-expanded');
                    // position the preview correctly
                    this.positionPreview();
                }

                // update current value
                current = this.$item.index();


                // update preview´s content
                var $itemEl = this.$item.find('a.link'),
                    eldata = {
                        href: $itemEl.attr('href'),
                        largesrc : $itemEl.data( 'largesrc' ),
                        galleryItems: $itemEl.parent().parent().parent().find('.full-media').find('.mini-gallery').html(),
                        embeddVideo: $itemEl.parent().parent().parent().find('.full-media').find('.embedd-video').html(),
                        title: $itemEl.data('title'),
                        description: $itemEl.data('description')
                    };

                this.$title.html(eldata.title);
                this.$description.html(eldata.description);
                this.$href.attr('href', eldata.href);

                var self = this;

                // preload large image and add it to the preview
                // for smaller screens we don´t display the large image (the media query will hide the fullimage wrapper)
                if (self.$fullimage.is(':visible')) {

                    self.$fullimage.empty();
                    self.$fullimage.unslick();

                    if (eldata.galleryItems) {
                        self.$fullimage.slick({
                            infinite: false,
                            dots: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });

                        self.$fullimage.slickAdd(eldata.galleryItems);

                    } else if (eldata.embeddVideo && (eldata.embeddVideo != '')) {

                        self.$fullimage.append(eldata.embeddVideo);

                    } else {

                        self.$fullimage.append('<img src="' + eldata.largesrc + '" alt = "' + eldata.title + '"/>');

                    }
                }
            },
            open: function () {

                setTimeout($.proxy(function () {
                    // set the height for the preview and the item
                    this.setHeights();
                    // scroll to position the preview in the right place
                    this.positionPreview();
                }, this), 25);

            },
            close: function () {

                var self = this,
                    onEndFn = function () {
                        if (support) {
                            $(this).off(transEndEventName);
                        }
                        self.$item.removeClass('og-expanded');
                        self.$previewEl.remove();
                    };

                setTimeout($.proxy(function () {

                    if (typeof this.$largeImg !== 'undefined') {
                        this.$largeImg.fadeOut('fast');
                    }
                    this.$previewEl.css('height', 0);
                    // the current expanded item (might be different from this.$item)
                    var $expandedItem = $items.eq(this.expandedIdx);
                    $expandedItem.css('height', $expandedItem.data('height')).on(transEndEventName, onEndFn);

                    if (!support) {
                        onEndFn.call();
                    }
                }, this), 25);

                return false;

            },
            calcHeight: function () {

                var heightPreview = winsize.height - this.$item.data('height') - marginExpanded,
                    itemHeight = winsize.height;

                if (heightPreview < settings.minHeight) {
                    heightPreview = settings.minHeight;
                    itemHeight = settings.minHeight + this.$item.data('height') + marginExpanded;
                }

                this.height = heightPreview;
                this.itemHeight = itemHeight;

            },
            setHeights: function () {

                var self = this,
                    onEndFn = function () {
                        if (support) {
                            self.$item.off(transEndEventName);
                        }
                        self.$item.addClass('og-expanded');
                    };

                this.calcHeight();
                this.$previewEl.css('height', this.height);
                this.$item.css('height', this.itemHeight).on(transEndEventName, onEndFn);

                if (!support) {
                    onEndFn.call();
                }

            },
            positionPreview: function () {

                // scroll page
                // case 1 : preview height + item height fits in window´s height
                // case 2 : preview height + item height does not fit in window´s height and preview height is smaller than window´s height
                // case 3 : preview height + item height does not fit in window´s height and preview height is bigger than window´s height
                var position = this.$item.data('offsetTop'),
                    previewOffsetT = this.$previewEl.offset().top - scrollExtra,
                    scrollVal = this.height + this.$item.data('height') + marginExpanded <= winsize.height ? position : this.height < winsize.height ? previewOffsetT - ( winsize.height - this.height ) : previewOffsetT;

                $body.animate({scrollTop: scrollVal}, settings.speed);

            },
            setTransition: function () {
                this.$previewEl.css('transition', 'height ' + settings.speed + 'ms ' + settings.easing);
                this.$item.css('transition', 'height ' + settings.speed + 'ms ' + settings.easing);
            },
            getEl: function () {
                return this.$previewEl;
            }
        }

        return {
            init: init,
            addItems: addItems
        };

    })(jQuery);






jQuery('.ult_price_features').each(function() {
    jQuery("li").has( "strong" ).addClass("available");
});


jQuery(".ult_price_features > ul > li").wrapInner("<span></span>");


/*
 By Osvaldas Valutis, www.osvaldas.info
 Available for use under the MIT License
 */

;(function(e,t,n,r){e.fn.doubleTapToGo=function(r){if(!("ontouchstart"in t)&&!navigator.msMaxTouchPoints&&!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))return false;this.each(function(){var t=false;e(this).on("click",function(n){var r=e(this);if(r[0]!=t[0]){n.preventDefault();t=r}});e(n).on("click touchstart MSPointerDown",function(n){var r=true,i=e(n.target).parents();for(var s=0;s<i.length;s++)if(i[s]==t[0])r=false;if(r)t=false})});return this}})(jQuery,window,document);

jQuery( '.menu-primary-navigation li.has-submenu' ).doubleTapToGo();
