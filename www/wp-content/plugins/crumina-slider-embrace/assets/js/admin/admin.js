/**======================================================
 * WORDPRESS ADMINISTRATION PAGE SLIDER INTERFACE JS
 * ======================================================
 * 
 * This file contains all custom jQuery plugins and code 
 * used in the admin part of the website. All jQuery 
 * is loaded in no-conflict mode in order to prevent js 
 * library conflicts.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 *
 * Licensed under the Apache License, Version 2.0 
 * (the "License") you may not use this file except in 
 * compliance with the License. You may obtain a copy 
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in 
 * writing, software distributed under the License is 
 * distributed on an "AS IS" BASIS, WITHOUT WARRANTIES 
 * OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing 
 * permissions and limitations under the License.
 *
 * PLEASE NOTE: The following dependancies are required
 * in order for this file to run correctly:
 *
 * 1. jQuery	( http://jquery.com/ )
 * 2. jQueryUI	( http://jqueryui.com/ )
 * 3. cruminal10n js object to be enqueued on the page
 *
 * ======================================================= */
;( function($, window, document, undefined) {"use strict";
	$.fn.themeSliderMenu = function() {
		var api = this;

		// Flag to listen for slider changes
		var sliderChanged = false;

		// Flags for right to left support
		var isRTL       = !! ( 'undefined' != typeof isRtl && isRtl );
		var negateIfRTL = ( 'undefined' != typeof isRtl && isRtl ) ? -1 : 1;
		
		// Get slider list and target list
		var sliderList = $( '#slider-to-edit' );
		var targetList;

		/**
		 * Setup Plugin
		 * 
		 * @description - Calls all of the required plugins 
		 *     for the Page Slider Admin Screen.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.init = function() {
			// Register custom jQuery extensions used by this plugin
			api.jQueryExtensions();

			// Edit, Create and Manage Events
			api.initAccordion();
			api.initToggles();
			api.attachTabsPanelListeners();
			api.attachQuickSearchListeners();
			api.setupInputWithDefaultTitle();
			api.initSortables();
			api.registerEditEvents();
			api.registerManagementEvents();
			api.unregisterChange();

			// Add unload event
			$(window).on( 'beforeunload', function() {
				if ( sliderChanged ) {
					return cruminal10n.confirmation;
				}
			});			
		};

		/**
		 * Register Slider Changes
		 *
		 * @description - Set the sliderChanged variable to 
		 *     true to flag any unsaved changes in the admin 
		 *     interface.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.registerChange = function() {
			sliderChanged = true;
		};

		/**
		 * Unregister Slider Changes
		 *
		 * @description - Set the sliderChanged variable to 
		 *     true to flag any unsaved changes in the admin 
		 *     interface.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.unregisterChange = function() {
			sliderChanged = false;
		};

		/**
		 * Initialise Metabox Accordion
		 *
		 * @description - Initialises the metabox accordion used 
		 *     to show pages/posts/taxonomies etc that are available
		 *     to insert into the current page slider.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.initAccordion = function() {
			var accordionOptions = $( '.accordion-container li.accordion-section' );
			$( '.accordion-section-content input[type="checkbox"]' ).prop( 'checked', false );
			accordionOptions.removeClass( 'open' );
			accordionOptions.filter( ':visible' ).first().addClass( 'open first-child' );
			api.initPagination();
		};

		/**
		 * Initialise jQuery Sortables on Sidebar Items List
		 *
		 * @description - Initialised the jQuery UI Sortables plugin 
		 *     functionality in order to allow the user to order their 
		 *     page slider items. Mimics the native nav menu functionality 
		 *     in WordPress.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.initSortables = function() {

			var currentDepth = 0;
			var originalDepth, minDepth, maxDepth, prev, next, prevBottom, nextThreshold, helperHeight, transport;

			if( 0 !== $( '#slider-to-edit li' ).length ) {
				$( '.drag-instructions' ).show();
			} else {
				$( '#slider-instructions' ).show();
			}

			// Initialise jQuery sortable on the sidebar items list
			$( "#slider-to-edit" ).sortable({
				// axis: "y", // Uncomment to restrict sidebar item movement
				handle: ".menu-item-handle",
				placeholder: "sortable-placeholder",
				sort : function( event, ui ) {
					$( "#slider-to-edit .sortable-placeholder" ).height( ( $('.ui-sortable-helper').height() - 2 ) );
				},
				change : function( event, ui ) {
					api.registerChange();
				}
			});

			// Attach events to each list item
			$("#slider-to-edit li").each(function(){
				
				var li            = $(this);
				var trigger       = $(this).find('a.item-edit');
				var cancelTrigger = $(this).find('a.item-cancel');
				var removeTrigger = $(this).find('a.item-delete');
				var panel         = $(this).find('div.menu-item-settings');

				// Panel show/hide trigger handling
				trigger.on('click', function(e){
					e.preventDefault();
					panel.slideToggle('fast');
					return false;
				});

				// Cancel trigger handling
				cancelTrigger.on('click', function(){
					panel.toggle();
					return false;
				});

				// Remove trigger handling
				removeTrigger.on('click', function(){
					li.addClass('deleting');
					li.slideFadeToggle( 350, function(){
						li.remove();
						api.registerChange();
						// Update contextual help message
						if( 0 !== $( '#slider-to-edit li' ).length ) {
							$( '#slider-instructions' ).hide();
							$( '.drag-instructions' ).show();
						} else {
							$( '.drag-instructions' ).hide();
							$( '#slider-instructions' ).show();
						}
					});

					return false;
				});
			});

			// $( "#slider-to-edit" ).disableSelection();
		};

		/**
		 * Initialise Pagination
		 *
		 * @description - Enables the ability for the user to paginate
		 *     through a large list in a taxonomy without refreshing 
		 *     the page. This is a recursive function.
		 *
		 * @param {string} panelLink - CSS selector for all panel links
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.initPagination = function( panelLink ) {
			var panelId;
			// Attach event to all panel links if one hasn't been passed in the parameter
			panelLink = panelLink || '.add-menu-item-pagelinks a';

			// Pagination Handling
			$( panelLink ).on( 'click', function(e) {
					e.preventDefault();
					$.post( ajaxurl, e.target.href.replace(/.*\?/, '').replace(/action=([^&]*)/, '') + '&action=crumina_slider_get_metabox',
						function( resp ) {
							if ( -1 == resp.indexOf('replace-id') )
								return;
							var metaBoxData = $.parseJSON(resp),
							toReplace       = document.getElementById(metaBoxData['replace-id']),
							placeholder     = document.createElement('div'),
							wrap            = document.createElement('div');

							// Update Panel Link and Pnale ID
							panelLink = '#' + metaBoxData['replace-id'] + ' .add-menu-item-pagelinks a';
							panelId   = '#' + metaBoxData['replace-id'];

							if ( ! metaBoxData['markup'] || ! toReplace )
								return;

							wrap.innerHTML = metaBoxData['markup'] ? metaBoxData['markup'] : '';

							toReplace.parentNode.insertBefore( placeholder, toReplace );
							placeholder.parentNode.removeChild( toReplace );
							placeholder.parentNode.insertBefore( wrap, placeholder );
							placeholder.parentNode.removeChild( placeholder );

						}
					).done(function(){
						api.initPagination( panelId );
						api.attachTabsPanelListeners( panelId );
						api.setupInputWithDefaultTitle();
						api.attachQuickSearchListeners( panelId + ' .quick-search' );
					});

				return false;
			});
		};

		/**
		 * Initialise Metabox Toggles
		 *
		 * @description - AJAX function that enables the user to 
		 *    show/hide the metaboxes on the options page screen. 
		 *    This calls an ajax function server side in order for
		 *    persistent storage of the users preference.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.initToggles = function() {
			$('.hide-postbox-tog').on( 'click', function(){
				var checkbox = $(this);
				var value = checkbox.attr( 'value' );

				if ( checkbox.prop( 'checked' ) )  {
					$( '#' + value ).removeClass('hidden');
				} else {
					$( '#' + value ).addClass('hidden');
				}

				var accordionTitles = $( '.accordion-container li.accordion-section' );
				accordionTitles.removeClass( 'first-child' );
				accordionTitles.filter(':visible').first().addClass( 'first-child' );

				if ( ! accordionTitles.filter(':visible').hasClass( 'open') ) {
					api.initAccordion();
				}

				var hidden = $( '.accordion-container li.accordion-section' ).filter(':hidden').map(function() { return this.id; }).get().join(',');
				$.post(ajaxurl, {
					action: 'closed-postboxes',
					hidden: hidden,
					closedpostboxesnonce: $('#closedpostboxesnonce').val(),
					page: 'toplevel_page_crumina-page-slider'
				});
			});
		};

		/**
		 * Initialise Tab Panel Events
		 * 
		 * @description - Creates event listeners and attaches them 
		 *     to the tab panel in order to add interactivity.
		 *
		 * @param {string} panelId - The id selector for the element containing the panels
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.attachTabsPanelListeners = function( panelId ) {
			panelId = panelId || '#slider-all-pages-column';
			
			var tabPanelNav       = panelId + ' a.nav-tab-link';
			var tabPanelSelectAll = panelId + ' a.select-all';
			var tabPanelAddNew    = panelId + ' .submit-add-to-menu';

			// Switch tab panels
			$( tabPanelNav ).on( 'click', function(e){
				// Prevent default actions
				e.preventDefault();

				// Switch tabs and clear checked inputs
				$(this).parent().addClass('tabs').siblings().removeClass('tabs');
				$( $(this).attr( 'href' ) )
					.removeClass( 'tabs-panel-inactive' )
					.addClass( 'tabs-panel-active' )
					.siblings().removeClass( 'tabs-panel-active' )
					.addClass ( 'tabs-panel-inactive' )
					.find( 'input' ).removeAttr( 'checked' );

				// Set focus into the quicksearch input field
				$( $(this).attr( 'href' ) + ' .quick-search' ).focus();
			});

			// Select all checkboxes functionality
			$( tabPanelSelectAll ).on( 'click', function(e){
				// Prevent default actions
				e.preventDefault();
				// Find and select all inputs
				$(this).parent().parent().siblings('.tabs-panel-active').find('input').prop('checked', true);
			});

			// Add listeners for Add to Page Slider Buttons
			$( tabPanelAddNew ).on('click', function(e){
				e.preventDefault();
				$('#' + $(this).attr('id').replace(/submit-/, '')).addSelectedToSlider( api.addMenuItemToBottom );
			});

			return false;
		};

		/**
		 * Initialise Tab Panel Events
		 * 
		 * @description - Creates event listeners and attaches 
		 *     them to the tab panel in order to add interactivity.
		 *
		 * @param {string} panelId - ID selector of the panel (with #)
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.attachTabsPanelListeners = function( panelId ) {

			panelId = panelId || '#slider-all-pages-column';

			var tabPanelNav       = panelId + ' a.nav-tab-link';
			var tabPanelSelectAll = panelId + ' a.select-all';
			var tabPanelAddNew    = panelId + ' .submit-add-to-menu';

			// Switch tab panels
			$( tabPanelNav ).on( 'click', function(e){
				// Prevent default actions
				e.preventDefault();

				// Switch tabs and clear checked inputs
				$(this).parent().addClass('tabs').siblings().removeClass('tabs');
				$( $(this).attr( 'href' ) )
					.removeClass( 'tabs-panel-inactive' )
					.addClass( 'tabs-panel-active' )
					.siblings().removeClass( 'tabs-panel-active' )
					.addClass ( 'tabs-panel-inactive' )
					.find( 'input' ).removeAttr( 'checked' );

				// Set focus into the quicksearch input field
				$( $(this).attr( 'href' ) + ' .quick-search' ).focus();
			});

			// Select all checkboxes functionality
			$( tabPanelSelectAll ).on( 'click', function(e){
				// Prevent default actions
				e.preventDefault();
				// Find and select all inputs
				$(this).parent().parent().siblings('.tabs-panel-active').find('input').prop('checked', true);
			});

			// Add listeners for Add to Page Slider Buttons
			$( tabPanelAddNew ).on('click', function(e){
				e.preventDefault();
				$('#' + $(this).attr('id').replace(/submit-/, '')).addSelectedToSlider( api.addMenuItemToBottom );
			});

			return false;
		};

		/**
		 * Add Quick Search Listener
		 *
		 * @description - Registers listener events in order to trigger
		 *     the quick search functionality in the tab panel located 
		 *     in the accordion.
		 *
		 * @param {string} selector - Element selector
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.attachQuickSearchListeners = function( selector ) {
			var searchTimer;

			if ( ! selector ) {
				selector = '.quick-search';
			}

			$( selector ).on('keypress', function(e){
				var t = $(this);

				if( 13 == e.which ) {
					api.updateQuickSearchResults( t );
					return false;
				}

				if( searchTimer ) {
					clearTimeout( searchTimer );
				}

				searchTimer = setTimeout(function(){
					api.updateQuickSearchResults( t );
				}, 400);
			}).attr( 'autocomplete', 'off' );
		};

		/**
		 * Update Instant Seach Results
		 *
		 * @description - Generates an AJAX query and updates the 
		 *     search panel with the returned results based on the 
		 *     user input.
		 * 
		 * @param  {string} input - User search query
		 * @return {[type]}       [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.updateQuickSearchResults = function( input ) {
			var panel;
			var params;
			var minSearchLength = 2;
			var q = input.val();

			if( q.length < minSearchLength ) return;

			panel = input.parents( '.tabs-panel' );
			params = {
				'action': 'crumina_slider_quick_search',
				'response-format': 'markup',
				'menu': $('#menu').val(),
				'crumina_slider_quick_search_nonce': $('#crumina_slider_quick_search_nonce').val(),
				'q': q,
				'type': input.attr('name')
			};

			$('.spinner', panel).show();

			$.post( ajaxurl, params, function(sliderMarkup) {
				api.processQuickSearchQueryResponse(sliderMarkup, params, panel);
			});
		};

		/**
		 * Process the quick search response into a search result
		 *
		 * @description - Processes the user input into a response 
		 *     which is then used to update the tab panel with the 
		 *     corresponding results.
		 * 
		 * @param string resp The server response to the query.
		 * @param object req The request arguments.
		 * @param jQuery panel The tabs panel we're searching in.
		 * @todo Add in Localisation L10n and update menu references
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.processQuickSearchQueryResponse = function( resp, req, panel ) {
			var matched, newID,
			takenIDs = {},
			form     = $('#sidebar-meta'),
			pattern  = new RegExp('sidebar-item\\[(\[^\\]\]*)', 'g'),
			$items   = $('<div>').html(resp).find('li'),
			$item;

			if( ! $items.length ) {
				$('.categorychecklist', panel).html( '<li><p>' + cruminal10n.noResultsFound + '</p></li>' );
				$('.spinner', panel).hide();
				return;
			}

			$items.each(function(){
				$item = $(this);

				// make a unique DB ID number
				matched = pattern.exec($item.html());

				if ( matched && matched[1] ) {
					newID = matched[1];
					while( form.elements['sidebar-item[' + newID + '][sidebar-item-type]'] || takenIDs[ newID ] ) {
						newID--;
					}

					takenIDs[newID] = true;
					if ( newID != matched[1] ) {
						$item.html( $item.html().replace(new RegExp(
							'sidebar-item\\[' + matched[1] + '\\]', 'g'),
							'sidebar-item[' + newID + ']'
						) );
					}
				}
			});

			$('.categorychecklist', panel).html( $items );
			$('.spinner', panel).hide();
		};

		/**
		 * Set Input Placeholder Text
		 *
		 * @description - Provides a cross browser compatible 
		 *     way to set placeholder text for input fields.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.setupInputWithDefaultTitle = function() {
			var name = 'input-with-default-title';

			$( '.' + name ).each( function(){
				var $t    = $(this);
				var title = $t.attr('title');
				var val   = $t.val();
				$t.data( name, title );

				if( '' === val ) {
					$t.val( title );
				} else if( title === val ) {
					return;
				} else {
					$t.removeClass( name );
				}

				// Add class on input focus event
				$t.on( 'focus', function() {
					if( $t.val() === $t.data(name) ) {
						$t.val('').removeClass( name );
					}
				});

				// Remove class on input blur event
				$t.on( 'blur', function() {
					if( '' === $t.val() ) {
						$t.addClass( name ).val( $t.data(name) );
					}
				});

			});

			$( '.blank-slate .input-with-default-title' ).focus();
		};

		/**
		 * Register Edit Events
		 * 
		 * @return {[type]} [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.registerEditEvents = function() {
			
			// Slider change event listeners
			$( '#custom-slider-name, .crumina-static-options input, .crumina-dynamic-template-options input, .crumina-dynamic-template-options select, .crumina-dynamic-template-options textarea' ).on( 'change', function(){
				api.registerChange();
			});

			// Disable metaboxes on create screen
			$( '.metabox-holder-disabled input[type="submit"]' ).attr( 'disabled', 'disabled' );

			/**
			 * Create Event
			 * 
			 * Attach event listener in order to create a new crumina
			 * page slider instance.
			 * 
			 */
			$( '#create_slider_header, #create_slider_footer' ).on( 'click', function() {
				var sliderNameLabel = $( '.custom-slider-name-label' );
				var sliderNameInput = $( '#custom-slider-name' );
				var spinner         = $( '.slider-edit .spinner' );

				if ( sliderNameInput.attr('title') === sliderNameInput.val() ) {
					sliderNameLabel.addClass('form-invalid');
					return false;

				} else {
					sliderNameLabel.removeClass('form-invalid');
					spinner.fadeIn(200);
					api.createNewSlider( sliderNameInput.val(), false );
				}

				return false;
			});

			/**
			 * Initialise Static Option Fields
			 *
			 * Initialise the state of static options fields
			 * for this page slider instance.
			 * 
			 */
			
			// Description & Description Limit Functionality
			$( '#cps-show-description' ).on( 'change', function(e) {
				if ( $(this).is( ':checked' ) ) {
					$( '#cps-description-limit-container' ).removeClass( 'hidden' );
				} else {
					$( '#cps-description-limit-container' ).addClass( 'hidden' );
				}
			});

			$('#cps-description-limit').spinner({
				min: 0,
				change: function( event, ui ) {
					api.registerChange();
				}
			});
			
			/**
			 * Initialise Dynamic Option Fields
			 *
			 * Initialise the dynamic option fields for
			 * each template.
			 * 
			 */
			$( '.crumina-dynamic-template-options' ).each( function(e) {
				var templateSelection = $(this).find( '#crumina-page-slider-template' );
				var optionGroups      = $(this).find( '.crumina-template-options-group' );

				/**
				 * Show/Hide option groups based on template selected.
				 */
				templateSelection.on( 'change', function(e) {
					$( optionGroups ).toggleClass( 'hidden' );
				});

				/**
				 * Initialise Color Fields
				 */
				$(this).find( '.crumina-color-input' ).each( function(e) {
					$(this).wpColorPicker({
						change: function( event, ui ) {
							api.registerChange();
						}
					});
				});

				/**
				 * Initialise Number Spinners
				 */
				$(this).find( '.crumina-number-spinner' ).each( function(e) {
					var spinner = $(this);
					var min     = spinner.data( 'min-range' ) ? spinner.data( 'min-range' ) : 0;
					var max     = spinner.data( 'max-range' ) ? spinner.data( 'max-range' ) : 100;
					var step    = spinner.data( 'step' )      ? spinner.data( 'step' )      : 1;					
					var value   = spinner.val();
					
					spinner.spinner({
						min   : min,
						max   : max,
						value : value,
						step  : step,
						change: function( event, ui ) {
							api.registerChange();
						}
					});
				});

				/**
				 * Initialise UI Sliders
				 */
				$(this).find( '.crumina-ui-slider' ).each( function(e) {
					var slider  = $(this);
					var min     = slider.data( 'min-range' ) ? slider.data( 'min-range' ) : 0;
					var max     = slider.data( 'max-range' ) ? slider.data( 'max-range' ) : 100;
					var step    = slider.data( 'step' )      ? slider.data( 'step' )      : 1;
					var value   = slider.data( 'initial-value' );
					var display = $(this).next( '.crumina-ui-slider-display' );
					var reset   = $(this).parent().find( '.crumina-ui-slider-reset' );

					slider.slider({
						min   : min,
						max   : max,
						value : value,
						step  : step,
						slide : function( event, ui ) {
							display.text( ui.value );
						}
					});

					reset.on( 'click', function(e) {
						e.preventDefault();

						var defaultValue = slider.data( 'default-value' );
						slider.slider({ value : defaultValue });
						display.text( defaultValue );
						return false;
					});
				});

			});

			/**
			 * Save and Update Event
			 * 
			 * Attach event listener in order to save changes to a
			 * crumina page slider instance.
			 * 
			 */
			$( '#save_slider_header, #save_slider_footer' ).on( 'click', function() {
				var sliderName      = $( '#custom-slider-name' ).val();
				var sliderId        = $(this).attr( 'data-slider-id' );
				var spinner         = $( '.slider-edit .spinner' );
				var sliderNameLabel = $( '.custom-slider-name-label' );
				var redirectUrl     = $(this).attr( 'data-redirect-url' );

				var processMethod = function() {};
				var callback      = function( newSliderName ) {
					// Fade out spinner and redirect user
					spinner.fadeOut(200);	
					redirectUrl  += '&name=' + newSliderName;
					window.location = redirectUrl.replace( ' ', '+' );		
				};

				// Make sure the user has entered a name for this page slider
				if ( $( '#custom-slider-name' ).attr( 'title' ) === sliderName ) {
					sliderNameLabel.addClass('form-invalid');
					return false;
				}

				sliderNameLabel.removeClass('form-invalid');
				api.saveSlider( sliderName, sliderId, processMethod, callback );		
				spinner.fadeIn(100);
				return false;

			});

			/**
			 * Page Slider Delete Event
			 * 
			 * Attach event listener in order to save changes to a
			 * crumina page slider instance.
			 * 
			 */
			$( '#delete-slider' ).on( 'click', function() {
				var confirmation = confirm( cruminal10n.deleteWarning );
				var sliderId     = $(this).attr( 'data-slider-id' );
				var spinner      = $( '.slider-edit .spinner' );
				var redirectUrl  = $(this).attr( 'data-redirect-url' );

				var processMethod = function() {};
				var callback      = function() {
					window.location = redirectUrl.replace( ' ', '+' );
				};

				// Delete the page slider now that we have the users consent
				if ( confirmation ) {
					if ( '0' !== sliderId ) {
						spinner.fadeIn(200);
						api.deleteSlider( sliderId, processMethod, callback );
					} else {
						callback();
					}					
				}
				return false;
			});
		};

		/**
		 * Register Management Events
		 *
		 * @description - Registers all event handlers that
		 *     exist on the Manage Page Sliders page.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.registerManagementEvents = function() {
			/**
			 * Create New Page Slider Event
			 * Attaches an event listener to the create new slider button.
			 * 
			 */
			$( '#create_new_slider' ).on( 'click', function() {
				window.location =  $(this).attr( 'data-create-slider-url' );
				return false;
			});

			/**
			 * Delete Single Page Slider Link
			 * 
			 * Attaches an event listener to each 'delete' link for
			 * each page slider.
			 * 
			 */
			$( '#page-sliders-table a.slider-delete-link' ).on( 'click', function() {
				var confirmation = confirm( cruminal10n.deleteWarning );
				var row          = $(this).closest('tr');
				var spinner      = row.find( '.spinner' );
				var sliderId     = $(this).data( 'slider-reference' );

				var processMethod = function() {};
				var callback      = function() {
					row.fadeOut(200, function() { 
						row.remove();

						// Update dialog screen if there are no page sliders
						if ( $( '#page-sliders-table tbody tr' ).length === 0 ) {

							// Fade out the table if there are no page sliders
							$( '#page-sliders-table, #delete_all_sliders' ).fadeOut(500);

							// Update slider dialog if there are no page sliders
							$( '.slider-dialog .manage-label' ).fadeOut(200, function(){
								$( '.slider-dialog .new-label' ).fadeIn(300);
							});
						}
					});
				};

				// Delete slider now that we have gained user consent.
				if( confirmation ) {
					spinner.fadeIn();
					row.addClass('deleting', 200);
					api.deleteSlider( sliderId, processMethod, callback );
				}
			});

			/**
			 * Delete All Page Sliders Event
			 * 
			 * Attaches an event listener to the 'delete all' link.
			 * 
			 */			
			$( '#delete_all_sliders' ).on( 'click', function() {
				var confirmation = confirm( cruminal10n.deleteAllWarning );
				var spinners     = $( '#page-sliders-table .spinner' );
				var rows         = $( '#page-sliders-table tbody tr' );
				
				var processMethod = function() {};
				var callback      = function() {
					rows.fadeOut(200);

					// Fade out the table if there are no controls
					$( '#page-sliders-table, #delete_all_sliders' ).fadeOut(500);

					// Update slider dialog as there are no page sliders
					$( '.slider-dialog .manage-label' ).fadeOut(200, function(){
						$( '.slider-dialog .new-label' ).fadeIn(300);
					});
				};
				
				// Delete all controls now that we have gained user consent
				if( confirmation ) {
					spinners.fadeIn();
					rows.addClass( 'deleting', 200 );
					api.deleteAllSliders( processMethod, callback );
				}

				return false;
			});
		};

		/**
		 * Create Page Slider Using AJAX
		 *
		 * @description - Sends an AJAX request in order to 
		 *     create a new page slider instance.
		 * 
		 * @param  {string}   sliderName     - The page slider name
		 * @param  {function} processMethod  - Function to run during an ajax request
		 * @param  {function} callback       - Function to run after a successful ajax request
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.createNewSlider = function( sliderName, processMethod, callback ) {
			api.unregisterChange();
			
			processMethod = processMethod || function(){};
			callback      = callback || function(){};
			var nonce     = $( '#crumina_slider_edit_slider_instance_nonce' ).val();

			var dataObj = {
				'action': 'crumina_create_slider_instance',
				'crumina_slider_edit_slider_instance_nonce' : nonce,
				'slider_name' : sliderName
			};

			$.post( ajaxurl, dataObj, function() {
				processMethod();
			}).done( function(response) {
				var newSliderId;
				var redirectUrl = $( '#create_slider_header' ).attr( 'data-redirect-url' );

				callback();

				// Get new slider ID 
				$( response ).find( 'supplemental' ).each(function(){
					newSliderId = $(this).find( 'new_slider_id' ).text();
					redirectUrl  += '&slider=' + newSliderId;
				});

				// Redirect the user to the newly created slider
				window.location = redirectUrl.replace( ' ', '+' );
			});
		};

		/**
		 * Save Page Slider Using AJAX
		 *
		 * @description - Sends an AJAX request in order to update 
		 *     a specific page slider with the id that matches the 
		 *     value passed into this function. 
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.saveSlider = function( sliderName, sliderId, processMethod, callback ) {
			api.unregisterChange();
			
			sliderName      = sliderName || '';
			sliderId        = sliderId || '0';			
			processMethod   = processMethod || function(){};
			callback        = callback || function(){};
			var nonce       = $( '#crumina_slider_edit_slider_instance_nonce' ).val();
			var attachments = {};
			var position    = 0;
			var selectedTemplate = $( '#crumina-page-slider-template' ).val();

			// Get slider attachment properties
			$( '#slider-to-edit li' ).each( function(e) {
				var sliderDBID = $(this).find( '.menu-item-data-db-id' ).val();
				
				// Set position and increment position count
				$(this).find( '.menu-item-data-position' ).attr( 'value', position );
				attachments[position] = $(this).getItemData();
				position++;
			});

			var dataObj = {
				'action'									: 'crumina_update_slider_instance',
				'crumina_slider_edit_slider_instance_nonce' : nonce,
				'attachments' 								: attachments,
				'slider-id' 								: sliderId,
				'slider-name' 								: sliderName,
				'show-title' 								: $( '#cps-show-title' ).is( ':checked' ),
				'show-icons' 								: $( '#cps-show-icons' ).is( ':checked' ),
				'show-categories' 							: $( '#cps-show-categories' ).is( ':checked' ),
				'show-link' 								: $( '#cps-show-link' ).is( ':checked' ),
				'show-description' 							: $( '#cps-show-description' ).is( ':checked' ),
				'description-limit' 						: $( '#cps-description-limit' ).val(),
				'template-name'                             : selectedTemplate,
				'template-options'                          : api.getTemplateOptions( selectedTemplate ),
			};

			// Make ajax request to server
			$.post( ajaxurl, dataObj, function() {
				processMethod();
			}).done( function( response ) {
				var newSliderName;
				// Get new sidebar Name
				$(response).find('supplemental').each(function(){
					newSliderName = $(this).find('slider_name').text();
				});
				callback( newSliderName );
			});			
		};

		/**
		 * Delete Page Slider Using AJAX
		 *
		 * @description - Sends an AJAX request in order to 
		 *     delete a specific page slider with the id that 
		 *     matches the value passed into this function. 
		 * 
		 * @param  {string}   sliderId       - The ID (post meta id not post id) of the page slider we want to delete
		 * @param  {function} processMethod  - Function to run during an ajax request
		 * @param  {function} callback       - Function to run after a successful ajax request
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.deleteSlider = function( sliderId, processMethod, callback ) {
			api.unregisterChange();

			processMethod = processMethod || function(){};
			callback      = callback || function(){};
			var nonce     = $( '#crumina_slider_delete_slider_instance_nonce' ).val();

			var dataObj = {
				'action': 'crumina_delete_slider_instance',
				'sliderId': sliderId,
				'crumina_slider_delete_slider_instance_nonce' : nonce
			};

			$.post( ajaxurl, dataObj, function() {
				processMethod();
			}).done( function() {
				callback();
			});
		};

		/**
		 * Delete All Page Sliders Using AJAX
		 *
		 * @description - Constructs an AJAX request to 
		 *     delete all page slider instances. Sends a 
		 *     WordPress generated nonce to ensure that 
		 *     this is a legitamate request.
		 * 
		 * @param  {Function}   processMethod - Function to execute during request
		 * @param  {Function}   callback      - Function to execute after successful AJAX reequest.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.deleteAllSliders = function( processMethod, callback ) {
			api.unregisterChange();
			
			processMethod = processMethod || function(){};
			callback      = callback || function(){};
			var nonce     = $( '#crumina_slider_delete_slider_instance_nonce' ).val();

			var dataObj = {
				'action': 'crumina_delete_all_slider_instances',
				'crumina_slider_delete_slider_instance_nonce' : nonce
			};
			
			$.post( ajaxurl, dataObj, function() {
				processMethod();
			}).done( function() {
				callback();
			});
		};

		api.addItemToSlider = function( sliderItem, processMethod, callback ) {
			// api.registerChange();

			var menu      = $('#slider').val();
			var nonce     = $( '#crumina_slider_edit_slider_instance_nonce' ).val();
			processMethod = processMethod || function(){};
			callback      = callback || function(){};

			var dataObj = {
				'action': 'crumina_add_slider_item',
				'menu': menu,
				'menu-item': sliderItem,
				'crumina_slider_edit_slider_instance_nonce' : nonce
			};

			// NOTE: Append this markup to the list (Possible Sanity Checks to see if it has already been added)
			$.post( ajaxurl, dataObj, function( sliderMarkup ) {
				var ins   = $( '#slider-instructions' );
				processMethod( sliderMarkup, dataObj );

				// Make it stand out a bit more visually, by adding a fadeIn
				$( 'li.pending' ).each( function() {
					var li            = $(this).hide().fadeIn( 'slow' ).removeClass( 'pending' );
					var panel         = li.find( 'div.menu-item-settings' );
					var trigger       = li.find('a.item-edit');
					var cancelTrigger = li.find('a.item-cancel');
					var removeTrigger = li.find('a.item-delete');

					// Trigger Event
					trigger.on( 'click', function() {
						panel.slideToggle('fast');
						return false;
					});

					cancelTrigger.on( 'click', function() {
						panel.toggle();
						return false;
					});

					removeTrigger.on( 'click', function() {
						api.registerChange();
						li.addClass('deleting');
						li.slideFadeToggle( 350, function(){
							li.remove();

							// Update contextual help message
							if( 0 !== $( '#slider-to-edit li' ).length ) {
								$( '#slider-instructions' ).hide();
								$( '.drag-instructions' ).show();
							} else {
								$( '.drag-instructions' ).hide();
								$( '#slider-instructions' ).show();
							}
						});
						return false;
					});									
				});
				
				// Update contextual help message
				$( '#slider-instructions' ).hide();
				$( '.drag-instructions' ).show();				

				if( ! ins.hasClass( 'menu-instructions-inactive' ) && ins.siblings().length ) {
					ins.addClass( 'menu-instructions-inactive' );
				}
				callback();

			});
		};

		/**
		 * Get Template Options
		 *
		 * @description - This function gets the appropriate
		 *     options for a template and returns a json obj
		 *     containing the field name and its properties. 
		 *     This function expects each input to have a 
		 *     unique name (name attribute).
		 * 
		 * @param  {string} templateSlug [description]
		 * @return {object}              [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.getTemplateOptions = function( templateSlug ) {
			
			var options     = {};
			var optionGroup = $( '[data-options-for-template="' + templateSlug + '"]' );
			var checkboxes  = optionGroup.find( '.crumina-option.crumina-checkbox' );
			var selects     = optionGroup.find( '.crumina-option.crumina-select' );
			var inputs      = optionGroup.find( '.crumina-option.crumina-text-input, .crumina-option.crumina-textarea' );
			var numbers     = optionGroup.find( '.crumina-option.crumina-number-spinner' );
			var colors      = optionGroup.find( '.crumina-option.crumina-color-input' );
			var sliders     = optionGroup.find( '.crumina-option.crumina-ui-slider' );
			
			// Parse checkboxes
			checkboxes.each( function(e) {
				var t     = $(this);
				var name  = t.attr('name');
				var value = t.is( ':checked' );

				// Add to options object
				options[ name ] = value;

			});

			// Parse ui sliders
			sliders.each( function(e) {
				var t = $(this);
				var name  = t.attr('name');
				var value = t.slider( 'value' );

				// Add to options object
				options[ name ] = value;			
			});
			 
			// Parse selects
			selects.each( function(e) {
				var t     = $(this);
				var name  = t.attr('name');
				var value = t.val();

				// Add to options object
				options[ name ] = value;
			});

			// Parse inputs
			inputs.each( function(e) {
				var t     = $(this);
				var name  = t.attr('name');
				var value = t.val();

				// Add to options object
				options[ name ] = value;
			});

			// Parse numbers
			numbers.each( function(e) {
				var t     = $(this);
				var name  = t.attr('name');
				var value = t.val();

				// Add to options object
				options[ name ] = value;
			});

			// Parse Colors
			colors.each( function(e) {
				var t     = $(this);
				var name  = t.attr('name');
				var value = t.val();

				// Add to options object
				options[ name ] = value;
			});


			return options;
		};

		/**
		 * Add Menu Item to Bottom
		 * 
		 * @description - Process the add menu item request 
		 *     response into menu list item.
		 *
		 * @param string sliderMarkup The text server response of menu item markup.
		 * @param object req The request arguments.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.addMenuItemToBottom = function( sliderMarkup, req ) {
			$(sliderMarkup).appendTo( $('#slider-to-edit') );
		};

		/**
		 * Add Menu Item to Top
		 * 
		 * @description - Process the add menu item request 
		 *     response into menu list item.
		 *
		 * @param string sliderMarkup The text server response of menu item markup.
		 * @param object req The request arguments.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.addMenuItemToTop = function( sliderMarkup, req ) {
			$(sliderMarkup).prependTo( $('#slider-to-edit') );
		};

		/**
		 * Extend Global jQuery functions
		 *
		 * @description - Defines additional jQuery functions 
		 *     that can be used in a global context upon plugin 
		 *     initialisation. It does this by extending jQuery's 
		 *     global function object.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		api.jQueryExtensions = function() {
			// Extend jQuery global functions object
			$.fn.extend({ 
				menuItemDepth : function() {
					var margin = api.isRTL ? this.eq(0).css('margin-right') : this.eq(0).css('margin-left');
					return api.pxToDepth( margin && -1 != margin.indexOf('px') ? margin.slice(0, -2) : 0 );
				},

				updateParentMenuItemDBId : function() {
					return this.each(function(){
						var item        = $(this),
							input       = item.find( '.menu-item-data-parent-id' ),
							depth       = parseInt( item.menuItemDepth(), 16 ),
							parentDepth = depth - 1,
							parent      = item.prevAll( '.menu-item-depth-' + parentDepth ).first();

						if ( 0 === depth ) { // Item is on the top level, has no parent
							input.val(0);
						} else { // Find the parent item, and retrieve its object id.
							input.val( parent.find( '.menu-item-data-db-id' ).val() );
						}
					});
				},

				hideAdvancedMenuItemFields : function() {
					return this.each(function(){
						var that = $(this);
						$('.hide-column-tog').not(':checked').each(function(){
							that.find('.field-' + $(this).val() ).addClass('hidden-field');
						});
					});
				},

				slideFadeToggle : function(speed, easing, callback) {
					return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
				},

				/**
				 * Adds selected menu items to the menu.
				 *
				 * @param jQuery metabox The metabox jQuery object.
				 */
				addSelectedToSlider : function( processMethod ) {

					if ( 0 === $( '#slider-to-edit' ).length ) {
						return false;
					}

					return this.each(function() {
						var t          = $(this);
						var menuItems  = {};
						var checkboxes = ( cruminal10n.oneThemeLocationNoSliders && 0 === t.find('.tabs-panel-active .categorychecklist li input:checked').length ) ? t.find('#page-all li input[type="checkbox"]') : t.find('.tabs-panel-active .categorychecklist li input:checked');
						var re         = new RegExp('menu-item\\[(\[^\\]\]*)');

						processMethod  = processMethod || api.addMenuItemToBottom;

						// If no items are checked, bail.
						if ( !checkboxes.length )
							return false;

						// Show the ajax spinner
						t.find('.spinner').show();

						// Retrieve menu item data
						$(checkboxes).each(function(){

							var t = $(this),
								listItemDBIDMatch = re.exec( t.attr('name') ),
								listItemDBID = 'undefined' == typeof listItemDBIDMatch[1] ? 0 : parseInt(listItemDBIDMatch[1], 10);

							if ( this.className && -1 != this.className.indexOf('add-to-top') )
								processMethod = api.addMenuItemToTop;
								menuItems[listItemDBID] = t.closest('li').getItemData( 'add-menu-item', listItemDBID );
						});

						// Add the individual item to the sortable list
						api.addItemToSlider(menuItems, processMethod, function(){
							// Deselect the items and hide the ajax spinner
							checkboxes.removeAttr('checked');
							t.find('.spinner').hide();
						});
					});
				},

				getItemData : function( itemType, id ) {
					itemType = itemType || 'menu-item';

					var itemData = {}, i,
					fields = [
						'menu-item-db-id',
						'menu-item-object-id',
						'menu-item-object',
						'menu-item-parent-id',
						'menu-item-position',
						'menu-item-type',
						'menu-item-title',
						'menu-item-url',
						'menu-item-description',
						'menu-item-attr-title',
						'menu-item-target',
						'menu-item-classes',
						'menu-item-xfn',
						'menu-item-crumina-post-offset',
						'menu-item-crumina-post-order',
						'menu-item-crumina-number-of-posts',
					];

					if( !id && itemType == 'menu-item' ) {
						id = this.find('.menu-item-data-db-id').val();
					}

					if( !id ) return itemData;

					this.find('input, select').each(function() {
						var field;
						i = fields.length;
						while ( i-- ) {
							if( itemType == 'menu-item' )
								field = fields[i] + '[' + id + ']';
							else if( itemType == 'add-menu-item' )
								field = 'menu-item[' + id + '][' + fields[i] + ']';

							if (
								this.name &&
								field == this.name
							) {
								itemData[fields[i]] = this.value;
							}
						}
					});

					return itemData;
				},

				setItemData : function( itemData, itemType, id ) { // Can take a type, such as 'menu-item', or an id.
					itemType = itemType || 'menu-item';

					if( !id && itemType == 'menu-item' ) {
						id = $('.menu-item-data-db-id', this).val();
					}

					if( !id ) return this;

					this.find('input').each(function() {
						var t = $(this), field;
						$.each( itemData, function( attr, val ) {
							if( itemType == 'menu-item' )
								field = attr + '[' + id + ']';
							else if( itemType == 'add-menu-item' )
								field = 'menu-item[' + id + '][' + attr + ']';

							if ( field == t.attr('name') ) {
								t.val( val );
							}
						});
					});
					return this;
				}

			});
		};		

		// Initialise Plugin
		api.init();
		
	}; // END $.fn.themeSliderMenu
}(jQuery, window, document));

/**============================================================
 * INITIALISE PLUGINS & JS ON DOCUMENT READY EVENT
 * ============================================================ */
jQuery(document).ready(function($) {"use strict";
	$(this).themeSliderMenu();
});
