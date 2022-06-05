(function($) {
	'use strict';

	function bb_typo_build_css(){
		var bb_typography_el = $('.tech888f-typography-value');
		if(bb_typography_el.length <= 0) {
			return;
		}

		bb_typography_el.each(function(index){

			var _self = $(this),
				bb_typo_container = _self.closest('.tech888f-typography');

			var bb_typo_properties = ['color', 'line-height', 'letter-spacing', 'word-spacing', 'font-size', 'font-weight', 'font-style', 'white-space', 'text-overflow', 'text-align', 'text-transform', 'text-decoration', 'background-image', 'max-width', 'text-shadow-blur','text-shadow-horizontal', 'text-shadow-vertical', 'text-shadow-color', 'width', 'height', 'max-height', 'z-index', 'display', 'float','position', 'top', 'right','left', 'bottom', 'background-attachment','background-position-x', 'background-position-y', 'box-shadow-horizontal','box-shadow-vertical', 'box-shadow-blur', 'box-shadow-spread','box-shadow-color', 'box-sizing', 'box-overlay-background-color','box-overlay-width', 'box-overlay-height', 'box-overlay-left','box-overlay-right', 'box-overlay-top', 'box-overlay-bottom', 'margin-left', 'margin-right'];
			var bb_typo_css = ".res_custom_" + Date.now();
			var bb_typo_before_css = bb_typo_css + "::before{";
			bb_typo_css += "{";
			var flag = false;
			var b_shadow = '';
			var t_shadow = '';
			var check = true;
			var check_before = false;
			$.each(bb_typo_properties, function( index, property ) {
				var property_el = bb_typo_container.find('.res-typo-' + property);
				if(property_el.length > 0 && property_el.val().trim() != '') {

					var property_val = property_el.val();
					if(property == 'background-image') {
						property_val = "url('" + property_val + "')";
					}
					if(property.indexOf('box-shadow') != -1){
						check = false;
						if(property == 'box-shadow-color'){
							if(!bb_typo_container.find(".res-typo-box-shadow-horizontal").val()) b_shadow += '0px ';
							if(!bb_typo_container.find(".res-typo-box-shadow-vertical").val()) b_shadow += '0px ';
							if(!bb_typo_container.find(".res-typo-box-shadow-blur").val()) b_shadow += '10px ';
							if(!bb_typo_container.find(".res-typo-box-shadow-spread").val()) b_shadow += '0px ';
							b_shadow += property_val;
							if(!property_val) b_shadow = '';
						}
						else{
							if(property_val) b_shadow += property_val+' ';
							else{
								if(property == 'box-shadow-blur') b_shadow += '10px ';
								b_shadow += '0px ';
							}
						}
					}
					if(property.indexOf('text-shadow') != -1){
						check = false;
						if(property == 'text-shadow-color'){
							if(!bb_typo_container.find(".res-typo-text-shadow-blur").val()) t_shadow += '5px ';
							if(!bb_typo_container.find(".res-typo-text-shadow-horizontal").val()) t_shadow += '0px ';
							if(!bb_typo_container.find(".res-typo-text-shadow-vertical").val()) t_shadow += '0px ';
							t_shadow += property_val;
							if(!property_val) t_shadow = '';
						}
						else{
							if(property_val) t_shadow += property_val+' ';
							else{
								if(property == 'text-shadow-blur') t_shadow += '5px ';
								t_shadow += '0px ';
							}
						}
					}
					if(property.indexOf('box-overlay') != -1){
						check = false;
						var css_attr = property.replace("box-overlay-", "");						
						if(property_val) bb_typo_before_css += css_attr + ":" + property_val + '!important;';
						if(property == 'box-overlay-background-color'){							
							if(!property_val) bb_typo_before_css = '';
							else check_before = true;
						}
					}
					if(check) bb_typo_css += property + ':' + property_val + '!important;';
					check = true;
					flag = true;
				}				
				if(!bb_typo_container.find(".res-typo-box-shadow-color").val()) b_shadow = '';
				if(!bb_typo_container.find(".res-typo-text-shadow-color").val()) t_shadow = '';
			});
			if(b_shadow) b_shadow = 'box-shadow: '+b_shadow+' !important;';
			if(t_shadow) t_shadow = 'text-shadow: '+t_shadow+' !important;';
			bb_typo_css += b_shadow+t_shadow+'}';
			if(bb_typo_before_css && check_before) bb_typo_css += bb_typo_before_css + "content: '';position: absolute; display: block !important; top: 0; left: 0; width: 100%; height: 100%;}";
			if(flag) {
				_self.val(bb_typo_css);
			} else {
				_self.val('');
			}

		});
	}

	function bb_typo_init(){
		var bb_typography_el = $('.tech888f-typography-value');

		if(bb_typography_el.length <= 0 || bb_typography_el.val() == '') {
			return;
		}

		bb_typography_el.each(function(index){

			var _self = $(this),
				bb_typography_value = _self.val().trim(),
				bb_typo_container = _self.closest('.tech888f-typography');

			if(bb_typography_value == '') {
				return;
			}
			var data_split = bb_typography_value.split(/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/g);
			bb_typography_value = (data_split[2] && data_split[2].replace(/!important/ig, ""));

			var in_bf = 2;
			if(4 in data_split && data_split[4].indexOf(':before') != -1) in_bf = 5;
			var bb_typography_value_before = (data_split[in_bf] && data_split[in_bf].replace(/!important/ig, ""));
			var bb_typo_properties_bf = bb_typography_value_before.split(/;/);
			$.each(bb_typo_properties_bf, function( index, property_value ) {
				if(property_value == '') {
					return;
				}
				var property = property_value.split(/\:/);

				var property_el = bb_typo_container.find('.res-typo-box-overlay-' + property[0]);
				if(property_el.length > 0) {
					var property_bbval = property[1].trim();					
					property_el.val(property_bbval);
					if(property[0] == 'background-color') {
						property_el.trigger('change');
					}
				}
			});

			var bb_typo_properties = bb_typography_value.split(/;/);
			$.each(bb_typo_properties, function( index, property_value ) {
				if(property_value == '') {
					return;
				}
				var property = property_value.split(/\:/);

				var property_el = bb_typo_container.find('.res-typo-' + property[0]);
				if(property_el.length > 0) {
					var property_bbval = property[1].trim();
					if(property[0] == 'background-image') {
						console.log(property_value);
						property_bbval = property_value.replace("background-image:", "");
						property_bbval = property_bbval.replace("')", "");
						property_bbval = property_bbval.replace("url('", "");
					}
					property_el.val(property_bbval);
					if(property[0] == 'color') {
						property_el.trigger('change');
					}
				}
				if(property[0] == 'text-shadow'){
					var property_bbval = property[1].trim();
					var data = property_bbval.split(' ');
					if(3 in data){
						bb_typo_container.find('.res-typo-text-shadow-blur').val(data[0]);
						bb_typo_container.find('.res-typo-text-shadow-horizontal').val(data[1]);
						bb_typo_container.find('.res-typo-text-shadow-vertical').val(data[2]);
						bb_typo_container.find('.res-typo-text-shadow-color').val(data[3]).trigger('change');
					}
				}
				if(property[0] == 'box-shadow'){
					var property_bbval = property[1].trim();
					var data = property_bbval.split(' ');
					if(4 in data){
						bb_typo_container.find('.res-typo-box-shadow-horizontal').val(data[0]);
						bb_typo_container.find('.res-typo-box-shadow-vertical').val(data[1]);
						bb_typo_container.find('.res-typo-box-shadow-blur').val(data[2]);
						bb_typo_container.find('.res-typo-box-shadow-spread').val(data[3]);
						bb_typo_container.find('.res-typo-box-shadow-color').val(data[4]).trigger('change');
					}
				}
			});

		});
		setTimeout( bb_typo_build_css, 100);
	}
	$.fn.opacity_wpColorPicker = function() {

    	return this.each(function() {

      		var $this = $(this);

      		// check for rgba enabled/disable
      		if( $this.data('rgba') !== false ) {

        		// parse value
        		var picker = $.ot_ParseColorValue( $this.val() );

		        // wpColorPicker core
		        $this.wpColorPicker({

		          	// wpColorPicker: change
		          	change: function( event, ui ) {
			            // update checkerboard background color
			            $this.closest('.wp-picker-container').find('.option-tree-opacity-slider-offset').css('background-color', ui.color.toString());
			            $this.trigger('keyup');
			            setTimeout( bb_typo_build_css, 100);
		        	},

          			// wpColorPicker: create
          			create: function( event, ui ) {

			            // set variables for alpha slider
			            var a8cIris       = $this.data('a8cIris'),
			                $container    = $this.closest('.wp-picker-container'),

			                // appending alpha wrapper
			                $alpha_wrap   = $('<div class="option-tree-opacity-wrap">' +
			                                  '<div class="option-tree-opacity-slider"></div>' +
			                                  '<div class="option-tree-opacity-slider-offset"></div>' +
			                                  '<div class="option-tree-opacity-text"></div>' +
			                                  '</div>').appendTo( $container.find('.wp-picker-holder') ),

			                $alpha_slider = $alpha_wrap.find('.option-tree-opacity-slider'),
			                $alpha_text   = $alpha_wrap.find('.option-tree-opacity-text'),
			                $alpha_offset = $alpha_wrap.find('.option-tree-opacity-slider-offset');

			            // alpha slider
			            $alpha_slider.slider({

			              	// slider: slide
			              	slide: function( event, ui ) {

				                var slide_value = parseFloat( ui.value / 100 );

				                // update iris data alpha && wpColorPicker color option && alpha text
				                a8cIris._color._alpha = slide_value;
				                $this.wpColorPicker( 'color', a8cIris._color.toString() );
				                $alpha_text.text( ( slide_value < 1 ? slide_value : '' ) );

				            },

			              	// slider: create
			              	create: function() {

				                var slide_value = parseFloat( picker.alpha / 100 ),
				                    alpha_text_value = slide_value < 1 ? slide_value : '';

				                // update alpha text && checkerboard background color
				                $alpha_text.text(alpha_text_value);
				                $alpha_offset.css('background-color', picker.value);

				                // wpColorPicker clear button for update iris data alpha && alpha text && slider color option
				                $container.on('click', '.wp-picker-clear', function() {

				                  a8cIris._color._alpha = 1;
				                  $alpha_text.text('');
				                  $alpha_slider.slider('option', 'value', 100).trigger('slide');

				                });

				                // wpColorPicker default button for update iris data alpha && alpha text && slider color option
				                $container.on('click', '.wp-picker-default', function() {

				                  var default_picker = $.ot_ParseColorValue( $this.data('default-color') ),
				                      default_value  = parseFloat( default_picker.alpha / 100 ),
				                      default_text   = default_value < 1 ? default_value : '';

				                  a8cIris._color._alpha = default_value;
				                  $alpha_text.text(default_text);
				                  $alpha_slider.slider('option', 'value', default_picker.alpha).trigger('slide');

				                });

				                // show alpha wrapper on click color picker button
				                $container.on('click', '.wp-color-result', function() {
				                  $alpha_wrap.toggle();
				                });

				                // hide alpha wrapper on click body
				                $('body').on( 'click.wpcolorpicker', function() {
				                  $alpha_wrap.hide();
				                });

			              	},

				            // slider: options
				            value: picker.alpha,
				            step: 1,
				            min: 1,
				            max: 100

				        });
          			}

        		});

      		} else {

        		// wpColorPicker default picker
		        $this.wpColorPicker({
		          	change: function() {
		          		setTimeout( bb_typo_build_css, 100);
		            	$this.trigger('keyup');
		          	}
		        });

      		}

    	});

  	};

	$('document').ready(function(){
		$('.hide-color-picker.tech888f-colorpicker-opacity').opacity_wpColorPicker();
		$('.res-color-picker').wpColorPicker({
			change: function(event, ui){
				setTimeout( bb_typo_build_css, 100);
			}
		});
		$('.res-title-tab').on('click',function(event){
			event.preventDefault();
			var res_id = $(this).attr('href');
			$(this).parents('ul').find('.res-title-tab').removeClass('active');
			$(this).addClass('active');
			$(this).parents('.tech888f-typography').find('.block-wrap-content').fadeOut();
			$(this).parents('.tech888f-typography').find('.block-wrap-content[data-res="'+res_id+'"]').fadeIn();
		})
		$('.tech888f-typography .iris-palette,.wp-picker-clear').on('click', function(){
			setTimeout( bb_typo_build_css, 100);
		});

		$('.tech888f-typography').on('keydown' , 'input', function(){
			setTimeout( bb_typo_build_css, 100);
		});
		
		$('.tech888f-typography').on('change' , 'select', function(){
			setTimeout( bb_typo_build_css, 100);
		});

		bb_typo_init();
		
		$('.bbbtn-typo-uploadimage').on('click', function(){
			event.preventDefault();
			
			var frame,
			_self = $(this);
			
			// If the media frame already exists, reopen it.
			if ( frame ) {
			  frame.open();
			  return;
			}

			// Create a new media frame
			frame = wp.media({
			  title: 'Choose icon image',
			  button: {
				text: 'Use this image'
			  },
			  multiple: false  // Set to true to allow multiple files to be selected
			});


			// When an image is selected in the media frame...
			frame.on( 'select', function() {

			  // Get media attachment details from the frame state
			  var attachment = frame.state().get('selection').first().toJSON();
			  // Send the attachment id to our hidden input
			  _self.closest('.row').find('.res-typo-background-image').val( attachment.url );
			  setTimeout( bb_typo_build_css, 100);

			});

			// Finally, open the modal on click
			frame.open();
		});

	});
}(window.jQuery));
