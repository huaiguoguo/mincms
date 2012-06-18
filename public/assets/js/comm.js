$(function(){
	if($(".cycle").length > 0){
		$('.cycle').cycle({
	        fx:      'fadeZoom', 
	        pager:   '#cycle_pager' 
	    });
   }
	$('.select_all').click(function(){
		var rel = $(this).attr('rel');
		if($(this).attr('checked')){
			$('input').each(function(){
				if($(this).attr('rel')==rel){
					$(this).attr('checked','checked');
				} 
			});
		}else{
			$('input').each(function(){
				if($(this).attr('rel')==rel){
					$(this).removeAttr('checked');
				} 
			});
		} 
	});
	
});