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
	        return scrollHeight;
	    }  
  	}
  	
  	$.getCurrentDate = function( $req ){
      var a = new Date( $.now() );
      var months = ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
      var year  = a.getFullYear();
      var month = months[a.getMonth()];
      var day  = check( a.getDate() );
      var hour = check( a.getHours() );
      var min  = check( a.getMinutes() );
      var sec  = check( a.getSeconds() );
      var date = month + ' ' + day + ', ' + year;
      var date_time = month + ' ' + day + ', ' + year + ' ' + hour +':'+ min +':'+ sec;
      if ( $req == '' ) {
        return date;
      } else {
        return date_time;
      }

      function check( val ){
        if ( val.length == 1 ) {
          val = '0' + val;
          return val;
        }
      }
      
   }
   

   $.getCommentsUser = function( $user ){
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
          code: usercode,
          user: $user
        },
        dataType: 'json',
        success: function( respones ){
          comments = respones.data;
          $('.reply-list').append(comments);
          $(".comment-list").scrollTop($(".comment-list")[0].scrollHeight);
        },
        error: function(e){
          console.log(e.responseText);
        }

      });
   }
  $.getCommentsAdmin = function( $user ){
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
          code: usercode,
          user: $user
        },
        dataType: 'json',
        success: function( respones ){
          comments = respones.data;
          if ( $user == 'notification_admin_user' ) {
              $('.ctab-content').find('.reply-list').append(comments);
          } else if ( $user == 'notification_admin_supplier' ) {
              $('.stab-content').find('.reply-list').append(comments);
          }
          if(typeof(variable) != "undefined" && variable !== null) {
            $(".comment-list").scrollTop($(".comment-list")[0].scrollHeight);
          }
        },
        error: function(e){
          console.log(e.responseText);
        }

      });
   }

  $.saveArtWorkAdmin = function() {
    var parent = $('#admin-artwork-form');
    var post_id = parent.find('input[name=post-id]').val();
    var img_arr = {};
    var count = 1;
    parent.find('.attachment_id').map(function(){
      img_arr[count] = $(this).val();
      count++;
    }).get();
    //console.log(img_arr);
    var saveto = 'admin_artwork';
    $.ajax({
      url: plugins_ajax.ajaxUrl,
      method: 'POST',
      data:{
        action: 'accept-artwork-ajax',
        post_id: post_id,
        meta_key: saveto,
        img_arr: img_arr
      },
      success: function( respones ){
        console.log( respones.data );
        var msg = $.getCurrentDate('date_time') +' - New Customer Image/Artwork Added by - ';
        $.send_log_changes( msg );
      }
    });
  }

  $.saveArtWorkSupplier = function() {
    var parent = $('#supplier-artwork');
    var post_id = parent.find('input[name=post-id]').val();
    var img_arr = {};
    var count = 1;
    parent.find('.attachment_id').map(function(){
      img_arr[count] = $(this).val();
      count++;
    }).get();
    //console.log(img_arr);
    var saveto = 'supplier_artwork';
    $.ajax({
      url: plugins_ajax.ajaxUrl,
      method: 'POST',
      data:{
        action: 'accept-artwork-ajax',
        post_id: post_id,
        meta_key: saveto,
        img_arr: img_arr
      },
      success: function( respones ){
        console.log( respones.data );
        var msg = $.getCurrentDate('date_time') +' - New Supplier Image/Artwork Added by - ';
        $.send_log_changes( msg );
      }
    });
  }

  $.send_log_changes = function( $msg ) {
    
    var msgs = $msg;
    var action = 'action-log-ajax';
    // var action = plugins_ajax.ajaxUrl + '?action=action-log-ajax';
    console.log(msgs);
    
    $.post({
      url: plugins_ajax.ajaxUrl,
      method: 'POST',
      data: {
        action: action,
        msg: msgs
      },
      dataType: 'json',
      success: function( respones ) {
        console.log(respones);
      }

    });

  // $.post(
  //     action, 
  //    {
  //       filename: 'log.txt',
  //       msg: msgs
  //    });
  //  var data = {
  //     action : 'action-log-ajax',
  //     msg: msgs   
  //   };

  //   $.post( plugins_ajax.ajax_url, data, function( respones ) {
  //     console.log( respones.data );
  //   });
 }
 

})(jQuery);