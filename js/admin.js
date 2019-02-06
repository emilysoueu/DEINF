jQuery(document).ready(function($){

/* ------------------------------------------------------------------------ */
/*  section accordion         	  								  	    */
/* ------------------------------------------------------------------------ */

$('.section-accordion').click(function(){

	var accordion_item = $(this).find('.heading span').attr('id');
	if( $(this).hasClass('close')){
		$(this).removeClass('close').addClass('open');
		$(this).find('.heading span.fa').removeClass('fa-plus').addClass('fa-minus');
	}else{
		$(this).removeClass('open').addClass('close'); 
		$(this).find('.heading span.fa').removeClass('fa-minus').addClass('fa-plus');
	}

	$(this).parent('.section').find('.section_wrapper').slideToggle();

});

// select section content model

$('.section-content-model').each(function(){

   var model          = $(this).find('input[type="radio"]:checked').val();
   var content_mode_0 = $(this).parents('.home-section').find('.content-model-0');
   var content_mode_1 = $(this).parents('.home-section').find('.content-model-1');

   if( model == 0 ){
		content_mode_0.show();
		content_mode_1.hide();
	}else{
	content_mode_0.hide();
	content_mode_1.show();
	}

});

	$( '.section-content-model input[type="radio"]' ).change(function() {

	var model          = $(this).val();
	var content_mode_0 = $(this).parents('.home-section').find('.content-model-0');
	var content_mode_1 = $(this).parents('.home-section').find('.content-model-1');

	if( model == 0 ){
		content_mode_0.show();
		content_mode_1.hide();
	}else{
		content_mode_0.hide();
		content_mode_1.show();
	}
	});
	$('.section_wrapper').each(function(){
		$(this).children(".content-model-0:first").addClass('model-item-first');
		$(this).children(".content-model-0:last").addClass('model-item-last');
	});

$('.onetone-import-demos .button-import-demo').click(function(){
			$('.importer-notice').show();
	});

// dismiss notice
$(document).on('click','.options-to-customise .notice-dismiss',function(){
	$.ajax({type: "POST",url: onetone_params.ajaxurl,dataType: "html",data: { action: "onetone_close_notice"}});
});

// add section
$(document).on('click','#add-section',function(){
	$('.get-pro-version').remove();
	$(this).after('<span class="get-pro-version" style="padding-left:20px;color:red;">Get the <a href="https://www.mageewp.com/onetone-theme.html" target="_blank">Pro version</a> of Onetone to acquire this feature.</span>');
	});

});