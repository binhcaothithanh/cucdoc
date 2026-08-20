$(document).ready(function() {
	last_index = $('.list_tt li').length;
	index = 1;
	$('.np_tt').click(function(){
		if($(this).hasClass('next_slide_tt')){
			index = (index < last_index) ? index = index+1 : index=1;		
	
		}else{
			index = (index > 1) ? index = index-1 : index=last_index;
		}
		$('.list_tt li').hide();
		$('.list_tt li:nth-child('+index+')').fadeIn();
		$('.info_tt li').hide();
		$('.info_tt li:nth-child('+index+')').fadeIn();
		$('.rib span').removeClass('active');
		$('.rib span:nth-child('+index+')').addClass('active');
	});

	// #slider .btn_slider.next
	var speed = 3000;
	var run = setInterval('rotate()', speed);
	var item_width = $('#slider li').outerWidth();
	var left_value = -item_width;
	var index = 1;
	var number = 0;
	$('#slider li').each(function() {
        var temp = $('.do.' + $(this).parent().attr('id'));
        var data = $(this).attr('date');
        number++;
        if(number == 1){
        	$(temp).append('<span class="active" date=\''+data+'\'>'+number+'</span>');
        	$('.date').html(data);
        }else{
        	$(temp).append('<span date=\''+data+'\'>'+number+'</span>');
        }
        
    });

	$('#slider li:first').before($('#slider li:last')); 
	$('#slider ul').css({'left' : left_value});
	$('.btn_slider').click(function() {
		var parent = $(this).attr('rel');
		if($(this).hasClass('next')){			
			var left_indent = parseInt($('#'+parent).css('left')) - item_width;
			$('#'+parent+':not(:animated)').animate({'left' : left_indent}, 300, function () {
	           	$('#'+parent+' li:last').after($('#'+parent+' li:first'));    	
				$('#'+parent).css({'left' : left_value});			
			});
			index++;
			
		}else{
			var left_indent = parseInt($('#'+parent).css('left')) + item_width;
			$('#'+parent+':not(:animated)').animate({'left' : left_indent}, 300, function () {
	           	$('#'+parent+' li:first').before($('#'+parent+' li:last'));    	
				$('#'+parent).css({'left' : left_value});			
			});
			index--;
			
		}

		if(index > number ){index = 1;};
		if(index < 1 ){index = number;};
		$('.'+parent+' span').removeClass('active');
		$('.'+parent+' span:nth-child('+index+')').addClass('active');
		var data = $('.'+parent+' span:nth-child('+index+')').attr('date');
		$('.date').html(data);
	});
	$('#slider').hover(function() {
			clearInterval(run);
		}, 
		function() {
			run = setInterval('rotate()', speed);	
		}
	);
	$('.sTop').click(function(){
		$("html, body").stop().animate({scrollTop:0}, '500', 'swing');
	})
});
function rotate() {
	$('.btn_slider.next').click();
} 