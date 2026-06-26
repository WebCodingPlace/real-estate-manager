jQuery(document).ajaxComplete(function(event,xhr,options){
   if (xhr.responseJSON.success && undefined != xhr.responseJSON.data.thumbnail) {
   		setTimeout(function() {
   			window.top.close();
   		}, 500);
   }
});