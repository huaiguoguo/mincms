/**
* $().input_select({});
$(function(){
	 $('#data').input_select({list:'muit',click:'click',inner:'div'}); 

});
*
* author: sun
* 2012.05.16 
* qq: 68103403
* 
*/
 
(function($){

 	$.fn.extend({  
 		input_select: function(options) {  
			var defaults = {
				list:'muit',
				click:'click',
				inner:'div',
				event: 'click'
			};
			var opts = $.extend(defaults,options); 
			var a = '.'+opts.list; 
			var b = '.'+opts.click;
			var c = '.'+opts.list+" "+opts.inner;   
			var e = opts.event;
			var obj = this; 
			$(b).bind(e,function(){   
				if($(a).css('display')=='block'){
					$(a).hide();
					$(b).removeClass('up');
					$(b).addClass('down');
				}else{
					$(a).show();
					$(b).removeClass('down');
					$(b).addClass('up');
				} 
			});
			$(c).bind('click',function(){ 
				$(obj).val($(this).html());
				$(a).hide();
				$(b).removeClass('up');
				$(b).addClass('down');
			 });

			 $(document).click(function(e) {
					var t = $(e.target);
					var v1 = a+','+b+','+c+',';
					if (!t.is(v1)) {
						$(a).hide(); 
						$(b).removeClass('up');
						$(b).addClass('down');
					}
			});

    	}
	});

})(jQuery); 