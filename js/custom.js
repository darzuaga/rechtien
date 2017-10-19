/*
Template: Car Dealer - Automotive Solution, Car Dealership Responsive WordPress Theme
Author: potenzaglobalsolutions.com
Design and Developed by: potenzaglobalsolutions.com
*/

/*================================================
[  Table of contents  ]
================================================
:: window load functions
	:: Preloader
	:: owl-carousel
:: Menu Height
:: Document ready functions
	:: Search
	:: login 
	:: Tooltip
	:: Masonry
	:: Magnific popup
	:: YouTube
	:: Vimeo
	:: Photoswipe popup
	:: Accordion
	:: Categories Show/Hide Sub Items
	:: Audio Video
	:: Newsletter mailchimp
	:: Car Inquiry Form [ CarDetail Page ]
	:: Make An Offer Form [ CarDetail Page ]
	:: Schedule Test Drive Form [ CarDetail Page ]
	:: Car EMAIL TO A FRIEND Form [ CarDetail Page ]
	:: Financial Form [ CarDetail Page ]
	:: Social share
	:: Coming soon
	:: Slick slider
	:: Tabs
	:: Space Shortcode
	:: Newsletter shortcode
	:: Multi tab shortcode
	:: Code For Cart Toggle	
	:: Counter
	:: Compare
	:: For header background video [ theme options ]
	:: mega menu
	:: back-to-top
:: Functions
	:: counter
	:: placeholder
	:: Goole captcha inti
	:: Visual Composer RTL Resize Issue
	:: Compare
	:: YouTube, Vimeo
======================================
[ End table content ]
======================================*/

jQuery(window).load(function() {
    /*********************
	:: Preloader
	*********************/
	if( typeof cardealer_options_js == 'undefined' ) {
		jQuery("#load").fadeOut();
		jQuery('#loading').delay(0).fadeOut('slow');
	}
	
	/*************************
	:: owl-carousel
	*************************/
	jQuery('.owl-carousel-6').owlCarousel({
	   items:1,
	   loop:true,
	   autoplay:true,
	   autoplayTimeout:2000,
	   smartSpeed:1000,
	   autoplayHoverPause:true,
	   dots:false,
	   nav:true,
	   navText:[  
            "<i class='fa fa-angle-left fa-2x'></i>",
			"<i class='fa fa-angle-right fa-2x'></i>"
       ]
	});
	jQuery('.owl-carousel-7').owlCarousel({
		items:3,
		margin:5,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			768:{
				items:3
			},
			1300:{
				items:3
			}
		},
		autoplay:true,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
		dots:false,
		autoHeight:true,
		nav:true,
		navText:[  
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>"
		]
    });
    
    owl = jQuery(".owl-carousel");
    owl.each(function () {
        var $this = jQuery(this),
		$items = ($this.data('items')) ? $this.data('items') : 1,
		$loop = ($this.data('loop')) ? $this.data('loop') : false,
		$navdots = ($this.data('nav-dots')) ? $this.data('nav-dots') : false,
		$navarrow = ($this.data('nav-arrow')) ? $this.data('nav-arrow') : false,
		$autoplay = ($this.attr('data-autoplay')) ? $this.data('autoplay') : true,
		$space = ($this.attr('data-space')) ? $this.data('space') : 30;     
		jQuery(this).owlCarousel({
			loop: $loop,
			items: $items,
			responsive: {
				0:{items: $this.data('xx-items') ? $this.data('xx-items') : 1},
				480:{items: $this.data('xs-items') ? $this.data('xs-items') : 1},
				768:{items: $this.data('sm-items') ? $this.data('sm-items') : 2},
				980:{items: $this.data('md-items') ? $this.data('md-items') : 3},
				1200:{items: $items}
			},
			dots: $navdots,
			margin:$space,
			nav: $navarrow,
			navText:["<i class='fa fa-angle-left fa-2x'></i>","<i class='fa fa-angle-right fa-2x'></i>"],
			autoplay: $autoplay,
			autoplayHoverPause: true,
		}); 
           
    });
    // set same height for every car-carousel items
    var setMinHeight = function(minheight) {
        jQuery('.owl-carousel').each(function(i,e){
            var oldminheight = minheight;
            jQuery(e).find('.item').each(function(i,e){
                minheight = jQuery(e).height() > minheight ? jQuery(e).height() : minheight;    
            });
            
            jQuery(e).find('.car-item').css("min-height",minheight + "px");
            minheight = oldminheight;
        });
    };
    setMinHeight(0);
});

/*******************
:: Menu Height
*******************/
var oldheight = jQuery('.menu-inner').outerHeight();
jQuery(window).bind("load resize",function(e){
	    
    if(jQuery('#header').hasClass('logo-center')){        
    	var logoHeight = jQuery('.menu-inner').outerHeight();
        jQuery('.mega-menu .menu-inner').css({
    		 'height' : logoHeight,         
    	});
    } else {
        var logoHeight = jQuery('.menu-logo').outerHeight(); 
    	jQuery('.mega-menu .menu-inner').css({
    		 'height' : logoHeight,         
    	});    
    }
    
});
jQuery(document).scroll(function() {     
    if(jQuery(this).scrollTop() > 50){         
        var logoHeight = jQuery('.menu-logo').outerHeight();            
        jQuery('.mega-menu .menu-inner').css({
    		 'height' : logoHeight,         
    	});
    } else {
        if(jQuery('#header').hasClass('logo-center')){                    
            jQuery('.mega-menu .menu-inner').css({
        		 'height' : oldheight,         
        	});
        }
    }    
});

jQuery(document).ready(function($) {
	
	/**************************************
	:: Search cars with autocomplte 
	***************************************/
	// search-3
	if (jQuery('.search').size() > 0) {
		jQuery('.search-btn').on("click", function () {
			jQuery('.search').toggleClass("search-open");            
            jQuery('.cardealer-auto-compalte ul').empty();
            jQuery('#menu-s').val('');			
            return false;
		});
        $('.search-box .fa-search').on('click',function(){
            $('.searchform').submit();    
        });		
	}    
    if(document.getElementById('menu-s')||document.getElementById('mobile-menu-s')){    
        jQuery( '#menu-s,#mobile-menu-s' ).autocomplete({
            search: function(event, ui) {
                jQuery('.cardealer-auto-compalte ul').empty();
            },
            source: function( request, response ) {
    			jQuery.ajax({
    				url: cardealer_js.ajaxurl,
    				type: 'POST',
    				dataType: "json",
    				data: {'action': 'pgs_auto_complate_search','search': request.term},
					beforeSend: function(){
						jQuery('#menu-searchform').find('i.fa-search').after('<span class="cd-loader"></span>');
						jQuery('#menu-searchform').find('i.fa-search').hide();
					},
    				success: function( resp ) {					
    					response( jQuery.map( resp, function( result ) {
    						var return_data = {
    							status: result.status,
    							image: result.image,
    							title: result.title,
    							link_url: result.link_url,
    							msg: result.msg
    						};						
    						return return_data;
    					})); 
    				}
    			}).done( function(){
					jQuery('#menu-searchform').find('i.fa-search').show();
					jQuery('#menu-searchform').find('span.cd-loader').remove();
				});
            },
            minLength: 2,            
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {		
    		var html = '';
            if(item.status){
                html += '<a href="'+item.link_url+'">';
                html += '<div class="search-item-container">';
                if(item.image){
                    html += item.image;    
                }                                
                html += item.title;            
                html += '</div>';
                html += '</a>';
            } else {
                html += item.msg    
            }                
            return jQuery( "<li></li>" )
                .data( "ui-autocomplete-item", item )
                .append(html)
                .appendTo(jQuery('.cardealer-auto-compalte ul'));
       };
   }
   
   if(document.getElementById('s')){
       jQuery( '#s' ).autocomplete({
            search: function(event, ui) {
                jQuery('.cardealer-auto-compalte-default ul').empty();
            },
            source: function( request, response ) {
    			jQuery.ajax({
    				url: cardealer_js.ajaxurl,
    				type: 'POST',
    				dataType: "json",
    				data: {'action': 'pgs_auto_complate_search','search': request.term},
					beforeSend: function(){
						jQuery( '#s' ).after('<span class="cd-loader"></span>');
					},
    				success: function( resp ) {					
    					response( jQuery.map( resp, function( result ) {
    						var return_data = {
    							status: result.status,
    							image: result.image,
    							title: result.title,
    							link_url: result.link_url,
    							msg: result.msg
    						};						
    						return return_data;
    					})); 
    				}
    			}).done( function(){
					jQuery( '#s' ).parent().find('span.cd-loader').remove();
				});;
            },
            minLength: 2,            
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {		
    		var html = '';
            if(item.status){
                html += '<a href="'+item.link_url+'">';
                html += '<div class="search-item-container">';
                if(item.image){
                    html += item.image;    
                }                                
                html += item.title;            
                html += '</div>';
                html += '</a>';
            } else {
                html += item.msg    
            }                
            return jQuery( "<li></li>" )
                .data( "ui-autocomplete-item", item )
                .append(html)
                .appendTo(jQuery('.cardealer-auto-compalte-default ul'));
       };
    }
   
	/*******************
	:: login  
	********************/
	var all_expander =jQuery('.topbar-widget-expander');
	// Hide all widgets by default
	all_expander.hide();
	jQuery('.topbar-widget-link').each( function( i, ele ) {
		var widget_wrapper =jQuery(this).closest('.topbar-widget-wrapper');
		var current_expander =jQuery(widget_wrapper).find('.topbar-widget-expander');
		jQuery(this).click(function(e) {
			e.preventDefault();
			// Check if widget is hidden
			if(jQuery(current_expander).is(':hidden') ){
				// Hide all opened widgets
				all_expander.hide();
				// And, open current widget
				current_expander.show();
			}else{
				current_expander.hide();
			}
		});
	});
	// All open topbar widgets, if clicked anywhere else. xxxxx
	jQuery(document).click(function(e) {
		if( !jQuery(e.target).is('.topbar-widget-link, .topbar-widget-expander, .topbar-widget-expander *') ) {
			all_expander.hide();
		}
	});
	
	/*************************
	:: tooltip
	*************************/
	jQuery('[data-toggle="tooltip"]').tooltip();
	/******************
	:: Masonry
	******************/
	if(jQuery(".isotope-2").length != 0) {
		jQuery(window).on("load resize",function(e){
			var jQuerycontainer =jQuery('.masonry-main .isotope-2'),
			colWidth = function () {
				var w =jQuerycontainer.width(),
				columnNum = 1,
				columnWidth = 0;
				return columnWidth;
			},
			isotope = function () {
				jQuerycontainer.isotope({
					resizable: true,
					itemSelector: '.masonry-main .masonry-item',
					masonry: {
						columnWidth: colWidth(),
						gutterWidth: 10
					}
				});
			};
			isotope();
			// bind filter button click
			jQuery('.masonry-main .isotope-filters-2').on( 'click', 'button', function() {
				var filterValue =jQuery( this ).attr('data-filter');
				jQuerycontainer.isotope({ filter: filterValue});
			});
			// change active class on buttons
			jQuery('.masonry-main .isotope-filters-2').each( function( i, buttonGroup ) {
				var jQuerybuttonGroup =jQuery( buttonGroup );
				jQuerybuttonGroup.on( 'click', 'button', function() {
					jQuerybuttonGroup.find('.active').removeClass('active');
					jQuery( this ).addClass('active');
				});
			});
		});
	}	
	/******************
	:: Magnific popup
	******************/
	jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 300,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});
	
	/**************
	:: youtube
	***************/
	jQuery.extend(true,jQuery.magnificPopup.defaults, {
		iframe: {
			patterns: {
				youtube: {
					index: 'youtube.com/',
					id: 'v=',
					src: 'https://www.youtube.com/embed/%id%?autoplay=1'
				}
			}
		}
	});
	
	/**************
	:: Vimeo
	***************/
	jQuery.extend(true,jQuery.magnificPopup.defaults, {
		iframe: {
			patterns: {
				vimeo: {
					index: 'vimeo.com/',
					id: '/',
					src: 'https://player.vimeo.com/video/%id%?autoplay=1'
				},
			}
		}
	});
	
	/*************************************************
	:: Photoswipe popup gallery for car listing page
	**************************************************/
	jQuery( document ).on("click", ".psimages", function() {
		var pswpElement = document.querySelectorAll('.pswp')[0];
		var items = [];
		var imgsrc;
		var imgdata;
		var imgurl;

		imgsrc = jQuery(this).closest('.pssrcset').find('.psimages').data('image');	
		imgurl=imgsrc.split(',');
		
		for(var i=0;i<imgurl.length;i++){
			var item = {
				src : imgurl[i],
				w: 1024,
				h: 683
			}
			items.push(item);
		};
		var options = {       
			history: false,
			focus: false,
			showAnimationDuration: 0,
			hideAnimationDuration: 0    
		};
		var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
		gallery.init();
	});

	/*************************************************
	:: Photoswipe popup gallery for car detail page
	**************************************************/
	jQuery( document ).on("click", ".ps-car-listing", function() {
		var pswpElement = document.querySelectorAll('.pswp')[0];
		var items = [];
		var newitems = [];
		var psitems = [];
		var curid = this.id;
		
		jQuery( "figure" ).each(function() {
			if(!jQuery(this).closest('.slick-cloned').length){
				url = jQuery(this).find('.ps-car-listing').attr('src');
				id = jQuery(this).find('.ps-car-listing').attr('id');
				var item = {
					src : url,
					id  : id,
					w: 1051,
					h: 662
				}
				items.push(item);
			}	
		});
		items.forEach(function(element, i) {
			if(curid == element.id){
				newitems = items.concat(items.splice(0,i));
			}
		});
		items.forEach( function (i) { 
			if(newitems.indexOf(i) < 0) {
				newitems.push(i);
			}
		});
		var options = {       
			history: false,
			focus: false,
			showAnimationDuration: 0,
			hideAnimationDuration: 0    
		};
		var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, newitems, options);
		gallery.init();
	}); 
	
	/*************************
	:: Accordion
	*************************/
	var allPanels =jQuery(".accordion > .accordion-content").hide();
	allPanels.first().slideDown("easeOutExpo");
	
	jQuery(".accordion > .accordion-title > a").first().addClass("active");
	jQuery(".accordion > .accordion-title > a").click(function(){
		var current =jQuery(this).parent().next(".accordion-content");
		jQuery(".accordion > .accordion-title > a").removeClass("active");
		jQuery(this).addClass("active");
		allPanels.not(current).slideUp("easeInExpo");
		jQuery(this).parent().next().slideDown("easeOutExpo");
		return false;
	});
	
	/**********************************
	:: Categories Show/Hide Sub Items
	**********************************/
	$('.cat-menu .sub-menu').hide();
	$(".cat-menu .category-open-close-icon").click(function(e){
		e.preventDefault();
		$(this).closest('li').children("ul.cat-sub-menu").toggle('slow');
	})
	
	/*************************
	:: Audio Video
	*************************/
	if(jQuery(".audio-video").length != 0) {
		jQuery('audio,video').mediaelementplayer();
	}
	
	/************************
	:: Newsletter mailchimp
	************************/
	jQuery('.newsletter-mailchimp').click(function(){		
		var form_id=jQuery(this).attr('data-form-id');
		var mailchimp_nonce=jQuery('form#'+form_id+' .news-nonce').val();				
		var news_letter_email=jQuery('form#'+form_id+' .newsletter-email').val();		
		jQuery.ajax({
			url: cardealer_js.ajaxurl,
			data:'action=mailchimp_singup&mailchimp_nonce='+mailchimp_nonce+'&news_letter_email='+news_letter_email,
			beforeSend: function() {    
                jQuery('.spinimg-'+form_id).html('<span class="cd-loader"></span>');
            },
			success: function(msg){
				jQuery('form#'+form_id+' .newsletter-msg').show();
				jQuery('form#'+form_id+' .newsletter-msg').removeClass('error_msg');
				jQuery('form#'+form_id+' .newsletter-msg').html(msg);
				jQuery('#process').css('display','none');
				jQuery('form#'+form_id+' .news_letter_name').val('');
				jQuery('form#'+form_id+' .newsletter-email').val('');
				jQuery('.spinimg-'+form_id).html('');
			},
			error: function(msg){
				jQuery('form#'+form_id+' .newsletter-msg').addClass('error_msg');
				jQuery('form#'+form_id+' .newsletter-msg').html(msg);
				jQuery('form#'+form_id+' .newsletter-msg').show();
				jQuery('#process').css('display','none');				
			}
		});
		return false;
	});
    $(".dealer-form-btn").on('click',function(){
		$(".reset_css input").css({"border":"none"});
		$(".reset_css textarea").css({"border":"none"});
	});
	
	/***************************************
	:: Car Inquiry Form [ CarDetail Page ]
    ***************************************/
	jQuery(document).on('click','#submit_request, #submit-inquiry',function(e){	
		e.preventDefault();
		var formId = jQuery(this).parents("form").attr('id');
		jQuery('form#'+formId).find('input').css({"border":"none"});
        var textArray = [
        	"first_name",            		
        	"last_name",
			"email",
            "address",
            "state",
            "zip",
        ];
		
		// ENABLE / DISABLE REQUIRED ON PHONE / EMAIL BASED ON PREFERED CONTACT SELECTED
        var sts = do_validate_field(textArray,formId);        
        if(!sts){
            jQuery.ajax({
    			url: cardealer_js.ajaxurl,
                method: "POST",
    			dataType:'json',
                data: jQuery('form#'+formId).serialize(),    			
                beforeSend: function() {    
    				jQuery('.spinimg').html('<span class="cd-loader"></span>');
    			},
    			success: function(responseObj){    				 
    				jQuery('form#'+formId+' .inquiry-msg').show();    				    					
					jQuery('form#'+formId+' .inquiry-msg').html(responseObj.msg).delay(5000).fadeOut('slow');
					if(responseObj.status==1)
						jQuery('form#'+formId).find("input[type=text], textarea, radio").val("");
					jQuery('.check').attr('checked',true);
					if (typeof grecaptcha !== "undefined"){
						grecaptcha.reset(recaptcha1);
						grecaptcha.reset(recaptcha6);
					}
    				jQuery('.spinimg').html('');				
    			}        
    		});    
        }        
	});

	/*******************************************
    :: Make An Offer Form [ CarDetail Page ]
    *******************************************/
	jQuery('#make_an_offer_test_request').click(function(e){ 
		e.preventDefault();
		var formId = jQuery(this).parents('form').attr('id');
		var textArray = [
        	"mao_fname",            		
        	"mao_lname",
			"mao_email",
            "mao_reques_price"
        ];
		
        var sts = do_validate_field(textArray,formId); 
		if(!sts){
			jQuery.ajax({
				url: cardealer_js.ajaxurl,
                method: "POST",
				data: jQuery('form#make_an_offer_test_form').serialize(),
				dataType:'json',
                beforeSend: function() {    
					jQuery('.make_an_offer_test_spinimg').html('<span class="cd-loader"></span>');
				},
				success: function(responseObj){					
					jQuery('form#make_an_offer_test_form .make_an_offer_test_msg').show();					
					jQuery('form#make_an_offer_test_form .make_an_offer_test_msg').html(responseObj.msg).delay(5000).fadeOut('slow');
					if(responseObj.status==1)
						jQuery('form#make_an_offer_test_form').find("input[type=text], textarea, radio").val("");
					jQuery('.check').attr('checked',true);
					if (typeof grecaptcha !== "undefined"){
						grecaptcha.reset(recaptcha2);
					}					
					jQuery('.make_an_offer_test_spinimg').html('');				
				}        
			});
		}
	});
	
	/**********************************************
    :: Schedule Test Drive Form [ CarDetail Page ]
    ***********************************************/
	if( $(".date").length != 0 ) {
        jQuery('.date').datepicker({
            dateFormat: 'mm-dd-yy'
        });
    }
	$( ".date-time" ).keydown(function(event) {
	  event.preventDefault();
	});
	
	// SHOW DATE AND TIME FIELD ONLY IF TEST DRIVE IS CHECKED
	jQuery('.radio input[name=test_drive]').click( function(){ 
		if(jQuery(this).val() == 'no')
			jQuery('.show_test_drive').css('display', 'none');
		else
			jQuery('.show_test_drive').css('display', 'block');
	});
	
	// TIME PICKER FOR SCHEDULE TIME FIELD
	jQuery('.time').timepicker({ 'timeFormat': 'H:i:s'});
	jQuery('#schedule_test_request').click(function(e){		
		e.preventDefault();
		var formId = jQuery(this).parents('form').attr('id');
		jQuery('form#'+formId).find('input').css({"border":"none"});
        var textArray = [
        	"first_name",            		
        	"last_name",
			"email",
            "address",
            "state",
            "zip",
			"preferred_contact",
			"test_drive"
        ];
		
		(jQuery('input[name=test_drive]:checked').val()=="yes") ?textArray.splice(8, 1, "date", "time"):"";			
		var sts = do_validate_field(textArray,formId);
        if(!sts){
    		jQuery.ajax({
    			url: cardealer_js.ajaxurl,
                method: "POST",
    			data: jQuery('form#schedule_test_form').serialize(),
    			dataType:'json',
                beforeSend: function() {    
    				jQuery('.schedule_test_spinimg').html('<span class="cd-loader"></span>');
    			},
    			success: function(responseObj){   
    				jQuery('form#schedule_test_form .schedule_test_msg').show();					
					jQuery('form#schedule_test_form .schedule_test_msg').html(responseObj.msg).delay(5000).fadeOut('slow');
					if(responseObj.status==1){
						jQuery('form#schedule_test_form').find("input[type=text], textarea, radio").val("");
						jQuery('.check').attr('checked',true);
					}
					if (typeof grecaptcha !== "undefined"){
						grecaptcha.reset(recaptcha3);
					}
    				jQuery('.schedule_test_spinimg').html('');				
    			}        
    		});
        }
	});
	
	/************************************************
    :: Car EMAIL TO A FRIEND Form [ CarDetail Page ]
    *************************************************/
	jQuery(document).on('click','#submit_friend_frm',function(e){	
		e.preventDefault();
		var formId = jQuery(this).parents("form").attr('id');        
        var textArray = [
        	"uname",            		
        	"email",			
            "friends_email",
            "message",            
        ];
		
        var sts = do_validate_field(textArray,formId);        
        if(!sts){
            jQuery.ajax({
    			url: cardealer_js.ajaxurl,
                method: "POST",    			
                data: jQuery('form#'+formId).serialize(),
                dataType:'json',                
    			beforeSend: function() {    
    				jQuery('.spinimg').html('<span class="cd-loader"></span>');
    			},
    			success: function(responseObj){
    			    jQuery('.spinimg').html(''); 
    				jQuery('form#'+formId+' .friend-frm-msg').show();    				    					
    				jQuery('form#'+formId+' .friend-frm-msg').html(responseObj.msg).delay(5000).fadeOut('slow');
					if(responseObj.status==1)
						jQuery('form#'+formId).find("input[type=text], textarea, radio").val("");
    				jQuery('.check').attr('checked',true);
					if (typeof grecaptcha !== "undefined"){
						grecaptcha.reset(recaptcha4);
					}
                }
    		});    
        }        
	});	
	
	/**************************************
    :: Financial Form [ CarDetail Page ]
    ***************************************/
	jQuery("#personal_application").css("display","none");
	jQuery('#joint_application').change(function() {	
		if( jQuery(this).is(':checked')) {
			jQuery("#personal_application").show();
		} else {
			jQuery("#personal_application").hide();
		}		
	});
	jQuery('#financial_form_request').click(function(e){		
		e.preventDefault();
		var formId = jQuery(this).parents('form').attr('id');
		var financial = [
        	"first_name",            		
        	"last_name",
			"street_address",
            "city",            
			"zip",
			"preferred_email_address",
			"daytime_phone_number",
			"mobile_phone_number",			
			"social_security_number",			
			"employer_name",
			"employer_phone",
			"job_title",			
			"annual_income",
			"monthly_rent",
						
        ];
		var Selectfinancial=[
			"state",
			"date_of_birth_month",
			"date_of_birth_day",
			"date_of_birth_year",
			"living_arrangements",
			"length_of_employment_year",
			"length_of_employment_month",
			"length_of_time_at_current_add_year",
			"length_of_time_at_current_add_month",
		];
		var joint=[
			"first_name_joint",
			"last_name_joint",
			"relationship_to_applicant",
			"street_address_joint",
			"city_joint",
			"zip_joint",
			"preferred_email_address_joint",
			"daytime_phone_number_joint",
			"mobile_phone_number_joint",
			"social_security_number_joint",
			"employer_name_joint",
			"employer_phone_joint",
			"job_title_joint",
			"annual_income_joint",
			"monthly_rent_joint",
		];
		
		var selectjoint=[
			"state_joint",
			"date_of_birth_month_joint",
			"date_of_birth_day_joint",
			"date_of_birth_year_joint",
			"length_of_employment_year_joint",
			"length_of_employment_month_joint",
			"living_arrangements_joint",
			"length_of_time_at_current_add_year_joint",
			"length_of_time_at_current_add_month_joint",
		];
		var SelectArray=[];
		var textArray = [];
		
		
		if(jQuery("#joint_application").is(':checked'))
			var textArray = financial.concat(joint);
		else
			textArray=financial;
		
		if(jQuery("#joint_application").is(':checked'))
			var SelectArray = Selectfinancial.concat(selectjoint);
		else
			SelectArray=Selectfinancial;
      
	    var sts = do_validate_field(textArray,formId,SelectArray); 
		if(!sts){
			jQuery.ajax({
				url: cardealer_js.ajaxurl,
                method: "POST",
				dataType:'json',
                data: jQuery('form#financial_form').serialize(),
				beforeSend: function() {    
					jQuery('.financial_form_spining').html('<span class="cd-loader"></span>');
				},
				success: function(responseObj){
					jQuery('.financial_form_spining').html('');
					jQuery('form#financial_form .financial_form_msg').show();    				    					
    				jQuery('form#financial_form .financial_form_msg').html(responseObj.msg).delay(5000).fadeOut('slow');
					if(responseObj.status==1) {
						jQuery('form#financial_form').find("input[type=text], textarea, radio").val("");
						jQuery('.check').attr('checked',true);
						jQuery('select').prop('selectedIndex',0);
						jQuery('select').niceSelect('update');
					}
					if (typeof grecaptcha !== "undefined"){
						grecaptcha.reset(recaptcha5);
					}								
				}        
			});
		}
	});
	
	/****************
	:: Social share
	*****************/
	jQuery('.twitter-share').on('click', function() {
		var $this =jQuery(this),
		$url = $this.attr('data-url'),
		$title = $this.attr('data-title');
		window.open('http://twitter.com/intent/tweet?text=' + $title + ' ' + $url, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
		return false;
	});
	jQuery('.pinterest-share').on('click', function() {
		var $this =jQuery(this),
			$url  = $this.attr('data-url'),
			$title= $this.attr('data-title'),
			$image= $this.attr('data-image');
		window.open('http://pinterest.com/pin/create/button/?url=' + $url + '&media=' + $image + '&description=' + $title, "twitterWindow", "height=320,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
		return false;
	});
	jQuery('.facebook-share').on('click', function() {
		var $url =jQuery(this).attr('data-url');
		window.open('https://www.facebook.com/sharer/sharer.php?u=' + $url, "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
		return false;
	});
	
	jQuery('.googleplus-share').on('click', function() {
		var $url =jQuery(this).attr('data-url');
		window.open('https://plus.google.com/share?url=' + $url, "googlePlusWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
		return false;
	});
	jQuery('.linkedin-share').on('click', function() {
		var $this =jQuery(this),
		$url = $this.attr('data-url'),
		$title = $this.attr('data-title'),
		$desc = $this.attr('data-desc');
		window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + $url + '&title=' + $title + '&summary=' + $desc, "linkedInWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
		return false;
	});
	
	/***************
	:: Coming Soon
	****************/
	if( $(".countdown").length != 0 ) {
		var $countdown_date = $('.countdown').data('countdown-date');		
		$('.countdown').downCount({
			date: $countdown_date,			
		}, function () {			
		});
	}	
	/*********************
	:: Slick slider
	*********************/
    if (document.getElementById('cars-image-gallery')) {
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
    		adaptiveHeight: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            focusOnSelect: true
        });
        
        $('.slider-for-full').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
    		adaptiveHeight: true,
        });
    }
	
	/**********
    :: Tabs
    ***********/
    var $tabsdata = $("#tabs li[data-tabs]"),
    $tabscontent = $(".tabcontent"),
    $tabsnav = $(".tabs li");       
    $tabsdata.on('click', function () {
		$tabsdata.removeClass('active');
		$tabscontent.hide();
		var tab = $(this).data('tabs');
		$(this).addClass('active');
		$('#' + tab).fadeIn().show();
    });
    $tabsnav.on('click', function () {
		var  cur = $tabsnav.index(this);
		var elm = $('.tabcontent:eq('+cur+')');
		elm.addClass("pulse");
		setTimeout(function() {
			elm.removeClass("pulse");
		}, 220);
    });
    $tabscontent.hide().filter(':first').show();
	
	jQuery( ".tabs_wrapper" ).each(function( index ) {
		jQuery(this).find('.tabcontent').hide().filter(':first').show();
	});
	jQuery('.tabs_wrapper li[data-tabs]').on('click', function () {
		var tabs_parent =jQuery(this).closest('.tabs_wrapper');
		jQuery(tabs_parent).find('li[data-tabs]').removeClass('active');
		jQuery(tabs_parent).find('.tabcontent').hide();
		var tab =jQuery(this).data('tabs');
		jQuery(this).addClass('active');
		jQuery('#' + tab).fadeIn().show();
	});
	jQuery(".tabs li").click(function(){
		var cur =jQuery(".tabs li").index(this);
		var elm =jQuery('.tabcontent:eq('+cur+')');
		elm.addClass("pulse");
		setTimeout(function() {
			elm.removeClass("pulse");
		}, 220);
	});
	
	/*************************
	:: Space Shortcode
	*************************/
	var stylesheet = '';
	jQuery(".cd-space").each(function(){
		var $this = jQuery(this);		
		var desktoppad = $this.attr("data-desktop");
		var tablatepad = $this.attr("data-tablet");
		var portraitpad = $this.attr("data-tablet-portrait");
		var mobilepad = $this.attr("data-mobile");
		var mobileporpad = $this.attr("data-mobile-portrait");

		var cls =  $this.attr('class').split(' ');
		var clsname = cls[cls.length-1];
		stylesheet += "." + clsname + "{ height:"+ desktoppad +"px} @media only screen and (max-width: 1200px) {." + clsname + "{ height:"+ tablatepad +"px}}@media only screen and (max-width: 992px) {." + clsname + "{ height:"+ portraitpad +"px}}@media only screen and (max-width: 767px) {." + clsname + "{ height:"+ mobilepad +"px}}@media only screen and (max-width: 479px) {." + clsname + "{ height:"+ mobileporpad +"px}}";  
	});
	jQuery("<style type='text/css'>" + stylesheet + "</style>").appendTo("head");
	
	/***********************
	:: Newsletter shortcode
	************************/
	// For select box design	
	jQuery('select').niceSelect();
	// Code for newsletter shortcode to donot submit on enter and make ajax call 
	jQuery(document).on('submit', '.news-letter-form', function( event ){
		event.preventDefault();
		jQuery('.newsletter-mailchimp').trigger('click');
	});
	
	/*********************************
	:: Multi tab shortcode 
    **********************************/
    if(jQuery(".multi-tab-isotope-filter").length != 0) {
    	jQuery(window).on("load resize",function(e){
    		var element_id = '';var car_make_slugse = "";var activeclass='';
            var jQuerycontainer = "";
            jQuery(".multi-tab-isotope-filter").each(function(){ 
                element_id = jQuery(this).attr('data-uid');            
                car_make_slugse = jQuery(this).attr('data-active');
                activeclass = '.'+car_make_slugse+'_'+element_id;            
                jQuerycontainer =jQuery('.cd-multi-tab-isotope-'+element_id),
            	colWidth = function () {
            		var w = jQuerycontainer.width(),
            		columnNum = 1,
            		columnWidth = 0;
            		return columnWidth;
            	},
            	isotope = function () {
            		jQuerycontainer.isotope({
            			filter: activeclass,
                        resizable: true,
            			itemSelector: '.grid-item',
            			masonry: {
            				columnWidth: colWidth(),
            				gutterWidth: 10
            			}
            		});
            	};
            	isotope();            
            });
            // bind filter button click
            jQuery('.multi-tab-isotope-filter').on( 'click', 'button', function() {
            	var filterValue =jQuery( this ).attr('data-filter');    	
                element_id = jQuery(this).attr('data-uid');                         
                jQuerycontainer =jQuery('.cd-multi-tab-isotope-'+element_id),
            	colWidth = function () {
            		var w = jQuerycontainer.width(),
            		columnNum = 1,
            		columnWidth = 0;
            		return columnWidth;
            	},
            	isotope = function () {
            		jQuerycontainer.isotope({
            			filter: filterValue,
                        resizable: true,
            			itemSelector: '.grid-item',
            			masonry: {
            				columnWidth: colWidth(),
            				gutterWidth: 10
            			}
            		});
            	};
            	isotope();            
                // change active class on buttons
                jQuery('.multi-tab-isotope-filter-'+element_id).each( function( i, buttonGroup ) {
                	var jQuerybuttonGroup = jQuery( buttonGroup );
                	jQuerybuttonGroup.on( 'click', 'button', function() {
                		jQuerybuttonGroup.find('.active').removeClass('active');
                		jQuery( this ).addClass('active');
                	});
                });            
            });
    	});
		
		// horizontal-multi-tabs car item height settings
		var max_height = 0;
		if( jQuery('.horizontal-tabs').length > 0 ){
			jQuery('.horizontal-tabs').each( function(){
				max_height = 0;
				jQuery(this).find('.car-item').each( function(){
					if( jQuery(this).height() >  max_height ){
						max_height = jQuery(this).height();
					}
				});
				jQuery(this).find('.car-item').css('height',max_height);
			});
		}
    }
	
	/********************************************************
	:: Code For Cart Toggle i menu for mobile device starts
	*********************************************************/
	jQuery(document).on('click', '.cart-mobile-content', function( event ) {
		event.preventDefault();
		jQuery('.widget_shopping_cart_content').toggle();
	});
	
	/*************
	:: counter
	**************/
	if(jQuery(".counter").length != 0) {
		jQuery('.counter').appear(function() {
			jQuery('.timer').each(count)
		},
		{
			offset: 500
		});
	}
	
	/*********************************
	:: Code To Add Car in Compare
	**********************************/
	var carsIdList = JSON.stringify(cookies.get('cars'));
	if (cookies.get('cars') != null && cookies.get('cars') != ''){
		jQuery('.menu-item .menu-item-compare').show();
		var carIdArray = $.parseJSON(carsIdList);
		jQuery('.menu-item .compare-details.count').html(carIdArray.length);
	}
	$(document).on("click", ".compare_pgs, .menu-item-compare", function(){
		var carListClick = 0;
		if( $(this).hasClass('compare_pgs') )  {
			var car_id = jQuery(this).data('id');
			var carIds = JSON.stringify([car_id]);
			carListClick = 1;
			$(this).find('i').removeClass('fa-exchange');
			$(this).find('i').addClass('fa-check');

			if( cookies.get('cars') ) {
				carIds = cookies.get('cars')
				if(jQuery.inArray(car_id, carIds) == -1)
					carIds[carIds.length] = car_id;
				carIds = JSON.stringify(carIds);	
			}
			destroyCookie('cars');
			cookies.set('cars', carIds);
		}
		
		var carsIdList = JSON.stringify(cookies.get('cars')); 
		jQuery.ajax({
			url: cardealer_js.ajaxurl,
			type: 'post',
			data:'action=car_compare_action&car_ids=' + carsIdList,
			beforeSend: function(){
				jQuery('body').append('<div id="comparelist" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
			},
			success: function(carData){
				var carIdArray = $.parseJSON(carsIdList);
				jQuery('.menu-item .compare-details.count').html(carIdArray.length);
				// Menu display
				if( jQuery('.menu-item-compare').is(':hidden') && carIdArray.length > 0 ) jQuery('.menu-item-compare').show();
				// product compare click
				if(carIdArray.length < 2 && carListClick == 1) return;
				// Model PopUp
				jQuery("#comparelist").html(carData);
				$('div#sortable').css('width', ($('#sortable .compare-list').length * $('.compare-list').width()) + ' !important');
				jQuery('#comparelist').modal('show');
				// For sorting feature
				if( jQuery( window ).width() > 480 ) {
					jQuery("#sortable, #sortable2").sortable();
					jQuery("#sortable, #sortable2").disableSelection();
				}
			},
			error: function(carData){
				alert('not added..');
			}
		});
	});
	
	jQuery(document).on('hidden.bs.modal', '#comparelist',function(e){
		$('.compare_pgs i.fa-spinner').parent().addClass('compared_pgs');
	});
	
	// Remove item from Compare
	$(document).on('click', '.drop_item', function(){
		var carID = $(this).data('car_id');
		var cookieArray = cookies.get('cars');
		
		// remove item from cookie
		cookieArray.splice( $.inArray( carID, cookieArray ), 1 );
		cookies.set('cars', JSON.stringify(cookieArray));
				
		// Remove element
		$('.table-scroll').find(".compare-list[data-id='" + carID + "']").remove();
		$('li').find("a[data-id='" + carID + "']").addClass('compare_pgs');
		$('li').find("a[data-id='" + carID + "']").removeClass('compared_pgs');
		$('li').find("a[data-id='" + carID + "']").find('i').addClass('fa-exchange');
		$('li').find("a[data-id='" + carID + "']").find('i').removeClass('fa-check');
		cookieArray = cookies.get('cars');
		jQuery('.menu-item .compare-details.count').html(cookieArray.length);
		if(cookieArray.length < 1){
           $('#comparelist').modal('hide');
			jQuery('.menu-item-compare').hide();
		}
        else 
           $('#sortable').css('width', (cookieArray.length * $('.compare-list').width()));
	});
	
	/***********************************************
	:: For header background video [ theme options ]
	************************************************/
	cardealer_initVideoBackgrounds();
	cardealer_initVimeoVideoBackgrounds();
	
	/*************************
	:: mega menu
	*************************/
	// Sticky Top bar setting 
	var screen_width = screen.width;
	jQuery(document).scroll(function() {
		if( cardealer_js.sticky_topbar == true ) {
			var sticky = jQuery('.topbar'),
			scroll = jQuery(window).scrollTop();
			if (scroll >= 250 && screen_width > 992){
				sticky.addClass('topbar_fixed');
			} else { 
				sticky.removeClass('topbar_fixed');
			}   
		}
	});
	
	var $mobile_sticky_status = (cardealer_js.sticky_header_mobile == true)? true: false;
	var $desktop_sticky_status = (cardealer_js.sticky_header_desktop == true)? true: false;
	jQuery('#menu-1').megaMenu({
		// DESKTOP MODE SETTINGS
		logo_align          : 'left',		// align the logo left or right. options (left) or (right)
		links_align         : 'left',      	// align the links left or right. options (left) or (right)
		socialBar_align     : 'left',     	// align the socialBar left or right. options (left) or (right)
		searchBar_align     : 'right',    	// align the search bar left or right. options (left) or (right)
		trigger             : 'hover',    	// show drop down using click or hover. options (hover) or (click)
		effect              : 'fade',     	// drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)
		effect_speed        : 400,        	// drop down show speed in milliseconds
		sibling             : true,       	// hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)
		outside_click_close : true,       	// hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)
		top_fixed           : false,      	// fixed the menu top of the screen. options (true) or (false)
		sticky_header       : $desktop_sticky_status,// menu fixed on top when scroll down down. options (true) or (false)
		sticky_header_height: 250,  		// sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
		menu_position       : 'horizontal', // change the menu position. options (horizontal), (vertical-left) or (vertical-right)
		full_width          : false,        // make menu full width. options (true) or (false)
		// MOBILE MODE SETTINGS
		mobile_settings     : {
			collapse            : true,     // collapse the menu on click. options (true) or (false)
			sibling             : true,     // hide the others showing drop downs when click on current drop down. options (true) or (false)
			scrollBar           : true,     // enable the scroll bar. options (true) or (false)
			scrollBar_height    : 400,      // scroll bar height in px value. this option works if the scrollBar option true.
			top_fixed           : false,    // fixed menu top of the screen. options (true) or (false)
			sticky_header       : $mobile_sticky_status,     // menu fixed on top when scroll down down. options (true) or (false)
			sticky_header_height: 200       // sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
		}
	});
	
	// Menu 2
	jQuery('#menu-2').megaMenu({
		sticky_header_height    : 1000,		// sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.
		// MOBILE MODE SETTINGS
		mobile_settings         : {
			collapse            : true      // collapse the menu on click. options (true) or (false)
		}
	});	
	// Vertical Left
	jQuery('#menu-3').megaMenu({
		menu_position : 'vertical-left',
		effect        : 'expand-left'
	});
	if(document.getElementById('mega-menu-wrap-primary-menu')){        
		jQuery('.menu-mobile-collapse-trigger').hide();    
	} 
	
	/*************************
	:: back-to-top
	*************************/
	var $scrolltop = jQuery('.car-top');
	jQuery(window).scroll(function(){
		if(jQuery(window).scrollTop() >= 200) {
			  $scrolltop.addClass("show");
			  $scrolltop.addClass("car-down");
		 } else {
		   $scrolltop.removeClass("show");
		   setTimeout(function(){ $scrolltop.removeClass('car-down');},300);
		}
	});
	$scrolltop.on('click', function () {
		jQuery('html,body').animate({ scrollTop: 0}, 800);
		jQuery(this).addClass("car-run");
		setTimeout(function(){ $scrolltop.removeClass('car-run');},1000);
		return false;		
	});
	
});

function chklog( message ) {
    $( "<div>" ).text( message ).prependTo( "#log" );
    $( "#log" ).scrollTop( 0 );
}

/*************************
:: counter
*************************/
function count(options) {
	var jQuerythis =jQuery(this);
	options =jQuery.extend({}, options || {},jQuerythis.data('countToOptions') || {});
	jQuerythis.countTo(options);
}

/*************************
:: placeholder
*************************/
jQuery('[placeholder]').focus(function() {
	var input =jQuery(this);
	if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	}
}).blur().parents('form').submit(function() {
	jQuery(this).find('[placeholder]').each(function() {
		var input =jQuery(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
		}
	})
});

/********************
:: Goole captcha inti
********************/
var recaptcha1;
var recaptcha2;
var recaptcha3;
var recaptcha4;
var recaptcha5;
var recaptcha6;
var doCaptcha = function() {
	if (typeof goole_captcha_api_obj !== "undefined") {
		//Render the recaptcha1 on the element with ID "recaptcha1"
		if( document.getElementById("recaptcha1") ){
			recaptcha1 = grecaptcha.render('recaptcha1', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});    
		}
		if( document.getElementById("recaptcha2") ){
			//Render the recaptcha2 on the element with ID "recaptcha2"
			recaptcha2 = grecaptcha.render('recaptcha2', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});
		}
		if( document.getElementById("recaptcha3") ){
			recaptcha3 = grecaptcha.render('recaptcha3', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});
		}
		if( document.getElementById("recaptcha4") ){
			recaptcha4 = grecaptcha.render('recaptcha4', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});
		}
		if( document.getElementById("recaptcha5") ){
			recaptcha5 = grecaptcha.render('recaptcha5', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});
		}
		if( document.getElementById("recaptcha6") ){
			// Inquiry Widget
			recaptcha6 = grecaptcha.render('recaptcha6', {
				'sitekey' : goole_captcha_api_obj.google_captcha_site_key, //Replace this with your Site key
				'theme' : 'light'
			});
		}
	}
};

/**************************************************
	Fix for Visual Composer RTL Resize Issue
	TODO: Attach this function to jQuery/Window	to make it available globally
	Check this : http://stackoverflow.com/questions/2223305/how-can-i-make-a-function-defined-in-jquery-ready-available-globally
**************************************************/
jQuery(function($){
	"use strict";
	jQuery( window ).resize(function() {
		cardealer_vc_rtl_fullwidthrow();
	});
});
function cardealer_vc_rtl_fullwidthrow() {
	if( jQuery('html').attr('dir') == 'rtl' ){
		var $elements = jQuery('[data-vc-full-width="true"]');
		jQuery.each($elements, function(key, item) {
			var $el = jQuery(this);
			$el.addClass("vc_hidden");
			var $el_full = $el.next(".vc_row-full-width");
			if ($el_full.length || ($el_full = $el.parent().next(".vc_row-full-width")), $el_full.length) {	
				var el_margin_left = parseInt($el.css("margin-left"), 10);
				var el_margin_right = parseInt($el.css("margin-right"), 10);
				var offset = 0 - $el_full.offset().left - el_margin_left;
				var width = jQuery(window).width();
				$el.css({
					left: 'auto',
					right: offset,
					width: width,
				});
			}
			$el.attr("data-vc-full-width-init", "true"), $el.removeClass("vc_hidden");
		});
	}
}
/*********************************
:: Code To Add Car in Compare
**********************************/
function destroyCookie(cname) {
	var date = new Date();
	var expires = "; expires=" + date.toGMTString();
	date.setTime(date.getTime() - (1 * 24 * 60 * 60 * 1000));
	document.cookie = cname + "=1" + expires;
}
function IsValidJSON(test) {
    try {
        var obj = JSON.parse(test);
        if (obj && typeof obj === "object" && obj !== null) {
            return true;
        }
    } catch (e) {
    }
    return false;
}

/***** Code for Youtube and Vimeo video of theme options starts *****/
function cardealer_initVimeoVideoBackgrounds(){
	jQuery(".vimeo_video_bg iframe").each(function() {		
		var iframe_src=jQuery(this).attr('src');
		var $element=jQuery('.vimeo_video_bg').parent();
		
		jQuery(this).attr('src',iframe_src+"?background=1");
		
		ResizeVideoBackground($element);
		jQuery(window).bind("resize", function() {
			ResizeVideoBackground($element)
		})
	})
}
function cardealer_initVideoBackgrounds() {	
    jQuery("[data-youtube-video-bg]").each(function() {
        var youtubeUrl, youtubeId, $element = jQuery(this);		
        $element.data("youtubeVideoBg") ? (youtubeUrl = $element.data("youtubeVideoBg"), youtubeId = ExtractYoutubeId(youtubeUrl), youtubeId && ($element.find(".youtube_video-bg").remove(), insertYoutubeVideoAsBackground_($element, youtubeId)), jQuery(window).on("grid:items:added", function(event, $grid) {			
            $element.has($grid).length && ResizeVideoBackground($element)
        })) : $element.find(".youtube_video-bg").remove()
    })
} 
function insertYoutubeVideoAsBackground_($element, youtubeId, counter) {
	if ("undefined" == typeof YT || "undefined" == typeof YT.Player) return counter = "undefined" == typeof counter ? 0 : counter, 100 < counter ? void console.warn("Too many attempts to load YouTube api") : void setTimeout(function() {
        insertYoutubeVideoAsBackground_($element, youtubeId, counter++)
    }, 100);
	
    var $container = $element.prepend('<div class="intro_header_video-bg vc_video-bg"><div class="inner"></div></div>').find(".inner");
    new YT.Player($container[0], {
        width: "100%",
        height: "100%",
        videoId: youtubeId,
        playerVars: {
            playlist: youtubeId,
            iv_load_policy: 3,
            enablejsapi: 1,
            disablekb: 1,
            autoplay: 1,
            controls: 0,
            showinfo: 0,
            rel: 0,
            loop: 1,
            wmode: "transparent"
        },
        events: {
            onReady: function(event) {
                event.target.mute().setLoop(!0)
            }
        }
    }), ResizeVideoBackground($element), jQuery(window).bind("resize", function() {
        ResizeVideoBackground($element)
    })
}
function ResizeVideoBackground($element) {
    var iframeW, iframeH, marginLeft, marginTop, containerW = $element.innerWidth(),
	containerH = $element.innerHeight(),
	ratio1 = 16,
	ratio2 = 9;
    containerW / containerH < ratio1 / ratio2 ? (iframeW = containerH * (ratio1 / ratio2), iframeH = containerH, marginLeft = -Math.round((iframeW - containerW) / 2) + "px", marginTop = -Math.round((iframeH - containerH) / 2) + "px", iframeW += "px", iframeH += "px") : (iframeW = containerW, iframeH = containerW * (ratio2 / ratio1), marginTop = -Math.round((iframeH - containerH) / 2) + "px", marginLeft = -Math.round((iframeW - containerW) / 2) + "px", iframeW += "px", iframeH += "px"), $element.find(".intro_header_video-bg iframe").css({
        maxWidth: "1000%",
        marginLeft: marginLeft,
        marginTop: marginTop,
        width: iframeW,
        height: iframeH
    })	
}
function ExtractYoutubeId(url) {
    if ("undefined" == typeof url) return !1;
    var id = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
    return null !== id && id[1]
}
function do_validate_field(textArray,formId, SelectArray){    
    validationStr = false; 
	for (var n = 0; n < textArray.length; n++) {
    	str = textArray[n];			
        
	    jQuery('form#'+formId).find('input[name='+str+']').css({"border":"none"});
        var field_val = jQuery('form#'+formId).find('input[name='+str+']').val();
        if (field_val == "") {  
			validationStr = true;                
            jQuery('form#'+formId).find('input[name='+str+']').css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
		}
        if (str == "email") {                     
            var varTestExp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var varEmail = field_val; 
            if (varEmail.search(varTestExp) == -1) {
                validationStr = true;
                jQuery('form#'+formId).find('input[name='+str+']').css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});                                                
            }
        } 
    }
	if (typeof SelectArray != 'undefined' ) {
        if(SelectArray)
    	{
    		for (var n = 0; n < SelectArray.length; n++) {
    			str = SelectArray[n];
    			jQuery('form#'+formId).find('select[name='+str+']').next('.nice-select').css({"border-color":"#e3e3e3"});
    			
    			var field_val = jQuery('form#'+formId).find('select[name='+str+']').val();
    			 if (field_val == "") {  				
    				validationStr = true;                
    				jQuery('form#'+formId).find('select[name='+str+']').next('.nice-select').css({"border-style":"solid","border-width":"1px 1px 1px 1px","border-color":"red"});
    			}	
    		}	
    	}
    }
    return validationStr;
}
/***** Code for Youtube and Vimeo video of theme options ends ******/