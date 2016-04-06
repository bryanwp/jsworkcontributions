 /*
 * notif.js: a jQuery plugin, version: 0.0.1 (2016)
 * @requires jQuery v1.2.3 or later
 * by: sheldon alag
 */
(function($) {
    
    $.fn.checkElementCount = function(){
    	var arr = this.map(function(){ return true;}).get();
    	return arr.length;
    }

    $.fn.getElementArr = function(){
    	var title, content, date;
    	var notes = [];
    	var arr = this.map(function(){
    		var el = $(this);
    		var date = el.find('#n-date').val();

	    	if ( date.length < 1 ) {
	    		date = $.getCurrentDate();
	    	}
	    	notes = { 
	    			title: el.find('#n-title').val(), 
	    			content: el.find('#n-content').val(),
	    			date: date
	    		};
    	 	return notes;
    	}).get();

    	return arr;
    }

    $.fn.hasScrollBar = function() {
	    var scrollHeight = this.get(0).scrollHeight;
	    if ( scrollHeight > this.height() ) {
	    	//scrollHeight = scrollHeight + 10;
	        $(this).css('height', scrollHeight );
	        return;
	    }  
  	}
  	
  	$.getCurrentDate = function(){
      var a = new Date( $.now() );
      var months = ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var hour = a.getHours();
      var min = a.getMinutes();
      var sec = a.getSeconds();
      var time = month + ' ' + date + ', ' + year;
      return time;
   }

   $.getCommentsUser = function(){
      var action   = 'getComments-ajax',
          usercode = '1-0',
          comments = '',
          id       = $('#post_id').val();

      $.ajax({
        url: plugins_ajax.ajaxUrl, 
        method: 'POST',
        data:{
          action: action,
          id: id,
          code: usercode
        },
        dataType: 'json',
        success: function( respones ){
          comments = respones.data;
          $('#reply-list').append(comments);
        },
        error: function(e){
          console.log(e.responseText);
        }

      });
   }
  $.getCommentsAdmin = function(){
      var action   = 'getComments-ajax',
          usercode = '0-1',
          comments = '',
          id       = $('#post_id').val();

      $.ajax({
        url: plugins_ajax.ajaxUrl, 
        method: 'POST',
        data:{
          action: action,
          id: id,
          code: usercode
        },
        dataType: 'json',
        success: function( respones ){
          comments = respones.data;
          $('#reply-list').append(comments);
        },
        error: function(e){
          console.log(e.responseText);
        }

      });
   }

})(jQuery);