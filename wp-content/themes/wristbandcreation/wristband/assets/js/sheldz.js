//Jquery scripts and function
jQuery(document).ready(function ($) {
   $("time.timeago").timeago();
 
   (function loop() {
   setTimeout(function () {
       $("time.timeago").timeago();
       //notif();
       loop()
     }, 10000);
   }());

   function set_scroll(){
      var req = window.location.search;
      var page = req.substring(1,12);

      if ( page == 'action=view') {
        if(typeof(variable) != "undefined" && variable !== null) {
            $(".comment-list").scrollTop($(".comment-list")[0].scrollHeight);
        }
      }
   } set_scroll();

   function view_log(){
      var req = window.location.search;
      var page = req.substring(1,12);
      var text_path = $('#log-link').val();

      if ( page == 'action=log' ) {
          $('#log-con').load( text_path);
          $(".lined").linedtextarea({selectedLine: 1});
      }  
   } view_log();

   setInterval(function(){
      var pathname = window.location.pathname;
      var req = window.location.search;
      var page = req.substring(1,12);

      //Customer
      if ( pathname == '/customer-dashboard/' && page == 'action=view') {
        var hasComment = $('#hasComment').val();
          if ( hasComment == 'true' ) {
              $.getCommentsUser( 'notification_admin_user' );
          }
      }

      //supplier
      if ( pathname == '/supplier-dashboard/' && page == 'action=view') {
        var hasComment = $('#hasComment').val();
          if ( hasComment == 'true' ) {
             $.getCommentsUser( 'notification_admin_supplier' );
          }
      }

      //Admin
      if ( pathname == '/admin-dashboard/' && page == 'action=view' ) {
          $.getCommentsAdmin( 'notification_admin_user' );
          $.getCommentsAdmin( 'notification_admin_supplier' );
      }

      //Empoyee
      if ( pathname == '/employee-dashboard/' && page == 'action=view' ) {
          $.getCommentsAdmin( 'notification_admin_user' );
          $.getCommentsAdmin( 'notification_admin_supplier' );
      }


   }, 6000);

   $('tr[data-href]').on("click", function() {
    document.location = $(this).data('href');
   });

   // $('#logout-btn').click(function(){
   //    var href = $('#log-href').val();
   //    var msg = $.getCurrentDate('date_time') +' ---- logout ---- ';
      
   //    if($.send_log_changes( msg )){
   //      window.location.href = href;
   //    }
      
   // });

   $('.submit').click(function(){
   		
   		var fname 		 	  = $('#fname').val(),
   			lname 		 	  = $('#lname').val(),
   			company_name 	  = $('#company_name').val(),
   			phone 		 	  = $('#phone').val(),
   			card  		 	  = $('#card').val(),
   			country		 	  = $('#country').val(),
   			address			  = $('#address').val(),
   			email			  = $('#email').val(),
   			pass			  = $('#pass').val(),
   			cpass			  = $('#cpass').val(),
   			secret_question	  = $('#secret_question').val(),
   			sanswer			  = $('#sanswer').val();

   			var noError = false;
   			var noPassError = false;
   			var noPassErrorChar = false;
   			var noErrorEmail = false;

   			if ( pass === cpass ) {
	   			noPassError = true;
	   		} else {
	   			console.log('password not match');
	   			noPassError = false;
	   		}

	   		if ( cpass.length < 5 ) {
	   			console.log( cpass.length );
	   			noPassErrorChar = false;
	   		} else {
	   			noPassErrorChar = true;
	   		}

	   		if ( ! isEmail( email ) ) { 
	   				noErrorEmail = false;
	   		} else {
	   				noErrorEmail = true;
	   		}

   			if ( !fname ) { noError = false; } 
   			else if ( !lname ) { noError = false; } 
   			else if ( !company_name ) { noError = false; } 
   			else if ( !phone ) { noError = false; } 
   			else if ( !country ) { noError = false; } 
   			else if ( !address ) { noError = false; } 
   			else if ( !email ) { noError = false; } 
   			else if ( !pass ) { noError = false; } 
   			else if ( !cpass ) { noError = false; } 
   			else if ( !secret_question ) { noError = false; } 
   			else if ( !sanswer ) { noError = false; } 
   			else { noError = true; }	   		

	   	   	if ( ! noError ) {
	   	   		$('.err-container').fadeIn();
	   	   		$('.err-msg').empty();
   				$('.err-msg').append( 'All fields are required' );
   				return false;	
   					
   			} else {

   				if ( ! noPassError ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Please enter the same password in the two password fields.' );
	   				return false;
   				} else if ( ! noPassErrorChar ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Password must contain 5  characters or more.' );
	   				return false;
   				} else if ( ! noErrorEmail ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Email is invalid.' );
	   				return false;
   				} else {
            console.log('no errors at all');
   					return true;
   				}
   			}		
   });


   function isEmail( $email ) {
     var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     return regex.test( $email );
   }

   function checkIfEmpty( $arr ) {
   
      $.each( $arr, function( index, value ) {
         // console.log( value );
         if ( value == '' ) {
            return false;
         }
      });

      return true;
   }

   $('#email').keyup(function(){

      if ( ! isEmail( $(this).val() ) ) {

         $('.email-checker').empty().append('Invalid Format').css('color', '#F90000');
         $('#profile').prop( 'disabled', true );

      } else {

         $('.email-checker').empty().append('Checking your email...').css('color', '#585454');

      }

      if ( $(this).val() === '' ) {
         $('.email-checker').empty();
      }
   });

   $('#email').change(function(){

      var email         = $('#email').val(),
          currentemail  = $('input[name=current-email]').val();
      if ( currentemail ) {

         if ( email != currentemail && isEmail( email ) ) {

            $.get(sheldz_ajax.ajaxUrl + '?action=check-email&email=' + email, function(response) {
               if (response.data[0]) {

                  console.log( 'Email is invalid' ); 
                  $('.email-checker').empty().append('Email is in used already').css('color', '#F90000');
                  $('#profile').prop( 'disabled', true );
               } else {

                  //console.log('Email is valid');
                  $('.email-checker').empty().append('Valid Email').css('color', '#3E9025');
                 
                  var arr = $('.profile').map(function () { return this.value;}).get();

                  if ( checkIfEmpty( arr ) ) {
                     $('#profile').prop( 'disabled', false );
                  } else {
                     $('#profile').prop( 'disabled', true );
                  }
                  

               }

            });

         }

      } else {

         var email = $('#email').val();
         // console.log( 'undefined ang current' );
         if ( isEmail(email) ) {
            $.get(sheldz_ajax.ajaxUrl + '?action=check-email&email=' + email, function(response) {
                if (response.data[0]) {

                   $('.err-container').fadeIn();
                   $('.err-msg').empty();
                   $('.err-msg').append( 'Email already exists!' );
                   $('#admin-email').removeClass('valid-email');
                   $('#admin-email').addClass('invalid-email');
                   $('#check-email').val('false');

                } else {
                  $('#admin-email').removeClass('invalid-email');
                  $('#admin-email').addClass('valid-email');
                  $('#check-email').val('true');
                  $('.err-container').fadeOut();
                  //console.log('Email is valid');

                }
            });
         }
         

      

      }

   });

   $('#cpass-btn').click(function(){

      if ( $('#current').val() == '' ) {
         $('.error').empty().append('All fields are required.').fadeIn();
         return false;
      }

      if ( $('#cpass').val().length < 5  ) {
         $('.error').empty().append('Password must contain 5 characters or more.').fadeIn();
         return false;
      }  

      if ( $('#npass').val() != $('#cpass').val() ) {
         $('.error').empty().append('Please enter the same password in the two password fields.').fadeIn();
         return false;
      } 

    var current_password = $('#current').val(),
        hash  = $('#hash').val(),
      password = $('#cpass').val();
      $('html').css('cursor', 'wait');
      $(this).css('background', '#ADB6B7').attr('value', 'Changing Password..');
      var btn = $(this);
     
     $.get(sheldz_ajax.ajaxUrl + '?action=change-user-password&pass='+password+'&current='+current_password+'&hash='+hash, function(response) {
          // console.log(response.data);
          $('body').css('cursor', 'default');
          btn.css('background', '#DDF3FB').attr('value', 'Update Profile');
          
          if (response.data == 'success') {
            $('.error').fadeOut(0);
            $('.scp').empty().append('User Profile Updated.').fadeIn();
            $('.pass-frame input[type=password]').val('');
             //save action to log
             var msg = $.getCurrentDate('date_time') +' - Updated his/her profile Password by - ';
             $.send_log_changes( msg );

          } else {
            $('.pass-frame input[type=password]').val('');
            $('.error').empty().append('Your current password didn\'t match.').fadeIn();
          }
      });
    
   });

   $('.bill-add').click(function(){
      var country = $('input[name=billing_country]').val();
      $('#billing_country option[value='+country+']').attr('selected','selected');
   });
   $('.shipping').click(function(){
      var country = $('input[name=shipping_country]').val();
      $('#shipping_country option[value='+country+']').attr('selected','selected');
   });

   $('.reply').keyup(function(){
    $(this).hasScrollBar();
    var content = $(this).val();
    var parent = $(this).closest('.comment-editor');

      if ( content == '' ) {
        parent.find('.reply-btn').css('height', '40px');
        $(this).css('height', '40px');
      } else {
        parent.find('.reply-btn').css('height', parent.height() );
      }
   });

   $('.reply-btn').click(function(){
      var d = new Date();

      var month = d.getMonth()+1;
      var day = d.getDate();

      var datetime = d.getFullYear() + '-' +
          (month<10 ? '0' : '') + month + '-' +
          (day<10 ? '0' : '') + day;

      datetime += 'T'+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds() +'Z';
      var   parent        = $(this).closest('.reply-container');
      var   post_id       = parent.find('#post_id').val();
      var   content       = parent.find('.reply').val();
      var   display_name  = parent.find('#name').val();
      var   user          = parent.find('#user').val();
      $(".comment-list").scrollTop($(".comment-list")[0].scrollHeight);
      var output ='';
      if ( content != '' ) {
         output += '<li>';
         output +=   '<div class="single-comment">';
         output +=      '<p>'+display_name+' <span class="time-ago"><time class="timeago" datetime="'+datetime+'">Just now</time></span></p>';
         output +=      '<span>'+content+'</span>';
         output +=   '</div>';
         output += '</li>';
         
         // $('#reply-list').append( output );
         parent.find('.reply-list').append( output );
         parent.find('.reply').val('');
         parent.find('.reply').css('height', '40px');

        
        $.get(sheldz_ajax.ajaxUrl + '?action=add-reply&post-id='+post_id+'&reply='+content+'&user='+user, function(response) { 
            console.log(response.data);
            console.log('reply save');
            $("time.timeago").timeago();
            $(".comment-list").scrollTop($(".comment-list")[0].scrollHeight);

            //saving action log
            var who;
            if ( user == 'notification_admin_user' ) {
              who = 'customer';
            } else {
              who = 'supplier';
            }
            var msg = $.getCurrentDate('date_time') +' - Replied from '+who+' question by - ';
            $.send_log_changes( msg );
        });
      }
   });

   $('.nav-a').click(function(){
      $('.nav-a').removeClass('dash-active');
      $(this).addClass('dash-active');
   });


   // notif();
   function notif() {
      
      var badge = $('.badge').map(function () { 
         var ids = this.id;
         return ids;
      }).get();

      $.each( badge, function( index, value ) {
         // console.log( value );
         var post_id = value;
         $.get(sheldz_ajax.ajaxUrl + '?action=check-notif&post-id='+post_id, function( response ) { 
            
            if ( response.data.length > 0 ) {
               $('#'+value).empty().append( response.data.length ).fadeIn();
            }
         });

      });
   }

   $(document) 
   .on('click', '.add-note', function (){
      var container = $('.post-order-notes');
      $(this).closest('.notes').remove();
      
      if ( $('.add-note-holder').checkElementCount() > 0 ) {
        $('.add-note-holder').remove();
      }  

      if ( $('.notsave').checkElementCount() < 1 ) {
        var el = '';
          el +='<div class="notes notsave">';
           el +='<form method="post">';
              el +='<p>';
                 el +='<textarea id="nc" class="note-content" name="note-content" placeholder="Content...">';
                 el +='</textarea>';
              el +='</p>';
              el +='<div class="note-action-div">';
                 el +='<input class="save-note btn" type="button" value="Save">';
                 el +='<input class="cancel-note btn" type="button" value="Cancel">';
              el +='</div>';
           el +='</form>';  
          el +='</div>';
        container.append(el);
      } 
      
   })
   .on('click', '.save-note', function(){
      var container = $(this).closest('.post-order-notes .notsave'),
          title     = $('#nt').val(),
          content   = $('#nc').val(),
          d         = $.getCurrentDate();
     
     if (content == "")
      return;

      container.html('');
      var el = '';

      el +='<span class="note-date">'+d+'</span>';
      el +='<p class="note-content">'+nl2br(content)+'</p>';
      el +='<input type="hidden" id="n-title" name="n-title" value="'+title+'">';
      el +='<input type="hidden" id="n-date" name="n-date" value="'+d+'">';
      el +='<input type="hidden" id="n-content" name="n-content" value="'+content+'">';
      container.append( el );
      $('.notes').removeClass('notsave');

      var arr       = $('.notes').getElementArr(),
          action    = 'save-post-order-notes',
          post_id   = $('#post_id').val();

      $.ajax({
         url: sheldz_ajax.ajaxUrl,
         type: 'POST',
         data: {
            notes:  arr,
            postid: post_id,
            action: action
         },
         dataType: 'json',
         success: function( response ) {
            var msg = $.getCurrentDate('date_time') +' - Added Post Order Note - by - ';
            $.send_log_changes( msg );
            console.log( response.data );
         },
         error: function(e){
            console.log(e);
         }
      })
   })
   .on('click', '.cancel-note', function(){

      var container = $('.post-order-notes');
      var count = $('.notes').checkElementCount();

      if ( count > 1 ) {
        $(this).closest('.notes').remove();
      } else {
         container.html('');
         var el ='';
         el+='<div class="notes add-note-holder">';
           el +='<center>';
              el +='<p>Add Notes</p>';
              el +='<p><button class="add-note" type="submit" name="upload-image">Add</button></p>';
           el +='</center>';
         el+='</div>';
         container.append( el );
      }
   })
   .on('click', '.cancel-edit', function(){

      var container = $('.post-order-notes .notes'),
          title     = $('.default-title').val(),
          content   = $('.default-content').val();
      
      var currentdate = new Date(); 
      var datetime = currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + "  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();

      container.html('');     
         var el = '';
             el +='<h3 class="note-title">'+title+'</h3>';
             el +='<span class="note-date">'+datetime+'</span>'
             el +='<p class="note-content">'+nl2br(content)+'</p>';
         container.append(el);
   })
   .on('click', '.edit-notes', function(){
      var title     = $('.note-title').text(),
          content   = $('.note-content').text(),
          action    = 'save-post-order-notes',
          container = $('.post-order-notes .notes');
         
      container.html('');
      var el = '';
      el +='<form method="post">';
         el +='<p>';
            el +='<input class="note-title" type="text" name="note-title" placeholder="Note Title" value="'+title+'">';
         el +='</p>';
         el +='<p>';
            el +='<textarea class="note-content" name="note-content">';
            el += content.replace("<br>", "\ln");
            el +='</textarea>';
         el +='</p>';
         el +='<div class="note-action-div">';
            el +='<input class="save-note btn" type="button" value="Save">';
            el +='<input class="cancel-edit btn" type="button" value="Cancel">';
            el +='<input class="default-title" type="hidden" name="default" value="'+title+'">';
            el +='<input class="default-content" type="hidden" name="default" value="'+content+'">';
         el +='</div>';
      el +='</form>';

      container.append(el);
      $('.note-content').hasScrollBar();
   });

   function nl2br(str, is_xhtml) {
       var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
       return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
   }

   $(document)
   // .on('click', '.ctab', function(){
   //    $(this).addClass('active-tab');
   //    $('.stab').removeClass('active-tab');
   // })
   // .on('click', '.stab', function(){
   //    $(this).addClass('active-tab');
   //    $('.ctab').removeClass('active-tab');
   // })
   .on('keypress', '#nc', function(e){
      if(e.which == 13) {
         $('#nc').hasScrollBar();
      }
   })
   .on('keyup', '#nc', function(){
      $('#nc').hasScrollBar();
   });

   //tabs for customer and supplier
   // $(document)
   // .on('click', '.ctab', function(){
   //    $('.ctab-content').fadeIn(0);
   //    $('.stab-content').fadeOut(0);
   // })
   // .on('click', '.stab', function(){
   //    $('.stab-content').fadeIn(0);
   //    $('.ctab-content').fadeOut(0);
   // })

   //customer dashboard
   $(document)
   .on('click', '.approval', function(){
      var post_id = $('#postid').val(),
          action = 'accept-artwork';
      $.ajax({
        url: sheldz_ajax.ajaxUrl,
        type: 'POST',
        data: {
          action: action,
          postid: post_id
        },
        dataType: 'json',
        success: function(response) {
          $('.approval').html('').append('Artwork Confirmation Sent.');
        }
      })
   });

   $(document)
   .on('click', '#create-user', function(){
      if ( $('#user-fname').val() == "") {
        create_error(); return false;
      }

      if ( $('#user-lname').val() == "") {
        create_error(); return false;
      }

      if ( $('#email').val() == "") {
        create_error(); return false;
      }

      if ( $('#user-pass').val() == "") {
        create_error(); return false;
      }

      if ( $('#user-role').val() == "") {
        create_error(); return false;
      }

      if ( $('#check-email').val() != "true" ) {
        return false;
      }
      var btn = $(this);
      btn.val('Creating User...')
      .css({'cursor':'wait', 'background':'#7D7D7D'})
      .prop( "disabled", true );

      var fname = $('#user-fname').val(),
          lname = $('#user-lname').val(),
          email = $('#email').val(),
          pass  = $('#user-pass').val(),
          role  = $('#user-role').val(),
          action= 'save-user-made-by-admin';

      $.ajax({
        url: sheldz_ajax.ajaxUrl,
        type: 'POST',
        data: {
          action: action,
          fname: fname,
          lname: lname,
          email: email,
          role: role,
          pass: pass
        },
        dataType: 'json',
        success: function( response ) {

          btn.val('Creat User')
          .css({'cursor':'pointer', 'background':'#1A80B6'})
          .prop( "disabled", false );

          var con = $('.suc-container');
          var err = $('.err-msg');

          con.fadeIn();
          err.html('');
          err.append('New '+role+ ' is added.');

          var table = $('.admin-users');
          var el = '';

          el+='<tr>';
              el+='<td><input class="cbox" type="checkbox" name="check" value="'+response.data+'"> '+fname+' '+lname+'</td>';
              el+='<td>'+email+'</td>';
              el+='<td>'+role+'</td>';
              el+='<input type="hidden" id="user_id" value="'+response.data+'">';
          el+='</tr>';
          table.prepend(el);

          //remove all values - empty
          $('#user-fname').val('');
          $('#user-lname').val('');
          $('#email').val('');
          $('#user-pass').val('');
          $('#user-role').val('');
          $('#admin-email').removeClass('valid-email');

          //save action to log
          var msg = $.getCurrentDate('date_time') +' - New '+role+' ('+email+') was created by - ';
          $.send_log_changes( msg );
        },
        error: function(e) {
          console.log(e);
        } 
      });
   })

   function create_error(){
      var con = $('.err-container');
      var err = $('.err-msg');

      con.fadeIn();
      err.html('');
      err.append('All fields are required');

      return false
   }

  $(document)
  .on('click', '.cbox', function(){
     var allVals = new Array();
     var checked = $('.cbox:checked');
     $.each( checked, function(index, value){
        // allVals.push(count, $(this).val());
        allVals.push( $(this).val() );
     });
    $('#selected-ids').val( JSON.stringify(allVals) );
    console.log( allVals ); 
  })
  .on('click', '#logout', function() {
    $('.logout').submit();
  })
  .on('click', '#set-date', function(){
    var d = $('.log-date').val();
    console.log(d);
    var text_path = '/wp-content/themes/wristbandcreation/templates/logs/'+d+'.txt';
    $('.linedwrap').remove();

    var el ='<textarea class="lined" id="log-con" name="log-text">';
    $('.logcon').append(el);

   $('#log-con').load( text_path );
   $(".lined").linedtextarea({selectedLine: 1});
  })
  .on('click', '.order_edit_form', function(){
    $('#order-edit').submit();
  })
  .on('click', '#send_report', function(){
    var text = $('#addpost').val();
    if ( text == '' ) {
      return false;
    }
  })
  .on('click', '#send-report-supp', function(){
    var text = $('#addpost').val();
    if ( text == '' ) {
      return false;
    }
  });

  /*
  * Filter Search for dashboards
  */
  $('#filter-search').change(function(){
    var filter = $('#filter-search').val();
    // console.log(filter);
    if ( filter == 'method' ) {
        $('#keyword').remove();
        var x ='';
        x+='<select id="keyword" name="k">';
          x+='<option value="PayPal">PayPal</option>';
          x+='<option value="Credit Card Payment">Credit Card</option>';
        x+='</select>'
        $('.keyword-con').append(x);
    } else if ( filter == 'status' ) {
        $('#keyword').remove();
        var x ='';
        x+='<select id="keyword" name="k">';
          x+='<option value="pending_production">Pending Production</option>';
          x+='<option value="pending_artwork_approval">Pending Artwork Approval</option>';
          x+='<option value="in_production">In Production</option>';
          x+='<option value="in_reproduction">In Reproduction</option>';
          x+='<option value="produced_pending_shipment">Produced Pending Shipment</option>';
          x+='<option value="shipped">Shipped</option>';
        x+='</select>'
        $('.keyword-con').append(x);
    } else if ( filter == 'date' ) {
       var x='';
       $('#keyword').remove();
       x+='<input id="keyword" type="date" name="k" placeholder="Search">';
       $('.keyword-con').append(x);
    } else {
      var x='';
      $('#keyword').remove();
      x+='<input id="keyword" type="text" name="k" placeholder="Search">';
      $('.keyword-con').append(x);
    }
  });

  /*
  * Filter Search in Reporting Page
  */
  $(document)
    .on('click', '#reset-btn', function(){
    $('#search-from').val('');
    $('#search-to').val('');
    console.log('hi');
    })
    .on('click', '.search-btn', function(){
      var frm = $('#search-from').val();
      var to  = $('#search-to').val();

      if ( frm == '' || to == '' ) {
        return false;
      }
    })


});