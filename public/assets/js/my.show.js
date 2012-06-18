/**
*  
$(function(){
	 $('.link').show({event:'hover'});
}); 
其中class 为link是鼠标经过的class, rel是要显示的元素id
要显示的元素class是必须的，默认为hide 以便隐藏其他的元素。

<div class='link' rel='t0'>tab0</div>
<img src='' id='t0' class='hide'/>

<div class='link' rel='t1'>tab0</div>
<img src='' id='t1' class='hide' style='display:none;'/>
*
* author: sun
* 2012.05 
* qq: 68103403
* 
*/
 
(function($){

	$.fn.extend({  
		show: function(options) { 
			var defaults = {
				active:'active',
				event: 'click', 
				hide: '.hide' 
			};
			var opts = $.extend(defaults,options);  
			var obj = this;
			var at = opts.active; 
			var e = opts.event; 
			var show = opts.show; 
			var word = opts.word;
			var hide = opts.hide;  
		 	$(this).bind(e,function(){
		 		$(hide).hide();
		 	 	var current = "#"+$(this).attr('rel'); 
		 	 	$(current).css('display','block');	
			});
			
		 
			 
			 
		}

	});

})(jQuery); 