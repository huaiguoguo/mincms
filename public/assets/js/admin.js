$(function(){ 
   $('#admin_controller_login input#form_username').focus();
   $(".alert-success,.alert-error").animate({opacity: 1.0}, 3000).fadeOut("slow");
   $('.click').click(function(){  
		var i = $('#'+$(this).attr('rel'));  
		if(i.css('display')=='block'){
			i.hide();
		}
		else{
			i.show();
		} 
	}); 
   $('.roles').click(function(){
   	   group_role($(this));
   });
   $('#admin_controller_group .first span').click(function(){
   	   group_role($(this).find('input'));
   });
   
   $('#admin_controller_group .next span').click(function(){
   	   var obj = $(this).find('input'); 
   	   var attr = obj.attr('checked');
   	   if (typeof attr !== 'undefined' && attr !== false) { 
		    obj.removeAttr('checked');
	   }
   	   else{  
		   obj.attr('checked','checked');
		}
   });
	function group_role(obj){
		var i = obj.val();
		var attr = obj.attr('checked');
		if (typeof attr !== 'undefined' && attr !== false) { 
		    $('.roles_'+i).removeAttr('checked');
		    obj.removeAttr('checked');
	   }
   	   else{   
		   $('.roles_'+i).attr('checked','checked');
		   obj.attr('checked','checked');
		} 
	}
	
	$('.smtp').change(function(){ 
		if($(this).val()=='smtp'){
			$('#smtp').show();
		}else{
			$('#smtp').hide();
		}
	});
	$('.cck_add').click(function(){
		var html = '';  
		var a = $('.rule :selected').text();
		var b = $('input.value').val();
		
		if($('.rule  :selected').text()!='' && $('input.value').val()!=''){ 
			$('#cck').find('tr:last').after($('.cck_add_list').clone().removeClass('cck_add_list').show());
			var last = $('#cck').find('tr:last');
			last.find('input.a').val(a);
			last.find('.b').val(b); 
			$('input.value').val(null);
			$('.rule  :selected').removeAttr('selected');
		}
		return false;
	
	});
	$('.cck_remove').bind('click',function(){
		$(this).parent().parent('tr').remove();
		return false;
	});
	
});