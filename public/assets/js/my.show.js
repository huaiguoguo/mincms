/**
*  
$(function(){
	 $('.link').show({event:'hover'});
}); 
����class Ϊlink����꾭����class, rel��Ҫ��ʾ��Ԫ��id
Ҫ��ʾ��Ԫ��class�Ǳ���ģ�Ĭ��Ϊhide �Ա�����������Ԫ�ء�

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