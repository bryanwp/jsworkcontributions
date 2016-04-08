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

   setInterval(function(){
      var pathname = window.location.pathname;
      var req = window.location.search;
      var page = req.substring(1,12);
      
      if ( pathname == '/customer-dashboard/' && page == 'action=view') {
          $.getCommentsUser();
      }

      if ( pathname == '/admin-dashboard/' && page == 'action=view' ) {
          $.getCommentsAdmin();
      }


   }, 6000);

   $('tr[data-href]').on("click", function() {
    document.location = $(this).data('href');
   });

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
         $.get(sheldz_ajax.ajaxUrl + '?action=check-email&email=' + email, function(response) {
            if (response.data[0]) {

               $('.err-container').fadeIn();
               $('.err-msg').empty();
               $('.err-msg').append( 'Email already exists!' );

            } else {

               $('.err-container').fadeOut();
               console.log('Email is valid');

            }

         });

      }

   });

   $('#pass').click(function(){

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
      password = $('#cpass').val();

   $.get(sheldz_ajax.ajaxUrl + '?action=change-user-password&pass='+password, function(response) {
            
               console.log(response.data);
   

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

      adjustTextarea(this);
      function adjustTextarea(id){
      var txt = $(id),
      hiddenDiv = $(document.createElement('div')),
      content = null;

      txt.addClass('noscroll');
      hiddenDiv.addClass('hiddendiv');

      $('body').append(hiddenDiv);
       width = txt.width();
       content = txt.val();
       content = content.replace(/\n/g, '');
       hiddenDiv.html(content);
       txt.css('height', hiddenDiv.height());



      txt.bind('keyup', function() {

          content = txt.val();
          content = content.replace(/\n/g, '');
          hiddenDiv.html(content);

          
          if ( content == '' ) {
            txt.css('height', '40px');
            $('.reply-btn').css('height', '40px');
          } else {
            txt.css('height', hiddenDiv.height());
            $('.reply-btn').css('height', hiddenDiv.height());
          }
      });
   }
      var width = $('.reply').innerWidth();
      $('.hiddendiv').width( width );
   });

   $('.reply-btn').click(function(){
      var d = new Date();

      var month = d.getMonth()+1;
      var day = d.getDate();

      var datetime = d.getFullYear() + '-' +
          (month<10 ? '0' : '') + month + '-' +
          (day<10 ? '0' : '') + day;

      datetime += 'T'+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds() +'Z';
      var   post_id = $('#post_id').val();
      var   content = $('.reply').val();
      var   display_name = $('#name').val();

      var output ='';
      if ( content != '' ) {
         output += '<li>';
         output +=   '<div class="single-comment">';
         output +=      '<p>'+display_name+' <span class="time-ago"><time class="timeago" datetime="'+datetime+'">Just now</time></span></p>';
         output +=      '<span>'+content+'</span>';
         output +=   '</div>';
         output += '</li>';
         
         $('#reply-list').append( output );
         $('.reply').val('');
         $('.reply').css('height', '40px');

          $.get(sheldz_ajax.ajaxUrl + '?action=add-reply&post-id='+post_id+'&reply='+content, function(response) { 
            console.log(response.data);
            console.log('reply save');
            $("time.timeago").timeago();
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

   $('.width').click(function(){
        var width = $(this).val();
        console.log(width);
         $(this).empty();
         $(this).append('<option value="1/2">1/2 inch</option>');
         $(this).append('<option value="3/4">3/4 inch</option>');
         $(this).append('<option value="1">1 inch</option>');
         $(this).append('<option value="1/4">1/4 inch</option>');
   });

   $('.save-artwork ').click(function(){
      $('#admin-artwork-form').submit();
   });

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
          post_id   = $('input[name=post-id]').val();

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
   })

   function create_error(){
      var con = $('.err-container');
      var err = $('.err-msg');

      con.fadeIn();
      err.html('');
      err.append('All fields are required');

      return false
   }

});